<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProducts()
    {
        $allProducts = Product::where('status', 1)->inRandomOrder()->select('id', 'name', 'slug', 'weight', 'purity', 'category', 'image', 'price')->get();

        foreach ($allProducts as $data) {
            $data->image = asset($data->image);
        }
        return response([
            'message' => 'All Products',
            'status' => 'success',
            'allproducts' => $allProducts,
            'code' => 200
        ], 200);
    }


    public function goldCatProducts()
    {
        $allProducts = Product::where('status', 1)->where('category', "Gold")->inRandomOrder()->select('id', 'name', 'slug', 'weight', 'purity', 'category', 'image', 'price')->get();

        foreach ($allProducts as $data) {
            $data->image = asset($data->image);
        }
        return response([
            'message' => 'Gold Category All Products',
            'status' => 'success',
            'allproducts' => $allProducts,
            'code' => 200
        ], 200);
    }


    public function silverCatProducts()
    {
        $allProducts = Product::where('status', 1)->where('category', "Silver")->inRandomOrder()->select('id', 'name', 'slug', 'weight', 'purity', 'category', 'image', 'price')->get();

        foreach ($allProducts as $data) {
            $data->image = asset($data->image);
        }
        return response([
            'message' => 'Silver Category All Products',
            'status' => 'success',
            'allproducts' => $allProducts,
            'code' => 200
        ], 200);
    }



    public function productDetail($id)
    {
        $data = Product::with('rate')->where('status', 1)->where('id', $id)->first();
        $data->image = asset($data->image);

        return response([
            'message' => 'Product Details',
            'status' => 'success',
            'product' => $data,
            'code' => 200
        ], 200);
    }
}
