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
    private $iterationCount;
    private $trimEnabled;

    private Transliterator $transliterator;


    public function __construct(array $config)
    {
        $this->setSalt($config['salt'] ?? null)
        ->setTransliterator($config['transliterator_rule'] ?? null)
        ->setHashes($config['cypher_a'], $config['cypher_b'])
        ->setIterationCount($config['iteration_count'])
        ->setTrimEnabled($config['trim_hash']);
    }


    public function create(?string $value, string $saltModifier = ""): ?string
    {
        //Nothing to hash here!
        if (strlen($value) === 0 || $value === null) {
            return null;
        }

        $preparedValue = strtolower($this->transliterator->transliterate($value));

        return $this->iterationCount === null ?
        $this->trimIfRequired(
            bin2hex(hash($this->cypherA, $preparedValue . $this->salt . $saltModifier, true) ^ hash($this->cypherB, $saltModifier . $this->salt . $preparedValue, true))
        )
        :
        $this->trimIfRequired(
            hash_pbkdf2($this->cypherA, $preparedValue, $this->salt . $saltModifier, $this->iterationCount, 32)
        );
    }


    protected function trimIfRequired($hash)
    {
        return $this->trimEnabled ? substr($hash, 0, 100) : $hash;
    }


    public function setSalt(string $salt): self
    {
        throw_if(blank($salt), RuntimeException::class, 'No hashing salt has been specified.');

        // If the salt starts with "base64:", we will need to decode it before using it
        if (Str::startsWith($salt, 'base64:')) {
            $salt = base64_decode(substr($salt, 7));
        }

        $this->salt = $salt;

        return $this;
    }

    public function setTransliterator(string $rule): self
    {

        throw_if(blank($rule), RuntimeException::class, 'No transliterator rule has been specified.');
        $this->transliterator  = Transliterator::createFromRules($rule, Transliterator::FORWARD);

        return $this;
    }

    public function setHashes(?string $cypherA = null, ?string $cypherB = null): self
    {
        $this->cypherA = $cypherA ?? $this->cypherA ?? 'sha512';
        $this->cypherB = $cypherB ?? $this->cypherB ?? 'whirlpool';

        throw_if(strlen($this->cypherA) === 0 or $this->cypherA  === null, RuntimeException::class, 'No primary hash has been specified.');
        throw_if(strlen($this->cypherB) === 0 or $this->cypherB  === null, RuntimeException::class, 'No secondary hash has been specified.');

        return $this;
    }

    public function setIterationCount(?int $count): self
    {
        $this->iterationCount = $count;
        return $this;
    }

    public function setTrimEnabled(bool $enabled): self
    {
        $this->trimEnabled = $enabled;
        return $this;
    }
}
