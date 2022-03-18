<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::with('hearts')->paginate(14);
        return response()->json(ProductResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validated = Validator::make($request->all(),[
            'name' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'detail' => 'required',
            'photo' => 'required|image',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'product_code' => 'required',
        ]);
        if($validated->fails()){
            return response()->json($validated->getMessageBag());
        }
        if ($validated->passes()) {
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
            $product->product_code = strtoupper($request->product_code);
            $product->save();
            return response()->json(['message' => 'successfully create']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product == null){
            return response()->json(['message'=>'something was wrong! :)']);
        }

        return response()->json(new ProductResource($product));
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
        $product = Product::find($id);
        if($product == null){
            return response()->json(['message'=>'something was wrong! :)']);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'min:4|max:30',
            'stock' => 'integer',
            'price' => 'integer',
            'category_id' => 'exists:categories,id',
            'brand_id' => 'exists:brands,id',
        ]);
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }

        if($validator->passes()){
            if($request->hasFile('photo')){
                $validate = Validator::make($request->all(),['photo'=>'image']);

                $file = $request->file('photo');
                $newName = uniqid().$file->getClientOriginalName();
                if($product->photo != 'photo.png'){
                    Storage::delete('/public/productPhoto/'.$product->photo);
                }
                Storage::putFileAs('/public/productPhoto/',$file,$newName);

                DB::table('products')
                    ->where('id',$id)
                    ->update(array_merge($validator->validated(),['photo'=>$newName , 'slug' => Str::slug($request->name) , 'discount' => $request->discount ?? null]));

                return response()->json(['message'=>'successfull updated']);
            }else{
                DB::table('products')
                    ->where('id','=',$product->id)
                    ->update(array_merge($validator->validated(),['slug' => Str::slug($request->name) , 'discount' => $request->discount ?? null]));

                return response()->json(['message' => 'successfully updated']);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product == null){
            return response()->json(['message'=>'something was wrong! :)']);
        }

        $product->delete();
        return response()->json(['message'=>'successfully deleted']);

    }
}
