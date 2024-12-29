<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductVariant extends Model
{
    protected $table = 'product_variants';
    protected $fillable = [
        'size',
        'color',
        'price',
        'quantity',
        'sku',
        'product_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('quantity', function (Builder $builder) {
            $builder->where('quantity', '>', 0)
                ->where('active', 1)
                ->orderByRaw('LENGTH(size)', 'ASC')
                ->orderBy('size', 'ASC');
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
