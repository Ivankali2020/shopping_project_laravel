@extends('Backend.layout.app')
@section('title') ------------- &ngtr; @endsection
@section('brand_index_active','mm-active')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-disk icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div> Brand Create </div>
            </div>


        </div>
    </div>

    <div class="container mt-3 ">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('brand.store') }}" method="post">
                            @csrf
                            <input type="text" name="name" class="form-control">
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
                          @foreach($brands as $g)
                              <tr>
                                  <td>{{ $g->id }}</td>
                                  <td class="text-uppercase">{{ $g->name }}</td>
                                  <td class="d-flex">
                                      <a href="{{ route('brand.edit',$g->id) }}" class="pe-7s-pen text-decoration-none btn btn-sm  fsize-1 "></a>
                                      <form id="deleteBrand{{$g->id}}" action="{{ route('brand.destroy',$g->id) }}" method="post" class="mx-2  ">
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
                      $('#deleteBrand'+id).submit();
                  }
              })
          }
        </script>

@endsection
