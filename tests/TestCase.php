<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        $_SERVER['APP_ENV'] = 'testing';
        putenv('APP_ENV=testing');
        parent::setUp();
    }
}