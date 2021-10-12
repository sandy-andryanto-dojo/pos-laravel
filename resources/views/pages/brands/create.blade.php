@php $pageName = "Brand"; @endphp
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
    <li class="active">Create New</li>
</ol>

@include('layouts.alert')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                <i class="fa fa-plus"></i>&nbsp;<strong>Create New</strong>
            </div>
            <div class="pull-right">
                <a href="{{ route($route.'.index') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-rotate-left"></i>&nbsp;Back
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(array('route' => $route.'.store','method'=>'POST','class'=>'form-horizontal','id'=>'form-submit','role'=>'form','enctype'=>'multipart/form-data')) !!}
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="name">Name :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="description">Description :</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i>&nbsp;Save
                    </button>
                    <button type="reset" class="btn btn-warning">
                        <i class="fa fa-refresh"></i>&nbsp;Reset
                    </button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="panel-footer"></div>
</div>

@endsection