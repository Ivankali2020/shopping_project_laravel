@extends('layouts.app')

@section('style')
    <style>
        .box{
            width: 150px;
            height: 150px;
            border-radius: 50%;
            text-align: center;
            line-height: 150px;
        }

        .line{
            height: 5px;
            /*background-color: black;*/
            z-index: -1;
            width: 80%;
            margin: auto;
        }
        .line .btn{
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .animate__zoomInDown{
            --animate-duration: 2s;
        }
        .animate__bounceIn{
            --animate-duration: 2s;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row flex-wrap ">
            <div class=" col-xl-8 m-auto  ">
                <div class="card px-3 ">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center  ">
                            <div class="d-flex align-items-center  ">
                                <div class="box bg-light animate__animated animate__zoomInDown  ">
                                    <img src="{{ asset('photo/box.png') }}" width="100px" alt="">
                                </div>
                                <div class="ml-5 animate__animated animate__fadeIn">
                                    <h3 class="fw-bolder mb-3 ">ORDER STATUS</h3>
                                    <div class=" small  text-secondary ">Order ID : {{ $orders[0]->order_id ?? '#######' }} </div>
                                    <div class=" small  text-secondary ">Ordered Placed Date: 14 Jan 2022 </div>
                                </div>
                            </div>
                            <div class="animate__animated animate__fadeInRightBig ">
                                <button class="btn btn-success  ">ARRIVED</button>
                            </div>
                        </div>
                        <div class="col-12 my-5 text-center ">
                            <div class="d-flex justify-content-between align-items-center bg-happy-fisher  line">
                                <a href="{{ route('order.index') }}" class="btn btn-light  animate__animated animate__bounceIn   ">
                                    <img src="{{ asset('photo/order.png') }}" width="100%" alt="">
                                </a>
                                <a href="{{ url('/order?status='.'1') }}" class="btn btn-light animate__animated animate__bounceIn  ">
                                    <img src="{{ asset('photo/clipboard.png') }}" width="100%" alt="">
                                </a>
                                <a href="{{ url('/order?status='.'2') }}" class="btn btn-light animate__animated animate__bounceIn  ">
                                    <img src="{{ asset('photo/fast-delivery.png') }}" width="100%" alt="">
                                </a>
                                <a href="{{ url('/order?status='.'3') }}" class="btn btn-light  animate__animated animate__bounceIn  ">
                                    <img src="{{ asset('photo/check.png') }}" width="100%" alt="">
                                </a>
                            </div>
                        </div>

                        <table class="table table-borderless ml-0 ml-xl-5 text-secondary ">
                            <thead class="mb-5 ">
                            <tr class="animate__animated animate__fadeIn fw-bold">

                                <td>Date</td>
                                <td>Status</td>
                                <td>Location</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $key=>$o)
                                <tr>
                                    <td class="animate__animated animate__fadeInLeftBig " style="--animate-duration: {{ $key+1 * .2 }}s">{{ $o->created_at->format('M d Y') }}</td>
                                    <td>
                                        @switch($o->status)
                                            @case('0')
                                            <button  style="border-radius: 10px;"
                                                    class="btn fw-bolder text-capitalize animate__animated animate__zoomInDown   px-2 py-1 bg-happy-green icon-gradient btn-outline-light">
                                                {!! config('status.status.'.$o->status) !!}
                                            </button>
                                            <button form="updateOrder{{ $o->id }}" style="border-radius: 10px;"
                                                     class="btn fw-bolder text-capitalize animate__animated animate__zoomInDown   px-2 py-1 bg-mean-fruit  icon-gradient btn-outline-light">
                                                <i class="pe-7s-trash"></i>
                                            </button>
                                            <form id="updateOrder{{ $o->id }}" action="{{ route('order.update',$o->id) }}" method="post">
                                                @csrf @method('put')
                                                <input type="hidden" name="order_cancel" value="4" >
                                            </form>
                                            @break

                                            @case('1')
                                            <button  style="border-radius: 10px;"
                                                    class="btn fw-bolder text-capitalize animate__animated animate__zoomInDown  px-2 py-1 bg-happy-fisher icon-gradient btn-outline-light">
                                                {!! config('status.status.'.$o->status) !!}
                                            </button>
                                            @break

                                            @case('2')
                                            <button  style="border-radius: 10px;"
                                                    class="btn fw-bolder text-capitalize animate__animated animate__zoomInDown  px-2 py-1 bg-happy-itmeo   icon-gradient btn-outline-light">
                                                {!! config('status.status.'.$o->status) !!}
                                            </button>
                                            @break

                                            @case('3')
                                            <button  style="border-radius: 10px;"
                                                    class="btn fw-bolder text-capitalize animate__animated animate__zoomInDown  px-2 py-1 bg-happy-itmeo   icon-gradient btn-outline-light">
                                                {!! config('status.status.'.$o->status) !!}
                                            </button>
                                            @break


                                        @endswitch
                                    </td>
                                    <td class="animate__animated animate__fadeInRightBig " style="--animate-duration: {{ $key+1 }}s">
                                        {{ $o->user->address }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center fw-bolder ">
                                    <td colspan="2" class="h4 text-capitalize icon-gradient bg-happy-fisher " >
                                        <div class="mt-3 ">
                                            <div class="fa fa-sad-cry "></div>
                                        </div>
                                        <div class="mt-2 ">
                                            there is no order for you
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
