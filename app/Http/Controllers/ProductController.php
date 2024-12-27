<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    private $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function get()
    {
        return response()->json(['Hola' => 'Mundo']);
        $products = $this->product->all();
        return response()->json($products);
    }

    public function getProductByReference($reference)
    {
        $product = $this->product->where('reference', $reference)->first();
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required|unique:posts|max:255',
            'body' => 'required',
        ]);

        $product = $this->product->create($request->all());
        return response()->json($product);
    }
}
