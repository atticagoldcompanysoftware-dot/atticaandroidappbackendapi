<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    public function create()
    {
        $rates = Rate::latest()->get();
        return view("admin.product.create", compact('rates'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(600, 400)->save('storage/products/' . $name_gen);
        $save_url = 'storage/products/' . $name_gen;

        $rate = Rate::findOrFail($request->input('rate_id'));
        $price = $request->weight  * $rate->amount;

        Product::insert([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'weight' => $request->weight,
            'purity' => $request->purity,
            'content' => $request->content,
            'category' => $request->category,
            'image' => $save_url,
            'price' => $price,
            'rate_id' => $request->rate_id,
            'created_at' => Carbon::now(),
        ]);


        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('product-create')->with($notification);
    }


    public function index()
    {
        $datas = Product::latest()->get();
        return view('admin.product.index', compact('datas'));
    }
}
