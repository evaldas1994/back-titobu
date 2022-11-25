<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getApiHeaders() {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }
}
