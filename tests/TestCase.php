<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Без Accept-Language локалізація редіректить на /en; тести працюють у дефолтній (uk) локалі.
        $this->withHeader('Accept-Language', config('app.locale'));
    }
}
