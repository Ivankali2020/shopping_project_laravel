@extends('layouts.app')

@section('content')
    <div class="container ">
        <div class="row  ">
            <div class=" col-xl-8 ">
                    <div class="card mb-3  " >
                        <div class="card-body  ">
                           <table class="table table-borderless text-center mb-0 table-responsive-sm    ">

                              <tr class="fw-bold h6 mb-3  ">
                                  <td class="icon-gradient bg-happy-fisher ">Product Image</td>
                                  <td class="text-left icon-gradient bg-happy-fisher">Name</td>
                                  <td class="icon-gradient bg-happy-fisher ">Qualtity</td>
                                  <td class="icon-gradient bg-happy-fisher ">Action</td>
                              </tr>

                               <tbody class="">
                               @forelse($carts as $key=>$c)
                               <tr class="animate__animated animate__fadeInLeftBig " style="--animate-duration: {{$key+1}}s">
                                   <td>
                                       <img src="{{ asset('storage/productPhoto/'.$c->product->photo) }}" width="100px" style="height:100px" alt="">
                                   </td>
                                   <td class="text-left ">
                                       <h6 class="fw-bold text-capitalize  ">
                                           {{$c->product->name}} <small class="text-black-50 ">({{ $c->product->brand->name }})</small>
                                       </h6>
                                       <div class="d-flex  justify-content-between align-content-end  mt-3 ">
                                           <div class="icon-gradient bg-happy-fisher align-self-end ">
                                               <span class="h4 fw-bolder text-black-50 fa fa-dollar-sign  ">  </span> <span class="h5 fw-bold   ">{{ $c->product->price }}</span>
                                           </div>
                                           <div class="">
                                               @if( $c->product->discount != null )
                                                   <span class="fw-bolder icon-gradient bg-happy-fisher ">{{  $c->product->discount."%"  }} </span>
                                                   <div class="icon-gradient bg-mean-fruit fw-bolder ">
                                                       OFF
                                                   </div>
                                               @endif
                                           </div>
                                       </div>

                                   </td>
                                   <td >
                                       <div class="d-flex justify-content-center ">
                                           <button id="minus" onclick="minus('{{$c->id}}')" class="btn btn-outline-light"><i class="fa fa-minus"></i></button>
                                           <input id="quality{{ $c->id }}"  class="form-control text-center mx-2 " style="width: 50px;" type="text" value="{{ $c->quality }}" min="1" >
                                           <button id="plus" onclick="plus('{{$c->id}}')"  class="btn btn-outline-light"><i class="fa fa-plus"></i></button>
                                       </div>
                                   </td>
                                  <td>
                                      <div class="">
                                          <button class="btn btn-light p-1 px-2 icon-gradient bg-mixed-hopes" >  <i class="fa fa-heart"></i> </button>
                                          <form action="{{ route('cart.destroy',$c->id) }}" method="post" class="d-inline ">
                                              @csrf @method('delete')
                                              <button class="btn btn-outline-danger p-1 px-2 " > Remove <i class="ml-2 fa fa-trash "></i> </button>
                                          </form>
                                      </div>
                                  </td>
                               </tr>
                               @empty
                                   <tr style="height: 50vh">
                                       <td colspan="5">
                                            <div class="text-center  icon-gradient bg-mixed-hopes  ">
                                                <div class="fa fa-sad-cry h1"></div>
                                                <div class="h4 fw-bolder mt-4 " style="letter-spacing: 1rem;"> THERE IS NO ORDER</div>
                                            </div>
                                       </td>
                                   </tr>
                               @endforelse
                               </tbody>
                           </table>
                        </div>
                    </div>
            </div>
            <div class="col-xl-4 animate__animated animate__fadeInRightBig ">
                <div class="card ">
                    <div class="card-body icon-gradient bg-happy-fisher">
                        <h3 class="fw-bolder mb-4 ">  Your Order </h3>
                        <div class="d-flex justify-content-between align-items-center fw-bold  ">
                            <div class="">Total</div>
                            <div class="total"><i class="fa fa-dollar-sign mx-2 "></i> {{ $total ?? '00' }}.00</div>
                        </div>
                        @forelse($carts as $c)
                           @if($c->product->discount != null)
                                <div class="d-flex my-3  justify-content-between align-items-center fw-bold  ">
                                    <div class="">
                                        <span>Discount</span>
                                        <small class="ml-4 icon-gradient bg-mean-fruit ">{{ $c->product->name  }}</small>
                                    </div>
                                    <span> <span class="icon-gradient bg-mean-fruit "> OFF </span>  {{ $c->product->discount }}.00 % </span>
                                </div>
                               @endif
                        @empty
                        @endforelse
                        <hr>
                        <div class="d-flex my-3  h3  justify-content-between align-items-center fw-bold  ">
                            <div class="">Total </div>
                            <div class="total"> <i class="fa fa-dollar-sign "></i> {{ $total ?? '00' }}.00</div>
                        </div>

                        @if(isset($total) && isset(\Illuminate\Support\Facades\Auth::user()->phone))
                            <form action="{{ route('order.store') }}" method="post">
                                @csrf
                                <button class="btn btn-block btn-light text-secondary icon-gradient bg-happy-fisher">
                                    Payment
                                </button>
                            </form>
                        @else
                        <button data-bs-toggle="modal"  data-bs-target="#staticBackdrop"
                                class="btn btn-block btn-outline-secondary icon-gradient bg-mean-fruit   fw-bolder ">
                            <span>Payment</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="d-flex justify-content-between align-items-center p-3 ">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">

                    <form action="{{ route('order.store') }}" method="post">
                        @csrf
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="mr-4 "><i class="pe-7s-phone fs-1 "></i></div>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center">
                            <div class="mr-4 "><i class="pe-7s-map-marker fs-1 "></i></div>
                            <textarea type="text" name="address" class="form-control" autofocus="true"></textarea>
                        </div>

                        <div class="form-group text-right mb-0 mt-4 ">
                            <button class="btn btn-outline-secondary">Order Now</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script>

        function plus(cart_id){
            let count = 1;
            let v = Number(document.getElementById('quality'+cart_id).value);
            $('#quality'+cart_id).val(count + v);
            ajaxPlusAndMinus($('#quality'+cart_id).val(),cart_id);
        }

        function minus(cart_id){
            let count = 1;
            let v = Number(document.getElementById('quality'+cart_id).value);
            if(v > 1){
                $('#quality'+cart_id).val( v - count);
                ajaxPlusAndMinus($('#quality'+cart_id).val(),cart_id);
            }
        }

        function ajaxPlusAndMinus(quality,cart_id)
        {
            $.ajax({
                url:"/cart/"+cart_id,
                dataType: "json",
                type: "PUT",
                data: { cart_id : cart_id , '_token' : "{{ csrf_token() }}", quality : quality },
                success: function (data) {
                    console.log(data.total);
                    $('.total').toArray().map(n => n.innerHTML = `<i class="fa fa-dollar-sign mr-2 "></i>`+ data.total+'.00')
                }
            })
        }
    </script>

@endsection
