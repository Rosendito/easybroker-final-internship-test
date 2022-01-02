<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Load stub file
     *
     * @param string $filename
     * @return string|null
     */
    protected function loadStub(string $filename): ?string
    {
        return file_get_contents(__DIR__ . '/stubs/' . $filename);
    }
}
