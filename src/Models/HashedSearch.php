<?php

namespace CustomD\HashedSearch\Models;

use Illuminate\Database\Eloquent\Model;

class HashedSearch extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'hash',
        'hash_field',
        'hash_id',
        'hash_type',
    ];
}
