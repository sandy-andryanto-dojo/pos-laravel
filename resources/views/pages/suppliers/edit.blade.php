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
    <li class="active">Edit Data</li>
</ol>

@include('layouts.alert')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                <i class="fa fa-edit"></i>&nbsp;<strong>Edit Data</strong>
            </div>
            <div class="pull-right">
                <a href="{{ route($route.'.index') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-rotate-left"></i>&nbsp;Back
                </a>
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
        {!! Form::model($model, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'form-submit','route' => [$route.'.update', $model->id] ,'enctype'=>'multipart/form-data']) !!} 
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="name">Name :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $model->name }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="phone">Phone :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $model->phone }}">
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="email">Email :</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $model->email }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="website">Website :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="website" name="website" value="{{ $model->website }}">
                    @if ($errors->has('website'))
                        <span class="help-block">
                            <strong>{{ $errors->first('website') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="address">Address :</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="address" name="address" rows="5">{{ $model->address }}</textarea>
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
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