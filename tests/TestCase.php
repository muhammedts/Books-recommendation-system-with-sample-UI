<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // The UI loads Bootstrap from a CDN; never require built front-end assets in tests.
        $this->withoutVite();
    }
}
