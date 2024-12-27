<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $table = 'products';

    public static function booted(): void
    {
        static::addGlobalScope('quantity', function (Builder $builder) {
            $builder->where('quantity', '>', 0);
        });

        static::addGlobalScope('orderBy', function (Builder $builder) {
            $builder->where('active', 1)
                ->orderBy('reference');
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
