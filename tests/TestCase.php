<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private static bool $seeded = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$seeded) {
            $this->seed();

            self::$seeded = true;
        }
    }
}