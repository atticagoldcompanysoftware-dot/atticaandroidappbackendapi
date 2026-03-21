<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $userid = Auth::id();
        $productid = $request->input('product_id');
        $productDetails = Product::where('id', $productid)->get();
        $quantity = $request->input('quantity');
        $total_price = $productDetails[0]['price'] * $quantity;

        $result = Cart::insert([
            'user_id' => $userid,
            'product_id' => $productid,
            'quantity' => $quantity,
            'total_price' => $total_price,
        ]);

        return $result;
    }

    public function CartItemPlus($id)
    {
        $userid = Auth::id();

        $cartItem = Cart::with('product')
            ->where('id', $id)
            ->where('user_id', $userid)
            ->first();

        if (!$cartItem || !$cartItem->product) {
            return response()->json([
                'message' => 'Cart item not found',
            ], 404);
        }

        $newQuantity = $cartItem->quantity + 1;
        $total_price = $newQuantity * $cartItem->product->price;

        $result = Cart::where('id', $id)
            ->where('user_id', $userid)
            ->update([
                'quantity' => $newQuantity,
                'total_price' => $total_price,
            ]);

        return $result;
    }


    public function CartItemMinus($id)
    {
        $userid = Auth::id();

        $cartItem = Cart::with('product')
            ->where('id', $id)
            ->where('user_id', $userid)
            ->first();

        if (!$cartItem || !$cartItem->product) {
            return response()->json([
                'message' => 'Cart item not found',
            ], 404);
        }

        $newQuantity = $cartItem->quantity - 1;
        $total_price = $newQuantity * $cartItem->product->price;

        $result = Cart::where('id', $id)
            ->where('user_id', $userid)
            ->update([
                'quantity' => $newQuantity,
                'total_price' => $total_price,
            ]);

        return $result;
    }




    public function CartList()
    {

        $id = Auth::id();
        $result = Cart::with('product')->where('user_id', $id)->get();
        $total_amount = Cart::where('user_id', $id)->sum('total_price');
        return response()->json([
            'total_amount' => $total_amount,
            'total_items' => $result,
        ]);
    }

    public function CartCount()
    {
        $id = Auth::id();
        $total_amount = Cart::where('user_id', $id)->sum('total_price');
        $total_items = Cart::where('user_id', $id)->count();

        return response()->json([
            'total_amount' => $total_amount,
            'total_items' => $total_items,
        ]);
    }




    public function RemoveCartList(Request $request)
    {
        $id = $request->id;
        $result = Cart::where('id', $id)->delete();
        return $result;
    }
}
