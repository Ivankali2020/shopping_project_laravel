@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-wrap ">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body animate__animated animate__fadeIn">
                        <h3 class="fw-bolder animate__animated animate__fadeInDownBig "> Category Search </h3>
                        <form id="categorySearch" action="{{ route('detail.product') }}" method="get"></form>
                        <div class="form-group d-flex my-4 animate__animated animate__lightSpeedInLeft  ">
                            <input form="categorySearch"  type="text" class="form-control mr-4 " name="brandOrCategory" >
                            <button form="categorySearch" class="btn btn-outline-secondary px-2 pb-0  "><i class="pe-7s-search h5 "></i></button>
                        </div>

                        <div class="d-flex  " >
                            <p class="  animate__animated animate__lightSpeedInLeft  ">
                                <button class="btn btn-light " type="button" data-bs-toggle="collapse" data-bs-target="#categoryCollapse" aria-expanded="false" aria-controls="categoryCollapse">
                                    Categories
                                </button>
                            </p>
                            <p class="mx-3 animate__animated animate__lightSpeedInLeft  ">
                                <button class="btn btn-outline-secondary " type="button" data-bs-toggle="collapse" data-bs-target="#brandCollapse" aria-expanded="false" aria-controls="brandCollapse">
                                    Brands
                                </button>
                            </p>
                            <p class="animate__animated animate__lightSpeedInLeft ">
                                <a href="{{ route('detail.product') }}" class="btn btn-secondary  "  >
                                  All
                                </a>
                            </p>
                        </div>
                        {{-- this is category collapse--}}
                        <div class="collapse" id="categoryCollapse">
                            @foreach($categories as $c)
                                <a href="{{ url('/detail/product?search='.$c->id) }}" class="btn btn-block d-flex justify-content-between align-items-center ">
                                    <span class="text-capitalize ">{{ $c->name }} </span>
                                    <span class="badge badge-pill bg-light text-secondary ">{{count(\App\Models\Product::where('category_id',$c->id)->get()) }}</span>
                                </a>
                            @endforeach
                        </div>
                        {{-- this is category collapse--}}

                        {{-- this is brand collapse--}}
                        <div class="collapse" id="brandCollapse">
                            @foreach($brands as $b)
                                <a href="{{ url('/detail/product?brand='.$b->id) }}" class="btn btn-block d-flex justify-content-between align-items-center ">
                                    <span class="text-capitalize ">{{ $b->name }}</span>
                                    <span class="badge badge-pill bg-light text-secondary ">{{count(\App\Models\Product::where('brand_id',$b->id)->get()) }}</span>
                                </a>
                            @endforeach
                        </div>
                        {{-- this is brand collapse--}}

                    </div>
                </div>

                <div class="card my-4 animate__animated animate__zoomInDown " style=" --animate-duration: 2s;">
                    <div class="card-body  ">
                        <h3 class="fw-bolder "> Price Search </h3>
                        <form action="{{ route('detail.product') }}" method="get" class="form-group row my-4  ">
                            <div class="col-6">
                               <label for="">MIN</label>
                               <input value="{{ old('min',request()->min) }}" type="number" name="min" class="form-control mr-4 ">
                            </div>
                            <div class="col-6 text-right ">
                                <label for="">Max</label>
                                <input value="{{ old('max',request()->max) }}" type="number" name="max" class="form-control mr-4 ">
                            </div>
                            <div class="col-12 text-center mt-4 ">
                                <button class="btn btn-light w-25 "> Apply </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class=" col-md-8   mb-4 ">
                @foreach($products as $key=>$p)
                    <div class="card mb-3 animate__animated animate__fadeInRightBig   " style="--animate-duration: {{ $key+1 }}s;" >
                        <div class="card-body row  ">
                            <div class="text-center col-md-4">
                                <img src="{{ asset('storage/productPhoto/'.$p->photo) }}" width="150px" style="min-height: 150px" alt="">
                            </div>
                            <div class=" col-md-8 ">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                   <div class="">
                                       <h2> {{ $p->name }}  </h2>
                                       <div class="d-flex   text-secondary ">
                                           <i class="pe-7s-star"></i>
                                           <i class="pe-7s-star"></i>
                                           <i class="pe-7s-star"></i>
                                           <i class="pe-7s-star"></i>
                                           <i class="pe-7s-star"></i>
                                       </div>
                                   </div>
                                    <div class="d-flex flex-column  justify-content-center align-content-center ">
                                        @if( $p->discount != null )
                                        <span class="fw-bolder icon-gradient bg-happy-fisher ">{{  $p->discount."%"  }} </span>
                                        <div class="icon-gradient bg-mean-fruit fw-bolder ">
                                            OFF
                                        </div>
                                            @endif
                                    </div>
                                </div>
                                <div class="my-2">
                                    {{ $p->detail }}
                                </div>
                                <div class=" d-flex justify-content-between align-items-center mt-4 ">
                                    <div class="">
                                        @if($p->discount != null)
                                            <span class=" fw-bold text-decoration-line-through  ">
                                                <span class="h5">$ </span>
                                                {{ $p->price }}
                                            </span>
                                            <span class="h6 fw-bold mr-2   icon-gradient bg-happy-fisher  ">
                                                <span class="h5">$ </span>
                                                {{ number_format( $p->price - ($p->price * $p->discount) / 100  , 2)  }}
                                            </span>
                                        @else
                                            <span class="h6 fw-bold   icon-gradient bg-happy-fisher ">$ {{ $p->price }}</span>
                                        @endif
                                    </div>

                                    <div class="">
                                        @guest
                                            <a href="{{ route('register') }}" class="btn btn-light  p-1 px-2 " >Buy Now <i class="ml-2 pe-7s-cart bg-happy-green  icon-gradient"></i> </a>
                                        @else
                                            <form id="CreateCart{{ $p->id }}" action="{{ route('cart.store') }}" method="post" class="d-inline ">
                                                @csrf <input type="hidden" name="product_id" value="{{ $p->id }}">
                                            </form>
                                            <button class="btn btn-light p-1 px-2 " onclick="allow('{{ $p->id }}','{{ $p->name }}')" > Buy Now <i class="ml-2 pe-7s-cart bg-happy-green  icon-gradient"></i> </button>

                                        @endguest
                                        <button class="btn btn-outline-light  p-1 px-2 " > Detail <i class="ml-2 pe-7s-info  bg-happy-fisher   icon-gradient"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).on('click',function(){
            $('.collapse').collapse('hide');
            console.log('.saldjfas')
        })
    </script>

@endsection
