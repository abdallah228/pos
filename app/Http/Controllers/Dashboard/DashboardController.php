<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Client;
use App\Order;
use App\User;
use DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $products_count = Product::count();
        $categories_count = Category::count();
        $clients_count = Client::count();
        $orders_count = Order::count();
        $users_count = User::whereRoleIs('admin')->count();

        $sales_data = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum'),
        
        )->groupBy('month')->get();// in config database u should change value of strict to false to run this code
       // dd($sales_data);//for test done
        
        return view('dashboard.index',compact('products_count','categories_count','clients_count','orders_count','users_count','sales_data'));
    }
}
