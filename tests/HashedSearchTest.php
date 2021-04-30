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

    public function test_same_app_salt_hash(): void
    {
        $this->assertEquals(HashedSearch::create("random"), HashedSearch::create("Random"));
    }

    public function test_different_app_salt_hash(): void
    {
        $this->assertNotEquals(HashedSearch::create("random"), HashedSearch::setSalt("this is a new salt")->create("random"));
    }

    public function test_different_value(): void
    {
        $this->assertNotEquals(HashedSearch::create("random"), HashedSearch::create("randon"));
    }

    public function test_different_salt_modifier(): void
    {
        $this->assertNotEquals(HashedSearch::create("random", 'funny'), HashedSearch::create("Random"));
    }
}
