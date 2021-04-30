# Laravel Hashed Search

[![PHP Composer](https://github.com/customd/hashed-search/actions/workflows/php.yml/badge.svg)](https://github.com/customd/hashed-search/actions/workflows/php.yml)
[![Packagist](https://img.shields.io/packagist/v/custom-d/hashed-search.svg)](https://packagist.org/packages/customd/hashed-search)
[![Packagist](https://img.shields.io/packagist/l/custom-d/hashed-search.svg)](https://packagist.org/packages/customd/hashed-search)
[![Release](https://github.com/customd/hashed-search/actions/workflows/default.yml/badge.svg)](https://github.com/customd/hashed-search/actions/workflows/default.yml)

Package description: Package to allow hashing of encrypted data for searching

## Installation

Install via composer

```bash
composer require custom-d/hashed-search
```

### Publish package assets

```bash
php artisan vendor:publish --provider="CustomD\HashedSearch\ServiceProvider"
```

## Usage

### Eloqent Models

In your model add the `use CustomD\HashedSearch\Contracts\HasSearchableHash;` trait and add a new property `protected $searchableHash = ['bank_name'];`

Eg:

```php
<?php

namespace App\Models;

...
use CustomD\EloquentModelEncrypt\ModelEncryption;
use CustomD\HashedSearch\Contracts\HasSearchableHash;

class EncryptedModel extends Model
{
    use ModelEncryption;
    use HasSearchableHash;


    protected $searchableHash = ['encryp_column_1','encypted_column_2'];
...
}
```

Now on each save event, it will update the search hash for those columns.

To search:

```php
EncryptdModel::searchHashedField('encryp_column_1','clear text here');
```

### Manual usage

You can manually has items by running the follwing code:

```php
\CustomD\HashedSearch\Facades\HashedSearch::create('string to hash');
```

## Methods

the `\CustomD\HashedSearch\Facades\HashedSearch` Class has the following methods

- create(string $value, string $saltModifier = "" ): ?string
- setSalt(string salt): SELF
- setTransliterator(string rule): SELF
- setHashes(?string $cypherA = null, ?string $cypherB = null): SELF

## Security

An important consideration in searchable encryption is leakage, which is information an attacker can gain. Blind indexing leaks that rows have the same value. If you use this for a field like last name, an attacker can use frequency analysis to predict the values. In an active attack where an attacker can control the input values, they can learn which other values in the database match.

Here’s a [great article](https://blog.cryptographyengineering.com/2019/02/11/attack-of-the-week-searchable-encryption-and-the-ever-expanding-leakage-function/) on leakage in searchable encryption. Blind indexing has the same leakage as deterministic encryption.

## Credits

- [Custom D](https://github.com/customd)
- [All contributors](https://github.com/customd/hashed-search/graphs/contributors)
