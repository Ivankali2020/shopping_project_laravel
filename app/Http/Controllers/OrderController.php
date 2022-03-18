<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $orders = Order::when(isset(request()->status),function ($q){
               return $q->where('status','=',request()->status);
           })
           ->when(isset(request()->search),function ($q){
               return $q->where('order_id','=',request()->search);
           });

       if(Auth::user()->role == 1){
           $orders = $orders->paginate(2);
//           return $orders;
           return view('Backend.Order.index',compact('orders'));
       }else{
           $orders = $orders->where('user_id',Auth::id())->where('status','<','4')->get();
           return view('order',compact('orders'));
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        //ဖုန်းနံပါတ် နဲ့ နေရာကို အရင်တောင်းတာပါ
        if(Auth::user()->phone == null){
            $validate = Validator::make($request->all(),[
                'phone' => 'required|min:9',
                'address' => 'required|min:10',
            ]);

            if($validate->fails()){
                return redirect()->back()->with('message',['icon'=>'success','text'=>'Don not kid! ']);
            }
            $user = User::findOrFail(Auth::id());
            $user->phone = $request->phone;
            $user->address =$request->address;
            $user->update();
        }

        //အော်ဒါထဲကို ထညါ့တာပါ // သတိပြုရန် mapGroups နဲ့တွဲသုံးထားပါသည်
        $orderId = random_int(1111111,9999999);
        $userCarts = Cart::where('user_id',Auth::id())->get()->mapToGroups(function ($p) use($orderId){
            $order = new Order();
            $order->order_id = $orderId;
            $order->product_id = $p['product_id'];
            $order->quality = $p['quality'];
            $order->user_id = Auth::id();
            $order->status = '0';
            $order->save();
            return ['keys'=>$p['id']];
        })->all();

        //ခြင်းတောင်းထဲမှာ ရှိတာကို ဖျက်တာပါ each is loop laravel buidIn
        $carts = Cart::where('user_id',Auth::id())->get();
        $carts->each->delete();

        return redirect()->back()->with('message',['icon'=>'success','text'=>'Thaks! We will delivery soon ']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {

        if (isset($request->order_cancel)){
            $order->status = '4';
            $order->update();
            return redirect()->back()->with('message',['icon'=>'success','text'=>'Cancel Success']);
        }
        switch ($order->status) {
            case '0':
                $order->status = '1';
                break;
            case '1':
                $order->status = '2';
                break;
            case '2':
                $order->status = '3';
                break;
            default:
                $order->status = '4';
        }
        $order->update();

        return response()->json(['icon'=>'success','text'=>'Process Complete','status'=>config('status.status.'.$order->status)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
