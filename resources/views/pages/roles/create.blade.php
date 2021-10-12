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

            <div class="form-group {{ $errors->has('permissions') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Permissions <span class="text-danger">*</span> </label>
                <div class="col-md-10">
                        <div class="col-md-5">
                        <div class="checkbox">
                            <input type="checkbox" id="checked-all"><label for="checked-all"><strong>Select All</strong></label> 
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    @php $i = 0; $actions = array("view","add","edit","delete"); $icons = array("fa fa-search","fa fa-plus","fa fa-edit","fa fa-trash"); @endphp
                    @foreach($permissions as $p)
                        <div class="col-md-3">
                            <div class="checkbox">
                                <input type="checkbox" class="action" id="{{ $actions[$i] }}" />
                                <label for="{{ $actions[$i] }}">
                                    <i class="{{ $icons[$i] }}"></i>&nbsp;<strong>{{ ucfirst($actions[$i]) }}</strong>
                                </label> 
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        @foreach($p as $perm)
                            @php 
                                $per_found = null; if(isset($model)) $per_found = $model->hasPermissionTo($perm->name);
                                $options = array();
                                if(isset($model) && $model->name == 'Admin'){
                                    $options = ["disabled", "id"=>$perm->id, "class"=>  $actions[$i]];
                                }else{
                                    $options = ["id"=>"perm".$perm->id,  "class"=>  $actions[$i]];
                                }
                            @endphp
                            <div class="col-md-3">
                                <div class="checkbox">
                                    {!! Form::checkbox("permissions[]", $perm->name, $per_found,  $options) !!}
                                    <label class="{{ str_contains($perm->name, 'delete') ? 'text-danger' : '' }}" for="perm{{ $perm->id }}">{{ strtoupper($perm->name) }}</label> 
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <hr>
                    @php $i++; @endphp
                    @endforeach
                    <div class="clearfix"></div>
                    @if ($errors->has('permissions'))
                        <span class="help-block">
                            <strong>{{ $errors->first('permissions') }}</strong>
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


@section('scripts')
<script src="{{ asset('scripts/roles.js') }}"></script>
@endsection