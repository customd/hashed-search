<?php

namespace CustomD\HashedSearch;

use Transliterator;
use RuntimeException;
use Illuminate\Support\Str;

class HashedSearch
{

    private $salt;
    private $cypherA;
    private $cypherB;

    private \Transliterator $transliterator;


    public function __construct(array $config)
    {
        $this->setUpSalt($config['salt'] ?? null);
        $this->setupTransliterator($config['transliterator_rule'] ?? null);
        $this->setupHashes($config['cypher_a'], $config['cypher_b']);
    }


    public function create(?string $value, string $salt_modifier = ""): ?string
    {
        //Nothing to hash here!
        if (strlen($value) === 0 || $value === null) {
            return null;
        }

        $prepared_value = strtolower($this->transliterator->transliterate($value));

        return bin2hex(hash($this->cypherA, $prepared_value . $this->salt . $salt_modifier, true) ^ hash($this->cypherB, $salt_modifier . $this->salt . $prepared_value, true));
    }


    private function setUpSalt(?string $salt): void
    {
        throw_if(strlen($salt) === 0 or $salt === null, RuntimeException::class, 'No hashing salt has been specified.');

        // If the salt starts with "base64:", we will need to decode it before using it
        if (Str::startsWith($salt, 'base64:')) {
            $salt = base64_decode(substr($salt, 7));
        }

        $this->salt = $salt;
    }

    private function setupTransliterator(?string $rule): void
    {
        throw_if(strlen($rule) === 0 or $rule === null, RuntimeException::class, 'No hashing salt has been specified.');
        $this->transliterator  = Transliterator::createFromRules($rule, Transliterator::FORWARD);
    }

    private function setupHashes(?string $cypherA, ?string $cypherB)
    {
        $this->cypherA = $cypherA ?? 'sha512';
        $this->cypherB = $cypherB ?? 'whirlpool';
    }
}
