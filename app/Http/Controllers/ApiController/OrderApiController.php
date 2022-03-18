<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use MyanmarPhone\Facades\MyanPhone;

class OrderApiController extends Controller
{
    public function __construct()
    {
//        return $this->middleware('')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::where('user_id',Auth::id())->where('status','<','4')->paginate(2);
//        return $orders;
        return response()->json(OrderResource::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(!Auth::user()->phone){
            $validate = \Illuminate\Support\Facades\Validator::make($request->all(),[
                'phone' => 'required|myanmar_phone',
                'address' => 'required',
            ]);

            if($validate->fails()){
                return $validate->getMessageBag();
            }

            $user = User::find(Auth::id());
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->update();
        }

        $orderId = random_int(1111111,9999999);

        Cart::where('user_id',Auth::id())->get()->mapToGroups(function ($p) use($orderId){
            $order = new Order();
            $order->order_id = $orderId;
            $order->product_id = $p['product_id'];
            $order->quality = $p['quality'];
            $order->user_id = Auth::id();
            $order->status = '0';
            $order->save();
            return ['keys'=>$p['id']];
        })->all();

        $carts = Cart::where('user_id',Auth::id())->get();
        $carts->each->delete();
        return response()->json(['data'=>'success order']);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::find($id);
        if($order == null){
            return response()->json(['data'=>'something was wrong :)!']);
        }
        return response()->json(['data'=>new OrderResource($order)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if($order == null){
            return response()->json(['message'=>'something was wrong :)!']);
        }
        if (isset($request->order_cancel)){
            $order->status = '4';
            $order->update();
            return response()->json('message',['icon'=>'success','text'=>'Cancel Success']);
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if($order == null){
            return response()->json(['data'=>'something was wrong :)!']);
        }

        //gate define ထားတယ်နော် ပြင်အူး AuthServiceProvider ထဲမှာ
        if(Gate::allows('delete',$order)){
            $order->delete();
            return response()->json(['data'=>'successfully order cancel !']);
        }

        return response()->json(['data'=>'gate NOT ALLOW']);


    }
}
