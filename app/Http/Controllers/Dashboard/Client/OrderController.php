<?php

namespace App\Http\Controllers\Dashboard\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Client;
use App\Category;
use App\Product;

class OrderController extends Controller
{
    //
    public function index()
    {

    }
    public function create(Client $client)
    {
        $categories = Category::with('product')->get();
        return view('dashboard.client.order.create',compact('client','categories'));
    }
    public function store(Request $request , Client $client)
    {
       // dd($request->all());
       $request->validate([
        'quantity'=>'required|array',
        'products_ids'=>'required|array',

       ]);
     
  
    $order = Order::create(['client_id' => $client->id,]);
   // $order = $client->orders()->create([]);

    $total_price = 0;

       foreach($request->products_ids as $index=>$product_id)//products_ids is the name of field in order.js
       {
        $product =Product::findOrFail($product_id);
        $total_price += $product->sale_price; 

           $order->products()->attach($product_id,['quantity'=>$request->quantity[$index]]);
           $product->update([
            'stock'=>$product->stock - $request->quantity[$index],

           ]);
           $order->update([
            'total_price'=>$total_price,
           ]);
       }

    }
    public function edit(Client $client , Order $order)
    {

    }
    public function update(Request $request , Client $client ,Order $order)
    {

    }
    public function destroy(Client $client , Order $order)
    {

    }

    
}
