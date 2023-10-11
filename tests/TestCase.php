<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Seed database before each test.
     *
     * @var bool $seed
     */
    protected bool $seed = true;
}
