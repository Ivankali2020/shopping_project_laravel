@extends('Backend.layout.app')
@section('title') Product @endsection
@section('product_index_active','mm-active')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <div class="icon-gradient bg-mean-fruit"> Product List </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0   page-title-heading mt-3 mt-md-4 ">
        <div class="row ">
            <div class="col-xxl-10  m-auto ">
                <div class="card app-page-title ">
                    <div class="card-body">
                        <table class="table  table-bordered  p-0  mt-3 table-responsive-md  icon-gradient bg-mean-fruit" id="dataTable">
                            <thead class="fw-bolder  ">
                            <tr class="fw-bolder h6 ">
                                <td>#</td>
                                <td >Name</td>
                                <td>Price</td>
                                <td>Stock</td>
                                <td>Category</td>
                                <td>Brand</td>
                                <td>Photo</td>
                                <td>Control</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td >{{ $product->name }}</td>
                                    <td>{{ $product->price }}.00 <span calss="text-right ">$</span></td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->category->name }} </td>
                                    <td>{{ $product->brand->name }} </td>

                                    <td class="text-center ">
                                        <img src="{{ asset('storage/productPhoto/'.$product->photo) }}" width="50px" alt="">
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit',$product->id) }}" class="pe-7s-pen h4 "></a>
                                        <a href="{{ route('product.show',$product->id) }}" class="pe-7s-info h4 mx-3   "></a>
                                        <form class="d-inline "  id="deleteProduct{{$product->id}}" action="{{ route('product.destroy',$product->id) }}" method="post">
                                            @csrf @method('delete')
                                            <span style="cursor: pointer" onclick="allow('{{ $product->name }}',{{ $product->id }})"> <i class="pe-7s-trash h4 "></i> </span>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{  $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    {{--    {!! JsValidator::formRequest('App\Http\Reques   ts\StoreCategoryRequest', '#createCategory'); !!}--}}
    <script>
        function allow(name,id){

            Swal.fire({
                title: 'Are you sure?',
                text: name,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('#deleteProduct'+id)
                    $('#deleteProduct'+id).submit();
                }
            })
        }
    </script>

@endsection

