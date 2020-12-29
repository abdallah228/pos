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
    public function index(Request $request)
    {


    }//end index function 
    public function create(Client $client)
    {
        $categories = Category::with('product')->get();
        return view('dashboard.client.order.create',compact('client','categories'));
    }
    public function store(Request $request , Client $client)
    {
       // dd($request->all());
       $request->validate([
        'products_ids'=>'required|array',
        'quantity'=>'required|array',


       ]);
     
        $this->attach_order($request , $client);
           return redirect()->route('orders.index')->with(['success'=>__('site.added_success')]);
       

    }
    public function edit(Client $client , Order $order)
    {
            $categories = Category::with('product')->get();
            return view('dashboard.client.order.edit',compact('client','order','categories'));
    }
    public function update(Request $request , Client $client ,Order $order)
    {
        $request->validate([
            'products_ids'=>'required|array',
            'quantity'=>'required|array',
        ]);

        $this->detach_order($order);//delete last order
        $this->attach_order($request , $client); // save new order
        //dd($request->all());
        return redirect()->route('orders.index')->with(['success'=>__('site.update_success')]);

        
    }
    public function destroy(Client $client , Order $order)
    {

    }



    /////privates function///uses in this class

    private function attach_order($request ,$client)
    {
        $order = Order::create(['client_id' => $client->id,]);
        // $order = $client->orders()->create([]);
         $total_price = 0;
     
            foreach($request->products_ids as $index=>$product_id)//products_ids is the name of field in order.js
            {
             $product =Product::findOrFail($product_id);
             //$total_price += $product->sale_price;
             $total_price += $product->sale_price * $request->quantity[$index];
     
      
     
                $order->products()->attach($product_id,['quantity'=>$request->quantity[$index]]);
                $product->update([
                 'stock'=>$product->stock - $request->quantity[$index],
     
                ]);
                }//endforeach
                $order->update([
                 'total_price'=>$total_price,
                ]);
        
    }//end function attach

    private function detach_order($order)
    {
        foreach($order->products as $product)
        {
            $product->update([
            'stock' => $product->stock + $product->pivot->quantity,
            ]);    
        }//endforeach

        $order->delete();

    }//end function detach

    
}
