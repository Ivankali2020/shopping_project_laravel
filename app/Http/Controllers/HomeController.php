<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Auth::user()->role == 1){
            //$from = date_sub(now(),date_interval_create_from_date_string("15 days"));

            $dateArr = [];
            $dailyOrders = [];
            $totalOrders = Order::all()->count();
            $totalProduct = Product::all()->count();
            for ($i = 0; $i < 14; $i++) {
                $today = date('Y-m-d');
                $date = date_create($today);
                date_sub($date, date_interval_create_from_date_string("$i days"));
                $result = date_format($date, "Y-m-d");

                //date 10 days ago
                array_push($dateArr, $result);

                //daily viewers last 10 days ago

                $dailyorder = Order::whereDate('created_at',$result)->count();
                array_push($dailyOrders, $dailyorder);
            }
//            return $totalOrders;
//            return $dateArr;
            return view('Backend.home',compact('dailyOrders','dateArr','totalOrders','totalProduct'));
        }

        return $this->welcome();
    }

    public function welcome()
    {
        $products = Product::with('hearts')->paginate(8);
//        return $products;
        return view('welcome',compact('products'));
    }

    public function detail()
    {
        $products = Product::when(isset(request()->search),function ($q){
                $data = request()->search;
                return $q->where('category_id',"=","$data");
            })
            ->when(isset(request()->brand),function ($q){
                $brand = request()->brand;
                return $q->where('brand_id',"=","$brand");
            })
            ->when(isset(request()->brandOrCategory),function ($q){
                $brand = request()->brandOrCategory;
                return $q->where('name',"LIKE","%$brand%");
            })
            ->when(isset(request()->min),function ($q){
                $min = (int)request()->min;
                $max = (int)request()->max;
                return $q->whereBetween('price',[$min,$max]);
            })
            ->paginate(5);

//        return var_dump((int)request()->min);
        return view('detailProduct',compact('products'));
    }

    public function UserCart()
    {
        $carts = Cart::where('user_id',Auth::id())->get();
//        return $carts;
        if(count($carts) > 0) {
            $products = $carts->mapToGroups(function ($p, $price) {
                $qulityMultipleByProduct = $p['product']['price'] * $p['quality'] ;
                $dividedByOnehundred = ($qulityMultipleByProduct * $p['product']['discount'] )/ 100;

                return [ 'total' =>  $qulityMultipleByProduct - $dividedByOnehundred ];
            });
            $subtotal = $carts->mapToGroups(function ($p, $price) {
                $qulityMultipleByProduct = $p['product']['price'] * $p['quality'] ;
                return [ 'subtotal' =>  $qulityMultipleByProduct  ];
            });

            $total = array_sum($products['total']->toArray());
            $subTotal = array_sum($subtotal['subtotal']->toArray());
//            return $subTotal;
            return view('cart', compact('carts', 'total','subTotal')); //take cart in database
        }

        return view('cart', compact('carts')); //take cart in database

    }
}
