@extends('Backend.layout.app')
@section('title') Order @endsection
@section('style')
    <style>
        .line{
            height: 5px;
            /*background-color: black;*/
            z-index: -1;
            width: 50%;
        }
        .line .btn{
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .search{
            position: absolute;
            top: 30px;
            right: 30px;

        }
        .pagination{
            margin: 0;
        }
    </style>
    @endsection
@section('order_index_active','mm-active')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper d-flex justify-content-between align-items-center ">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <a href="{{ route('order.index') }}" class="icon-gradient bg-mean-fruit"> Order List </a>
            </div>
            <div class="">
                {!! $orders->links() !!}
            </div>
        </div>
    </div>

    <div class="container-fluid p-0   page-title-heading mt-3 mt-md-4 ">
        <div class="row ">
            <div class="col-xxl-10  m-auto ">
                <div class="card app-page-title  " style="border-radius: 20px" >
                    <div class="card-body  ">

                            <div class="d-flex justify-content-between align-items-center bg-happy-fisher mt-3 line">
                                <a href="{{ route('order.index') }}" class="btn btn-light   ">
                                    <img src="{{ asset('photo/order.png') }}" width="100%" alt="">
                                </a>

                                <a href="{{ url('/order?status='.'1') }}" class="btn btn-light ">
                                    <img src="{{ asset('photo/clipboard.png') }}" width="100%" alt="">
                                </a>
                                <a href="{{ url('/order?status='.'2') }}" class="btn btn-light ">
                                    <img src="{{ asset('photo/fast-delivery.png') }}" width="100%" alt="">
                                </a>
                                <a href="{{ url('/order?status='.'3') }}" class="btn btn-light  ">
                                    <img src="{{ asset('photo/check.png') }}" width="100%" alt="">
                                </a>
                            </div>

                            <div class="search">
                                <form action="{{ url('/order') }}" method="get" class="d-flex ">
                                    <input type="text" value="{{ request()->search ?? '' }}" name="search" class="form-control">
                                    <button  class="btn btn-outline-light ml-2  "><i class="pe-7s-search fs-4 icon-gradient bg-happy-itmeo "></i></button>
                                </form>
                            </div>


                        <table class="table mt-5  table-bordered  p-0  mt-3 table-responsive-md  " id="dataTable">
                            <thead class="fw-bolder bg-light   ">
                            <tr >
                                <td>Order ID</td>
                                <td >Customer</td>
                                <td>Address</td>
                                <td>Phone</td>
                                <td>Product</td>
                                <td>Quatity</td>
                                <td>Date Order</td>
                                <td class="no-sort text-nowrap" >Status</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key=>$o)
                                <tr class="animate__animated animate__fadeInLeftBig" style="--animate-duration: {{ $key+1 }}s">
                                    <td class="fw-bolder ">{{ $o->order_id }}</td>
                                    <td >{{ $o->user->name }}</td>
                                    <td>{{ $o->user->address }}</td>
                                    <td>{{ $o->user->phone}}</td>
                                    <td>
                                       <div class="text-capitalize"> {{ $o->product->name }}</div>
                                        <small class="text-secondary  ">{{ $o->product->brand->name }}</small>
                                    </td>
                                    <td>
                                        {{ $o->quality }} pcs
                                    </td>
                                    <td>
                                        {{ $o->created_at->format('M d Y') }}
                                    </td>
                                    <td>
                                        <form id="updateOrder{{$o->id }}" action="{{ route('order.update',$o->id) }}" method="post">
                                            @method('put') @csrf
                                        </form>

                                    @switch($o->status)
                                            @case('0')
                                                <button id="changUi{{ $o->id }}"  style="border-radius: 10px;"
                                                        onclick="allowForOrderConfirm('{{ $o->id }}','{{ $o->product->name }}')"
                                                        class="btn fw-bolder text-capitalize  px-2 py-1 bg-happy-green icon-gradient btn-outline-light">
                                                    {!! config('status.status.'.$o->status) !!}
                                                </button>
                                            @break

                                            @case('1')
                                                <button id="changUi{{ $o->id }}"  style="border-radius: 10px;"
                                                        onclick="allowForOrderConfirm('{{ $o->id }}','{{ $o->product->name }}')"
                                                        class="btn fw-bolder text-capitalize  px-2 py-1 bg-happy-fisher icon-gradient btn-outline-light">
                                                    {!! config('status.status.'.$o->status) !!}
                                                </button>
                                            @break

                                            @case('2')
                                                <button id="changUi{{ $o->id }}"  style="border-radius: 10px;"
                                                        onclick="allowForOrderConfirm('{{ $o->id }}','{{ $o->product->name }}')"
                                                        class="btn fw-bolder text-capitalize  px-2 py-1 bg-happy-itmeo   icon-gradient btn-outline-light">
                                                    {!! config('status.status.'.$o->status) !!}
                                                </button>
                                            @break

                                            @case('3')
                                                <button   style="border-radius: 10px;"
                                                        onclick="allowForOrderConfirm('{{ $o->id }}','{{ $o->product->name }}')"
                                                        class="btn fw-bolder text-capitalize disabled px-2 py-1 bg-happy-itmeo   icon-gradient btn-outline-light">
                                                    {!! config('status.status.'.$o->status) !!}
                                                </button>
                                            @break

                                                @case('4')
                                                <button   style="border-radius: 10px;"
                                                         class="btn fw-bolder text-capitalize disabled px-2 py-1 bg-mean-fruit   icon-gradient btn-outline-light">
                                                    {!! config('status.status.'.$o->status) !!}
                                                </button>
                                                @break
                                        @endswitch

                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--    <script>--}}
    {{--        Swal.fire({--}}
    {{--            position: 'top-end',--}}
    {{--            icon: 'success',--}}
    {{--            title: 'Your work has been saved',--}}
    {{--            showConfirmButton: false,--}}
    {{--            timer: 1500--}}
    {{--        })--}}
    {{--    </script>--}}

    <script>
        function allowForOrderConfirm(id,name){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('#CreateCart'+name);
                    $.ajax({
                        url: "/order/"+id,
                        type : 'put',
                        dataType : 'json',
                        data:{
                            product_id : id , "_token" : " {{ csrf_token() }}"
                        },
                        success:function (data){
                            console.log(data);
                            if(data.icon == 'success'){
                                Swal.fire(
                                    'Everything OK!',
                                    data.text,
                                    data.icon
                                )
                                $('#changUi'+id).html(data.status);
                            }else {
                                Swal.fire(
                                    'something was wrong!',
                                    data.text,
                                    data.icon
                                )
                            }

                        }

                    });

                }
            })
        }
    </script>


@endsection
