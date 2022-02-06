<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
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
            return view('Backend.home');
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
                $min = request()->min;
                $max = request()->max;
                return $q->where('price','<=',"$max")->where('price','>=',"$min");
            })
            ->paginate(10);

//        return $products;
        return view('detailProduct',compact('products'));
    }

    public function UserCart()
    {
        $carts = Cart::where('user_id',Auth::id())->get();

        if(count($carts) > 0) {
            $products = $carts->mapToGroups(function ($p, $price) {
                $qulityMultipleByProduct = $p['product']['price'] * $p['quality'] ;
                $dividedByOnehundred = ($qulityMultipleByProduct * $p['product']['discount'] )/ 100;
                return ['price' =>  $qulityMultipleByProduct - $dividedByOnehundred ];
            });
            $a = $products->toArray()['price'];
            $total = array_sum($a);

            return view('cart', compact('carts', 'total')); //take cart in database
        }

        return view('cart', compact('carts')); //take cart in database

    }
}
