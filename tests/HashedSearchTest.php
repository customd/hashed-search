<?php

namespace CustomD\HashedSearch\Tests;

use CustomD\HashedSearch\Facades\HashedSearch;
use CustomD\HashedSearch\ServiceProvider;
use Orchestra\Testbench\TestCase;

class HashedSearchTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'hashed-search' => HashedSearch::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
