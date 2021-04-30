<?php

namespace CustomD\HashedSearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static ?string create(string $value, string $saltModifier = "" )
 * @method static SELF setSalt(string salt)
 * @method static SELF setTransliterator(string rule)
 * @method static SELF setHashes(?string $cypherA = null, ?string $cypherB = null)
 *
 * @see \CustomD\HashedSearch\HashedSearch
 */

class HashedSearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hashed-search';
    }
}
