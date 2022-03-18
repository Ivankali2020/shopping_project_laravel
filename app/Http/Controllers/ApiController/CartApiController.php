<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;

class CartApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $carts = Cart::where('user_id',Auth::id())->get();
//        return $carts;
        return response()->json(CartResource::collection($carts));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $carts = Cart::where('user_id',Auth::id())->where('product_id',$request->product_id)->exists();
        if($carts){
            //this is if already added will return
            return response()->json(['icon'=>'question','text'=>'Your Already Added']);
        }

        // this is cart store
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->user_id = Auth::id();
        $cart->save();
        return response()->json(['icon'=>'success','text'=>'Successfully Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cart = Cart::find($id);

        if($cart == null){
            return response()->json(['message'=>'something was wrong :)!']);
        }

        return response()->json(['data'=>new CartResource($cart)]);
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
        $validate = $request->validate([
            'quality' => 'required|min:1|max:50',
            '_method' => 'required',
        ]);
        $cart = Cart::find($id);

        if($cart == null){
            return response()->json(['message'=>'something was wrong :)!']);
        }

        $cart->quality = $request->quality;
        $cart->update();
        return response()->json(['message'=>'successfuly updated','data' => new CartResource($cart)]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);

        if($cart == null){
            return response()->json(['message'=>'something was wrong :)!']);
        }

        $cart->delete();
        return response()->json(['message'=>'successfuly deleted']);
    }
}
