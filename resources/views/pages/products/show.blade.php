@php $pageName = "Product"; @endphp
@extends('layouts.app')
@section('title') {{ $pageName }} @endsection
@section('content')

<h1 class="page-header">{{ $pageName }}
    <small>Management</small>
</h1>

<ol class="breadcrumb">
    <li><a href="{{ url('') }}">Home</a></li>
    <li><a href="javascript:void(0);">Master</a></li>
    <li><a href="{{ route($route.'.index') }}">{{ $pageName }}</a></li>
    <li class="active">Detail</li>
</ol>

@include('layouts.alert')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                <i class="fa fa-search"></i>&nbsp;<strong>Detail</strong>
            </div>
            <div class="pull-right">
                <a href="{{ route($route.'.index') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-rotate-left"></i>&nbsp;Back
                </a>
                @can("add_".$route)
                <a href="{{ route($route.'.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i>&nbsp;Create New
                </a>
                @endcan
                @can("edit_".$route)
                <a href="{{ route($route.'.edit', ['id'=> $model->id]) }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-edit"></i>&nbsp;Edit Data
                </a>
                @endcan
                @can("delete_".$route)
                <a href="javascript:void(0);" class="btn btn-sm btn-danger" id="btn-delete">
                    <i class="fa fa-trash"></i>&nbsp;Delete
                </a>
                <form id="delete-form" action="{{ route($route.'.destroy', ['id'=> $model->id]) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                </form>
                @endcan
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-2">SKU :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->sku }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Name :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->name }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Image :</label>
                <div class="col-sm-3">
                    <img src="{{ $image }}" class="img img-responsive img-thumbnail" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Brand :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->Brand ? $model->Brand->name : null }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Type :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->Type ? $model->Type->name : null }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Supplier :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->Supplier ? $model->Supplier->name : null }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Categories :</label>
                <div class="col-sm-10">
                    @php $categories = $model->Category()->get()->pluck("name")->toArray(); @endphp
                    <p class ="form-control-static">{{ count($categories) > 0 ? implode(", ", $categories) : null }}</p> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Stock :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->stock }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Price Purchase :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->price_purchase }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Price Sales :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->price_sales }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Profit :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->price_profit }} %</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Date Expired :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->date_expired }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Description :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->description }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Notes :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->notes }}</p>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer"></div>
</div>

@endsection