<?php

return [
    'salt' => env('CD_HASHED_SEARCH_SALT', env('APP_KEY')),
    'cypher_a' => env('CD_HASHED_SEARCH_CYPHER_A', 'sha512'),
    'cypher_b' => env('CD_HASHED_SEARCH_CYPHER_B', 'whirlpool'),
    'transliterator_rule' => env('CD_TRANSLITERATOR_RULE', ':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;'),
    'iteration_count' => env('CD_HASHED_SEARCH_ITERATION_COUNT', 1000),
    'trim_hash' => env('CD_HASHED_SEARCH_TRIM', false),
];
