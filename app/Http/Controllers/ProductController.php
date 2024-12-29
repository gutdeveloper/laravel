<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    private $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function get()
    {
        $products = $this->product->all();
        return response()->json($products);
    }

    public function getProductByReference($reference)
    {
        $product = $this->product->where('reference', $reference)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'reference' => 'required|string|unique:products',
            'description' => 'required|string',
            'active' => 'required|boolean|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = $this->product->create($request->all());
        return response()->json($product);
    }
}
