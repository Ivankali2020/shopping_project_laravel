@extends('Backend.layout.app')
@section('title') Barcodes @endsection
@section('barcode_index_active','mm-active')
@section('content')
    <div class="app-page-title ">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-bandaid icon-gradient bg-mean-fruit ">
                    </i>
                </div>
                <div class="icon-gradient bg-mean-fruit"> BarCode</div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0   page-title-heading mt-3 mt-md-4 ">
        <div class="row ">
            @forelse($products as $p)
            <div class="col-md-3 mt-3 ">
                <div class="card bg-light  ">
                    <div class="card-body text-center">
                        {!!  DNS1D::getBarcodeSVG($p->product_code ?? 'px002', 'C39',1,50,'',false) !!}
                        <div class="h5 fw-bolder mt-2 ">{{$p->product_code ?? 'PX003'}}</div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
@endsection

@section('script')

@endsection
