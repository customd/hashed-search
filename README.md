# Hashed Search

[![GitHub Workflow Status](https://github.com/custom-d/hashed-search/workflows/Run%20tests/badge.svg)](https://github.com/custom-d/hashed-search/actions)
[![Packagist](https://img.shields.io/packagist/v/custom-d/hashed-search.svg)](https://packagist.org/packages/custom-d/hashed-search)
[![Packagist](https://img.shields.io/packagist/l/custom-d/hashed-search.svg)](https://packagist.org/packages/custom-d/hashed-search)

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

## Security

An important consideration in searchable encryption is leakage, which is information an attacker can gain. Blind indexing leaks that rows have the same value. If you use this for a field like last name, an attacker can use frequency analysis to predict the values. In an active attack where an attacker can control the input values, they can learn which other values in the database match.

Here’s a [great article](https://blog.cryptographyengineering.com/2019/02/11/attack-of-the-week-searchable-encryption-and-the-ever-expanding-leakage-function/) on leakage in searchable encryption. Blind indexing has the same leakage as deterministic encryption.

## Credits

- [Custom D](https://github.com/custom-d/hashed-search)
- [All contributors](https://github.com/custom-d/hashed-search/graphs/contributors)
