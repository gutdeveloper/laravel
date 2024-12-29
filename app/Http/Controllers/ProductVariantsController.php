<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductVariantsController extends Controller
{
    private $productVariant;
    private $product;
    public function __construct(ProductVariant $productVariant, Product $product)
    {
        $this->product = $product;
        $this->productVariant = $productVariant;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size' => 'required|string',
            'color' => 'required|string',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer',
            'product_id' => 'required|exists:products,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $product = $this->product->withoutGlobalScope('quantity')->find($request->product_id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $sku = $product->reference . '-' . $request->size;
        $request->merge(['sku' => $sku]);
        $productVariant = $this->productVariant->create($request->all());
        return response()->json($productVariant);
    }
}
