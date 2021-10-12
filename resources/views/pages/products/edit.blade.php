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
    <li class="active">Edit Data</li>
</ol>

@include('layouts.alert')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                <i class="fa fa-plus"></i>&nbsp;<strong>Edit Data</strong>
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
            <input type="hidden" class="file-input-image-preview" value="{{ $image }}" />
            <div class="form-group {{ $errors->has('sku') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="sku">SKU :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="sku" name="sku" value="{{ $model->sku }}">
                    @if ($errors->has('sku'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sku') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
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
            <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="image">Image :</label>
                <div class="col-sm-10">
                    <input type="file" class="file-input-image" id="file" name="file">
                </div>
            </div>
            <div class="form-group {{ $errors->has('brand_id') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="brand_id">Brand :</label>
                <div class="col-sm-10">
                    {!! Form::select('brand_id', $brands->pluck('name','id'), null, ['id'=>'brand_id','class'=>'select2 form-control', 'placeholder'=> 'Select Item']) !!}
                    @if ($errors->has('brand_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('brand_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('type_id') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="type_id">Type :</label>
                <div class="col-sm-10">
                    {!! Form::select('type_id', $types->pluck('name','id'), null, ['id'=>'type_id','class'=>'select2 form-control', 'placeholder'=> 'Select Item']) !!}
                    @if ($errors->has('type_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="supplier_id">Supplier :</label>
                <div class="col-sm-10">
                    {!! Form::select('supplier_id', $suppliers->pluck('name','id'), null, ['id'=>'supplier_id','class'=>'select2 form-control', 'placeholder'=> 'Select Item']) !!}
                    @if ($errors->has('supplier_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('supplier_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('categories') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="categories">Categories :</label>
                <div class="col-sm-10">
                    {!! Form::select('categories[]', $categories->pluck('name','id'), $model->Category()->get()->pluck("id")->toArray(), ['id'=>'categories','class'=>'select2 form-control',  'multiple'=>'multiple']) !!}
                    @if ($errors->has('roles'))
                        <span class="help-block">
                            <strong>{{ $errors->first('categories') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('price_purchase') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="price_purchase">Price Purchase :</label>
                <div class="col-sm-10">
                    <input type="number" min="0" class="form-control" id="price_purchase" name="price_purchase" value="{{ $model->price_purchase }}">
                    @if ($errors->has('price_purchase'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price_purchase') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('price_sales') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="price_sales">Price Sale :</label>
                <div class="col-sm-10">
                    <input type="number" readonly="readonly" min="0" class="form-control" id="price_sales" name="price_sales" value="{{ $model->price_sales }}">
                    @if ($errors->has('price_sales'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price_sales') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('price_profit') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="price_profit">Profit (%) :</label>
                <div class="col-sm-10">
                    <input type="number" min="0" max="100" step="any" class="form-control" id="price_profit" name="price_profit" value="{{ $model->price_profit }}">
                    @if ($errors->has('price_profit'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price_profit') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('stock') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="stock">Stock :</label>
                <div class="col-sm-10">
                    <input type="number" min="0" max="100"  class="form-control" id="stock" name="stock" value="{{ $model->stock }}">
                    @if ($errors->has('stock'))
                        <span class="help-block">
                            <strong>{{ $errors->first('stock') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('date_expired') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="date_expired">Date Expired :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-datepicker" id="date_expired" name="date_expired" value="{{ $model->date_expired  }}">
                    @if ($errors->has('date_expired'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_expired') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="description">Description :</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" rows="5">{{  $model->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="notes">Notes :</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="notes" name="notes" rows="5">{{  $model->notes }}</textarea>
                    @if ($errors->has('notes'))
                        <span class="help-block">
                            <strong>{{ $errors->first('notes') }}</strong>
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
<script src="{{ asset('scripts/products.js') }}"></script>
@endsection