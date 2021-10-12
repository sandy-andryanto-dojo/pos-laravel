@php $pageName = "User"; @endphp
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
            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                <label class="control-label col-sm-3" for="username">Username :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username" value="{{ $model->username }}">
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label col-sm-3" for="email">Email :</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $model->email }}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                <label class="control-label col-sm-3" for="phone">Phone :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $model->phone }}">
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label col-sm-3" for="password">Password :</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" value="">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label class="control-label col-sm-3" for="password_confirmation">Password Confirmation :</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('roles') ? ' has-error' : '' }}">
                <label class="control-label col-sm-3" for="roles">Roles :</label>
                <div class="col-sm-9">
                    {!! Form::select('roles[]', $roles->pluck('name','id'), null, ['id'=>'role_id','class'=>'select2 form-control',  'multiple'=>'multiple']) !!}
                    @if ($errors->has('roles'))
                        <span class="help-block">
                            <strong>{{ $errors->first('roles') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9">
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