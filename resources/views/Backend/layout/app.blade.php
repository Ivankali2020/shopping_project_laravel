<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('Backend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

@yield('style')
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    <link href="{{ asset('Backend/css/main.css') }}" rel="stylesheet"></head>
<body>
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    @include('Backend.layout.header')

    <div class="app-main">
        @include('Backend.layout.sidebar')

        <div class="app-main__outer">
            <div class="app-main__inner">

                @yield('content')

            </div>
            <div class="app-wrapper-footer">
                <div class="app-footer">
                    <div class="app-footer__inner">
                        <div class="app-footer-left">
                        <span class="d-flex align-items-baseline ">
                            <span class="font-weight-bolder ">Copyright  {{ date('Y') }} All right reserved by </span>
                            <img src="{{ asset("Backend/assets/images/logo-inverse.png") }}" class="ml-2 " alt="">

                        </span>
                        </div>
                        <div class="app-footer-right">
                        <span class="font-weight-bolder ">
                            Developed By Ivan
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="{{ asset('Backend/assets/scripts/main.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
{{--<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>--}}


{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>--}}
{{--sweet alert 2--}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@yield('script')

{{--this is for session alert with toast--}}
{{--@include('Backend.layout.flash')--}}
{{--@include('components.alert')--}}
@include('components.message')
<script>
    // $(document).ready(function (){
    //    $('#backBtn').click(function (){
    //        history.back();
    //        return false;
    //    })
    // });
</script>

</body>
</html>

