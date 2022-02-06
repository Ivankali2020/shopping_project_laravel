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
            <div class="col-xxl-10  m-auto ">
                <div class="card app-page-title ">
                    <div class="card-body">
                        <table class="table  table-bordered  p-0  mt-3 table-responsive-md  icon-gradient bg-mean-fruit" id="dataTable">
                            <thead class="fw-bolder  ">
                            <tr>
                                <td>#</td>
                                <td >Name</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Premium</td>
                                <td class="no-sort text-nowrap" >Control</td>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @foreach($users as $user)--}}
{{--                                <tr>--}}
{{--                                    <td>{{ $user->id }}</td>--}}
{{--                                    <td >{{ $user->name }}</td>--}}
{{--                                    <td>{{ $user->email }}</td>--}}
{{--                                    <td>{{ $user->role == 1 ? 'Admin' : 'User' }}</td>--}}
{{--                                    <td>--}}
{{--                                        <span class="{{ $user->is_premium == 1 ? 'pe-7s-check ' : 'pe-7s-attention  ' }} h4  "></span>--}}
{{--                                    </td>--}}
{{--                                 --}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
                            </tbody>
                        </table>
{{--                        {{ $users->links() }}--}}
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
