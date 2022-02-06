@extends('Backend.layout.app')
@section('title') Create User  @endsection
@section('user_create_active','mm-active')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div> Create  User </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-7 m-auto">
            <div class="card card-body mt-3" >

                <form action="{{ route('user.store') }}" method="post" id="create">
                    @csrf

                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text"  class="form-control " name="name" >

                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control " name="email" >

                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password"  class="form-control " name="password" >

                    </div>

                    <div class="form-group">
                        <label for="">Role</label>
                        <input type="number"  class="form-control  " name="role" >

                    </div>

                    <div class="form-group text-right">
                        <button type="button" id="backBtn" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-info">Create Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UserCreateRequest', '#create'); !!}
@endsection

