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

    public function edit($id)
    {
        $rates = Rate::latest()->get();
        $data = Product::findOrFail($id);
        return view('admin.product.edit', compact('data', 'rates'));
    }


    public function update(Request $request)
    {

        $id = $request->id;
        $old_img = $request->old_image;


        $rate = Rate::findOrFail($request->input('rate_id'));
        $price = $request->weight  * $rate->amount;

        if ($request->file('image')) {
            unlink($old_img);
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1100, 1100)->save('storage/product/' . $name_gen);
            $save_url = 'storage/product/' . $name_gen;

            Product::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'weight' => $request->weight,
                'purity' => $request->purity,
                'content' => $request->content,
                'category' => $request->category,
                'image' => $save_url,
                'price' => $price,
                'rate_id' => $request->rate_id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated with Image Successfully',
                'alert-type' => 'success'

            );
            return redirect()->route('product-index')->with($notification);
        } else {

            Product::findOrFail($id)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'weight' => $request->weight,
                'purity' => $request->purity,
                'content' => $request->content,
                'category' => $request->category,
                'price' => $price,
                'rate_id' => $request->rate_id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Product Updated without Image Successfully',
                'alert-type' => 'success'

            );
            return redirect()->route('product-index')->with($notification);
        }
    }
}
