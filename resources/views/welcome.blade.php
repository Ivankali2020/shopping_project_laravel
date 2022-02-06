@extends('layouts.app')
@section('style')

    <style>
        body{
            background-image: url("{{ asset('photo/bgBody.jpg') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

            backdrop-filter: blur(50px) saturate(200%);
            --webkit-backdrop-filter: blur(50px) saturate(200%);
            background-color: rgba(255, 255, 255, 0.52);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
        }
        .card {
            backdrop-filter: blur(50px) saturate(200%);
            --webkit-backdrop-filter: blur(50px) saturate(200%);
            background-color: rgba(255, 255, 255, 0.52);
            border-radius: 12px;
            border: 1px solid rgba(209, 213, 219, 0.3);
        }
        .form-control{
            border: 1px solid #0080ff !important;
        }
        .discount{

        }
    </style>
    @endsection
@section('content')
    <div class="container">
        <div class="row flex-wrap ">
            @foreach($products as $key=>$p)

                <div class=" col-6 col-md-4 col-xl-3  mb-4  ">
                    <div class="card position-relative ">
                        {{-- hear button and discount --}}
                        <button id="heart{{ $p->id }}"
                                class="btn btn-light p-1 px-2 icon-gradient  position-absolute {{ count($p->hearts) > 0 ? 'bg-mean-fruit' : '' }}"
                                onclick="heart('{{ $p->id }}')" style="top: 10px;left: 10px;" >
                            <i class="fa fa-heart">
                                <sup id="heartCount{{ $p->id }}" class="text-dark icon-gradient bg-mean-fruit  fw-bolder "> {{ count($p->hearts) == 0 ? '' : count($p->hearts) }}  </sup>
                            </i>
                        </button>

                        @if($p->discount != null)
                        <div class="position-absolute fw-bolder discount icon-gradient bg-happy-green  "
                              style="top: 10px;right: 10px;">
                            {{  $p->discount." % " }}
                            <div class="icon-gradient  bg-mean-fruit">
                                OFF
                            </div>
                        </div>
                        @endif
                        {{-- hear button and discount --}}

                        <div class="text-center">
                            <img src="{{ asset('storage/productPhoto/'.$p->photo) }}" class="animate__animated animate__zoomInDown " width="150px" style="min-height: 150px;" alt="">
                        </div>
                        <div class="card-body animate__animated animate__bounceIn">
                            <h2 class="icon-gradient bg-happy-itmeo"> {{ $p->name }} </h2>
                            <div class="d-flex mt-2 mb-4 icon-gradient bg-happy-itmeo">
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                            </div>

                            <div class=" d-flex justify-content-between align-items-center ">
                                <div class=" ">
                                   <span class="h4 fw-bolder icon-gradient  bg-happy-itmeo  "> $ </span>
                                    @if($p->discount != null)
                                        <span class=" fw-bold text-decoration-line-through  ">{{ $p->price }}</span>
                                        <span class="h6 fw-bold icon-gradient  bg-happy-itmeo ">{{ number_format( $p->price - ($p->price * $p->discount) / 100  , 2)  }}</span>
                                    @else
                                        <span class="h6 fw-bold icon-gradient bg-happy-itmeo  ">{{ number_format($p->price,2) }}</span>
                                    @endif
                                </div>
                                <div class="">
                                        <a href="{{ url('detail/product?brandOrCategory='.$p->name) }}" class="btn btn-outline-secondary p-1 px-2 " >  <i class="pe-7s-info  "></i>  </a>
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-light p-1 px-2 " > <i class="pe-7s-cart icon-gradient bg-happy-green"></i> </a>
                                    @else
{{--                                        <form id="CreateCart{{ $p->id }}" action="{{ route('cart.store') }}" method="post" class="d-inline ">--}}
{{--                                            @csrf <input type="hidden" name="product_id" value="{{ $p->id }}">--}}
{{--                                        </form>--}}

                                        <button class="btn btn-outline-light   p-1 px-2 " onclick="allow('{{ $p->id }}','{{ $p->name }}')" > <i class="pe-7s-cart icon-gradient bg-happy-fisher fw-bolder  "></i> </button>

                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection
@section('script')

    <script>
        function heart(id){
            $.ajax({
                url : "{{ route('product.heart') }}",
                type : 'post',
                dataType : 'json',
                data : { product_id : id , '_token' : "{{ csrf_token() }}" },
                success: function (data){
                    console.log(data);
                    if(data.success == 'true'){
                        $('#heart'+data.id).addClass('bg-mean-fruit');
                        let count = $('#heartCount'+data.id).html();
                        console.log( $('#heartCount'+data.id).html(++count) );
                    }else{
                        $('#heart'+data.id).removeClass('bg-mean-fruit');
                        let count = $('#heartCount'+data.id).html();
                        console.log( $('#heartCount'+data.id).html(--count) );
                    }
                }
            })
        }
    </script>

@endsection
