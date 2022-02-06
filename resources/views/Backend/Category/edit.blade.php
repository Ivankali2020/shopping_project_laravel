@extends('Backend.layout.app')
@section('title') Category @endsection
@section('category_index_active','mm-active')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-disk icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div> Category Edit </div>
            </div>


        </div>
    </div>

    <div class="container mt-3 ">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('category.update',$category->id) }}" method="post" >
                            @method('PUT') @csrf
                            <input type="text" name="name" value="{{ old('name',$category->name) }}" class="form-control">
                            <input type="submit" class="btn btn-success mt-2 btn-block ">
                        </form>

                        @error('name')
                        <x-alert error="{{ $message }}" css="danger my-4 "> </x-alert>
                        @enderror



                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped  ">
                            <thead class="table-success ">
                            <tr>
                                <td>Id</td>
                                <td>Name</td>
                                <td>Action</td>
                                <td>Created At</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $g)
                                <tr>
                                    <td>{{ $g->id }}</td>
                                    <td class="text-uppercase">{{ $g->name }}</td>
                                    <td class="d-flex ">
                                        <a href="{{ route('category.edit',$g->id) }}" class="pe-7s-pen text-decoration-none btn btn-sm  fsize-1 "></a>
                                        <form id="deleteGenre{{ $g->id }}" action="{{ route('category.destroy',$g->id) }}" method="post" class="mx-2  ">
                                            @csrf @method('DELETE')
                                        </form>
                                        <span class="pe-7s-trash  text-decoration-none btn btn-sm fsize-1 " onclick="allow('{{$g->name}}','{{ $g->id }}')"></span>

                                    </td>
                                    <td>
                                       <small>{{ $g->created_at->diffForHumans() ?? '' }}</small>
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
    <script>
        function allow(name,id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
                    $('#deleteGenre'+id).submit();
                }
            })
        }
    </script>

@endsection

