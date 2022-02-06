@extends('Backend.layout.app')
@section('title') ------------- &ngtr; @endsection
@section('product_edit_active','mm-active ')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-disk icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div> Cart Edit </div>
            </div>

        </div>
    </div>

    <div class="container mt-3 ">
        <div class="row">
            <div class="col-md-8 m-auto ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4 icon-gradient bg-mean-fruit ">
                            <h3 class="mb-0 fw-bolder ">Edit Your Shopping Cart</h3>
                            <i class="h1 pe-7s-cart "></i>
                        </div>
                        {{-- this is form start --}}
                        <form action="{{ route('product.update',$product->id) }}"  method="post" class="form-row" id="productEdit" enctype="multipart/form-data">
                            @csrf @method('put')
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Name</label>
                                <input type="text" name="name" value="{{ old('name',$product->name) }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Price</label>
                                <input type="number" name="price" value="{{ old('price',$product->price) }}" class="form-control">
                            </div>
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Brands</label>
                                <select name="brand_id" id="" class="form-control ">
                                    <option value="" disabled >Select Brand</option>
                                    @forelse ($brands as $b)
                                        <option {{ old('brand_id',$product->brand_id) == $b->id ? 'selected' : '' }} value="{{ $b->id }}">{{ $b->name }}</option>
                                    @empty
                                        <option > Errror </option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Category</label>
                                <select name="category_id" id="" class="form-control ">
                                    <option value="" disabled >Select Categries</option>
                                    @forelse ($categories as $c)
                                        <option {{ old('category_id',$product->category_id) == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                    @empty
                                        <option > Errror </option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Photo</label>
                                <input type="file"  accept="image/jpeg,image/jpg,image/png" value="{{ old('photo',$product->photo) }}" name="photo" class="form-control p-1">
                            </div>
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Available Stock</label>
                                <input type="number" value="{{ old('stock',$product->stock) }}" name="stock" class="form-control ">
                            </div>
                            <div class="col-12 col-md-6 mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit mb-3  " for="">Discount (%)</label>
                                <input type="number" name="discount" value="{{ old('discount',$product->discount) }}" class="form-control">
                            </div>
                            <div class="col-12  mb-3 ">
                                <label class="h6 fw-bolder icon-gradient bg-mean-fruit  " for="">Detail</label>
                                <textarea name="detail" id="" cols="30" rows="5 " class="form-control ">
                                    {{ old('detail',$product->detail) }}
                                </textarea>
                            </div>
                            <div class="col-12  my-3  text-right d-flex align-items-end justify-content-end "  >
                                <button class="btn btn-secondary  "><i class="me-2 h5 pe-7s-cart  text-light"></i>Create Cart </button>
                            </div>
                        </form>
                        {{-- this is form end --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')

    {!! JsValidator::formRequest('App\Http\Requests\UpdateProductRequest', '#productEdit'); !!}

@endsection
