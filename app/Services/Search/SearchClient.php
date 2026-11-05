<?php

namespace App\Services\Search;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Throwable;

/**
 * Тонка обгортка над офіційним клієнтом Elasticsearch: будує його з `config/search.php`
 * і перетворює будь-яку помилку транспорту на {@see SearchUnavailableException}.
 */
class SearchClient
{
    private ?Client $client = null;

    public function __construct(private readonly bool $forIndexing = false) {}

    public function enabled(): bool
    {
        return (bool) config('search.enabled') && config('search.hosts') !== [];
    }

    public function alias(): string
    {
        return (string) config('search.index');
    }

    /**
     * Виконує виклик клієнта; помилки транспорту й 5xx стають SearchUnavailableException,
     * 4xx (наприклад, 404) пробрасуються як ClientResponseException.
     *
     * @template T
     *
     * @param  callable(Client): T  $callback
     * @return T
     */
    public function call(callable $callback): mixed
    {
        if (! $this->enabled()) {
            throw new SearchUnavailableException('Search is disabled.');
        }

        try {
            return $callback($this->client());
        } catch (ClientResponseException $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new SearchUnavailableException('Elasticsearch request failed: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Те саме, але 404 повертається як null.
     *
     * @template T
     *
     * @param  callable(Client): T  $callback
     * @return T|null
     */
    public function callOrNull(callable $callback): mixed
    {
        try {
            return $this->call($callback);
        } catch (ClientResponseException $e) {
            if ($e->getCode() === 404) {
                return null;
            }

            throw new SearchUnavailableException('Elasticsearch error: '.$e->getMessage(), 0, $e);
        }
    }

    public function forIndexing(): self
    {
        return new self(true);
    }

    private function client(): Client
    {
        if ($this->client !== null) {
            return $this->client;
        }

        $builder = ClientBuilder::create()
            ->setHosts((array) config('search.hosts'))
            ->setRetries(1)
            ->setHttpClientOptions([
                'timeout' => $this->forIndexing ? (int) config('search.index_timeout') : (int) config('search.timeout'),
                'connect_timeout' => (int) config('search.connect_timeout'),
            ]);

        if (filled(config('search.api_key'))) {
            $builder->setApiKey((string) config('search.api_key'));
        } elseif (filled(config('search.username'))) {
            $builder->setBasicAuthentication((string) config('search.username'), (string) config('search.password'));
        }

        return $this->client = $builder->build();
    }
}
