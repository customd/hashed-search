<?php

namespace CustomD\HashedSearch\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use CustomD\HashedSearch\Facades\HashedSearch;
use CustomD\HashedSearch\Models\HashedSearch as ModelsHashedSearch;

trait HasSearchableHash
{
     /**
     * Boot the Encryptable trait for a model.
     */
    public static function bootHasSearchableHash(): void
    {
        //We need to setup hashes for this
        static::saved(function ($model) {
            $model->generateSearchHashes()->each(function ($hash, $field) use ($model) {
                ModelsHashedSearch::updateOrCreate([
                    'hash_field' => $field,
                    'hash_id'    => $model->getKey(),
                    'hash_type'  => $model->getMorphClass()
                ], [
                    'hash'       => $hash,
                ]);
            });
        });
    }

    protected function generateSearchHashes(): Collection
    {
        return collect($this->searchableHash ?? [])
            ->filter(
                fn($field) => ! blank($this->getAttribute($field))
            )
            ->mapWithKeys(
                fn ($field) => [$field => HashedSearch::create($this->getAttribute($field))]
            );
    }

    public function scopeSearchHashedField(Builder $builder, string $field, string $clearText): void
    {
        $builder->whereHas('searchHashRelation', function (Builder $builder) use ($field, $clearText) {
            $builder->where('hash_field', $field);
            $builder->where(
                'hash',
                HashedSearch::create($clearText)
            );
        });
    }

    public function scopeOrSearchHashedField(Builder $builder, string $field, string $clearText): void
    {
        $builder->orWhereHas('searchHashRelation', function (Builder $builder) use ($field, $clearText) {
            $builder->where('hash_field', $field);
            $builder->where(
                'hash',
                HashedSearch::create($clearText)
            );
        });
    }

    public function searchHashRelation()
    {
        return $this->hasMany(ModelsHashedSearch::class, 'hash_id')->where('hash_type', $this->getMorphClass());
    }
}
