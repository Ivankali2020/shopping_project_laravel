@extends('Backend.layout.app')
@section('title') Dashboard @endsection
@section('admin_home_active','mm-active')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <div class="icon-gradient bg-mean-fruit"> Dashboard</div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0   page-title-heading mt-3 mt-md-4 ">
        <div class="row ">
            <div class="col-md-4 ">
                <div class="card app-page-title ">
                    <div class="card-body">

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

@endsection
