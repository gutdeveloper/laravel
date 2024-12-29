<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function saveImageRecords(Product $product, array $imageUrls): void
    {
        $imageData = array_map(fn($url) => [
            'url' => $url,
            'product_id' => $product->id,
        ], $imageUrls);

        $product->images()->createMany($imageData);
    }
}
