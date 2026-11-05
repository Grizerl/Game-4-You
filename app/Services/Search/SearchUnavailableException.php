<?php

namespace App\Services\Search;

use RuntimeException;

/**
 * Пошуковий рушій вимкнений або недоступний (транспортна помилка, таймаут, 5xx).
 */
class SearchUnavailableException extends RuntimeException {}
