<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Client;
use App\Produc;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $orders = Order::whereHas('clients',function($q) use ($request){
            return $q->where('name','like','%'.$request->search.'%');

        })->latest()->paginate(5);
        //$orders = Order::paginate(5);
        return view('dashboard.order.index',compact('orders'));
    }//end index

    public function products(Order $order)
    {
        $products = $order->products;
        
        return view('dashboard.order._products',compact('products','order'));

    }// end or related product for client

    public function destroy(Order $order)
    {
        foreach($order->products as $product)
        {
            $product->update([
            'stock' => $product->stock + $product->pivot->quantity,
            ]);    
        }//endforeach

        $order->delete();
        return redirect()->back()->with(['success'=>__('site.delete_succes')]);
    }//end destroy


   

}//end class
