<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use App\Models\Product;

class AddtocartController extends BaseController
{
    public function __construct(){
        Parent::__construct();
    }
    
    public function addToCart(){
        return view('website.addtocart', ['data' => $this->data]);
    }
    
    public function cart(Product $product){
        $cart = session()->get('cart');
        
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity']++;
        }
        if(!isset($cart[$product->id])){
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'discount' => $product->discount,
                'gst_percentage' => $product->gst_percentage,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('addtocart')->with('Success', 'Product Added To Cart');
    }
    
    public function removeFromCart($id){
        $cart = session()->get('cart');
        
        if(isset($cart[$id])){
            unset($cart[$id]);
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('Success', 'Product Removed From Cart');
    }
}
