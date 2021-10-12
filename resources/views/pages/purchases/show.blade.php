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
                @if($model->status == 0)
                    @can("delete_".$route)
                    <a href="javascript:void(0);" class="btn btn-sm btn-danger" id="btn-delete">
                        <i class="fa fa-trash"></i>&nbsp;Delete
                    </a>
                    <form id="delete-form" action="{{ route($route.'.destroy', ['id'=> $model->id]) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                    @endcan
                @else
                    <a href="javascript:void(0);" data-href="{{ route($route.'.show', ['id'=> 'print-'.$model->id]) }}" class="btn btn-sm btn-info" id="btn-print">
                        <i class="fa fa-print"></i>&nbsp;Print
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="container-fluid table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Invoice Date : {{ $model->created_at }}</th>
                        <th colspan="2">Invoice Number : {{ $model->invoice_number }}</th>
                    </tr>
                    <tr>
                        <th colspan="2">Supplier : {{ isset($model->Supplier->name) ? $model->Supplier->name : null }}</th>
                        <th colspan="2">Casheir : {{ isset($model->Casheir->username) ? $model->Casheir->username : null }}</th>
                    </tr>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($details) > 0)
                        @foreach($details as $detail)
                            <tr>
                                <td>{{ $detail->Product->sku }} - {{ $detail->Product->name }}</td>
                                <td>{{ $detail->price }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>{{ $detail->total }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr class='text-center'>
                        <td colspan='4'>
                            -- No Items --
                        </td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Grand Total : {{ $model->grandtotal }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        {!! $model->status == 1 ? '<span class="label label-success">Status :  Paid</span></td>' : '<span class="label label-danger">Status :  Unpaid</span></td>' !!}
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">  &times;</button>
            <h4 class="modal-title" id="myModalLabel">
               <i class="fa fa-print"></i>&nbsp;Print Invoice
            </h4>
         </div>
         <div class="modal-body">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" id="iframe-invoice" src="{{ url("") }}"></iframe>
            </div>
         </div>
         <div class="modal-footer"></div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->

@endsection

@section('scripts')
<script src="{{ asset('scripts/purchases.js') }}"></script>
@endsection