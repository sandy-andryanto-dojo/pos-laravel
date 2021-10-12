@php $pageName = "Purchase Order"; @endphp
@extends('layouts.app')
@section('title') {{ $pageName }} @endsection
@section('content')

<h1 class="page-header">{{ $pageName }}
    <small>Management</small>
</h1>

<ol class="breadcrumb">
    <li><a href="{{ url('') }}">Home</a></li>
    <li><a href="javascript:void(0);">Transaction</a></li>
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
        {!! Form::model($model, ['method' => 'PATCH','class'=>'','id'=>'form-invoice','route' => [$route.'.update', $model->id] ,'enctype'=>'multipart/form-data']) !!} 

    
        <div class="form-group col-md-3">
            <label for="name">Invoice Date</label>
            <input type="text" class="form-control" value="{{ $model->created_at }}" readonly="readonly" />
        </div>

        <div class="form-group col-md-3">
            <label for="name">Invoice Number</label>
            <input type="text" class="form-control" value="{{ $model->invoice_number }}" readonly="readonly" />
        </div>

        <div class="form-group col-md-3">
            <label for="name">Supplier</label>
            {!! Form::select('supplier_id', $suppliers->pluck('name','id'), $model->supplier_id, ['id'=>'supplier_id','class'=>'select2 form-control', 'placeholder'=> 'Select Supplier']) !!}
        </div>

        <div class="form-group col-md-3">
            <label for="name">Casheir</label>
            <input type="text" class="form-control" value="{{ $model->Casheir->username }}" readonly="readonly" />
        </div>

        <div class="clearfix"></div>

        <div class="container-fluid table-responsive">
            <table class="table" id="table-invoice">
                <thead>
                    <tr>
                        <th> Product</th>
                        <th width="200">Price</th>
                        <th width="90">Qty</th>
                        <th width="200">Total</th>
                        <th width="70">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td>
                            <a href="javascript:void(0);" class="btn btn-sm btn-info" id="btn-add">
                                <i class="fa fa-plus"></i>
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="clearfix"></div>

        <div class="form-group col-md-6">
            <label for="name">Grandtotal</label>
            <input type="number" step="any" id="grandtotal" name="grandtotal" class="form-control" value="{{ $model->grandtotal }}" readonly="readonly" />
        </div>

        <div class="clearfix"></div>
        <hr>

        <div class="form-group">
            <div class="clearfix">
                <div class="pull-left">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i>&nbsp;Save & Finish
                    </button>
                </div>
                <div class="pull-right">
                    <button type="reset" class="btn btn-warning">
                        <i class="fa fa-refresh"></i>&nbsp;Reset
                    </button>    
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
    <div class="panel-footer"></div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('scripts/purchases.js') }}"></script>
@endsection