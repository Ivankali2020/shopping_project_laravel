<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('Backend.Product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('Backend.Product.create',compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $file = $request->file('photo');
        $newName = uniqid().$file->getClientOriginalName();
        Storage::putFileAs('/public/productPhoto/',$file,$newName);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::slug( $request->name);

        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->detail = $request->detail;
        $product->photo = $newName;
        $product->discount = $request->discount ?? null;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();
        return redirect()->back()->with('message',['icon'=>'success','text'=>'<h2 class="icon-gradient bg-mean-fruit">Successfully Inserted!</h2>']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('Backend.Product.edit',compact('product','brands','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if(isset($request->photo)){
            $file = $request->file('photo');
            $newName = uniqid().$file->getClientOriginalName();
            if($product->photo != 'photo.png'){
                Storage::delete('/public/productPhoto/'.$product->photo);
            }
            Storage::putFileAs('/public/productPhoto/',$file,$newName);

            DB::table('products')
                ->where('id','=',$product->id)
                ->update(array_merge($data,['photo'=>$newName , 'slug' => Str::slug($request->name) , 'discount' => $request->discount ?? null]));
        }else{
            DB::table('products')
                ->where('id','=',$product->id)
                ->update(array_merge($data,['slug' => Str::slug($request->name) , 'discount' => $request->discount ?? null]));
        }

        return redirect()->route('product.index')
            ->with('message',['icon'=>'success','text'=>'<h2 class="icon-gradient bg-mean-fruit">Successfully Updated  </h2>']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()
                ->with('message',['icon'=>'success','text'=>'<h2 class="icon-gradient bg-mean-fruit">Successfully Deleted! </h2>']);
    }

    public function heartGive(Request $request)
    {
        $user = Auth::user()->with('heart')->first();
        foreach ($user->heart as $h){
            if($h->id == $request->product_id){
                $user->heart()->detach($request->product_id);
                return response()->json(['success'=>'false','id'=>$request->product_id ]);
            }
        }
        $user->heart()->attach($request->product_id);
        return response()->json(['success'=>'true','id'=>$request->product_id ]);
    }
}
