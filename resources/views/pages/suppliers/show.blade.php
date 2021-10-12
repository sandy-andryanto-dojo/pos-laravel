@php $pageName = "Supplier"; @endphp
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
                <label class="control-label col-sm-2">Name :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->name }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Phone :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->phone }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->email }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Website :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->website }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Address :</label>
                <div class="col-sm-10">
                    <p class ="form-control-static">{{ $model->address }}</p>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer"></div>
</div>

@endsection