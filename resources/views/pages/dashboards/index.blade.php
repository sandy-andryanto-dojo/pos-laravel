@php $pageName = "Dashboard"; @endphp

@extends('layouts.app')
@section('title') {{ $pageName }} @endsection
@section('content')

<h1 class="page-header">{{ $pageName }}
    <small>Summary</small>
</h1>

<ol class="breadcrumb">
    <li><a href="{{ url('') }}">Home</a></li>
    <li><a href="javascript:void(0);">Dashboard</a></li>
    <li class="active">Summary&nbsp;<span id="loader"><i class="fa fa-spinner fa-spin"></i></span></li>
</ol>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-space-shuttle"></i>&nbsp;<strong>Product</strong>
            </div>
            <div class="panel-body">
                <h1 class="count-product">0</h1>
            </div>
            <div class="panel-footer">
                <a href="{{ route('products.index') }}" target="_blank" class="btn btn-xs btn-success">
                    <i class="fa fa-search"></i>&nbsp;See More..
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-truck"></i>&nbsp;<strong>Supplier</strong>
            </div>
            <div class="panel-body">
                <h1 class="count-supplier">0</h1>
            </div>
            <div class="panel-footer">
                <a href="{{ route('suppliers.index') }}" target="_blank" class="btn btn-xs btn-success">
                    <i class="fa fa-search"></i>&nbsp;See More..
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-users"></i>&nbsp;<strong>Customer</strong>
            </div>
            <div class="panel-body">
                <h1 class="count-customer">0</h1>
            </div>
            <div class="panel-footer">
                <a href="{{ route('customers.index') }}" target="_blank" class="btn btn-xs btn-success">
                    <i class="fa fa-search"></i>&nbsp;See More..
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-car"></i>&nbsp;<strong>Brand</strong>
            </div>
            <div class="panel-body">
                <h1 class="count-brand">0</h1>
            </div>
            <div class="panel-footer">
                <a href="{{ route('brands.index') }}" target="_blank" class="btn btn-xs btn-success">
                    <i class="fa fa-search"></i>&nbsp;See More..
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-cart-plus"></i>&nbsp;<strong>Sale By Product {{ date('Y') }}</strong>
            </div>
            <div class="panel-body">
                <div id="pie-chart1" style="height: 400px;  margin: 0 auto"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-cart-arrow-down"></i>&nbsp;<strong>Purchase By Product {{ date('Y') }}</strong>
            </div>
            <div class="panel-body">
                <div id="pie-chart2" style="height: 400px;  margin: 0 auto"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="panel panel-default text-center">
            <div class="panel-heading">
                <i class="fa fa-line-chart"></i>&nbsp;<strong>Sale vs Purchase {{ date('Y') }}</strong>
            </div>
            <div class="panel-body">
                <div id="bar-chart" style="height: 400px;  margin: 0 auto"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('plugins/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('scripts/dashboards.js') }}"></script>
@endsection