<?php

namespace CustomD\HashedSearch\Facades;

use Illuminate\Support\Facades\Facade;

class HashedSearch extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hashed-search';
    }
}
