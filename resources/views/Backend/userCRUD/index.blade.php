@extends('Backend.layout.app')
@section('title') User  @endsection
@section('user_index_active','mm-active')
@section('content')
    <div class="app-page-title mb-3 ">
        <div class="page-title-wrapper d-flex justify-content-between ">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div class="icon-gradient bg-mean-fruit">  User Management </div>
            </div>
            <a href="{{ route('user.create') }}" class="btn btn-outline-primary icon-gradient bg-mean-fruit  ">Create User</a>

        </div>
    </div>

    <div class="card card-body mt-3   ">
        <form action="{{ route('user.index') }}"  method="get" class="col-3 p-0  ">
            <select class="form-select" name="role" onchange='this.form.submit()' aria-label="Default select example">
                <option selected value="3">All</option>
                <option  {{ request()->role == '1'? "selected"  : ''}} value="1">Admin</option>
                <option {{ request()->role == '0' ? "selected" : '' }} value="0">User</option>
            </select>
        </form>
        <table class="table  table-bordered  p-0  mt-3 table-responsive-md  icon-gradient bg-mean-fruit" id="dataTable">
            <thead class="fw-bolder  ">
            <tr>
                <td>#</td>
                <td >Name</td>
                <td>Email</td>
                <td>Role</td>
                <td class="no-sort text-nowrap" >Control</td>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td >{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class=" ">
                        <form action="{{ route('user.upgradeAdmin') }}" method="post" class="d-flex justify-content-between ">
                            @csrf
                            <span class="">{{ $user->role == 1 ? 'Admin' : 'User' }}</span>
                            <div class="form-check form-switch">
                                <input type="hidden" value="{{ $user->id }}" name="user_id">
                                <input class="form-check-input" {{  $user->role == 1 ? 'checked' : '' }} name="admin_upgrade" onchange="this.form.submit()" type="checkbox" role="switch" id="flexSwitchCheckChecked" >
                            </div>
                        </form>
                    </td>
                    <td class="text-nowrap " >
                        <a href="{{ route('user.show',$user->id) }}" class="pe-7s-pen text-decoration-none btn-sm btn btn-outline-secondary  icon-gradient bg-mean-fruit text-warning  fsize-1  mx-3 "></a>
                        <form id="userDelete{{ $user->id }}" action="{{ route('user.destroy',$user->id) }}" method="post" class=" d-inline  ">
                            @csrf @method('delete')
                            <input type="hidden" value="{{ $user->id }}" name="user_id">
                            <span class="pe-7s-trash text-danger text-decoration-none btn-sm btn btn-outline-secondary  icon-gradient bg-mean-fruit  fsize-1 " onclick="allow('{{ $user->name}}','{{  $user->id }}')"></span>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
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
                title: name + id,
                text: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#userDelete'+id).submit();

                }
            })
        }
    </script>

@endsection

