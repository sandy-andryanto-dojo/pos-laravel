@php $pageName = "Report"; @endphp
@extends('layouts.app')
@section('title') {{ $pageName }} @endsection
@section('content')

<h1 class="page-header">{{ $pageName }}
    <small></small>
</h1>

<ol class="breadcrumb">
    <li><a href="{{ url('') }}">Home</a></li>
    <li class="active">{{ $pageName }}</li>
</ol>

@include('layouts.alert')

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-table"></i>&nbsp;<strong>List Of Report</strong>
    </div>
    <div class="panel-body">
        <div class="container-fluid table-responsive">
            <table class="table table-striped" id="table-data">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Purchase By Period</strong>
                        </td>
                        <td>
                            @php 
                                $arr = array();
                                $arr[] = 0;
                                $arr[] = 1;
                                $arr[] = $firstDate;
                                $arr[] = $lastDate;
                                $prefix = implode("_", $arr);
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-sm btn-success btn-report-show" data-href="{{ route('reports.show', ['id'=> $prefix]) }}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Purchase By Supplier</strong>
                        </td>
                        <td>
                            @php 
                                $arr = array();
                                $arr[] = 0;
                                $arr[] = 2;
                                $arr[] = $firstDate;
                                $arr[] = $lastDate;
                                $prefix = implode("_", $arr);
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-sm btn-success btn-report-show" data-href="{{ route('reports.show', ['id'=> $prefix]) }}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Purchase By Product</strong>
                        </td>
                        <td>
                            @php 
                                $arr = array();
                                $arr[] = 0;
                                $arr[] = 3;
                                $arr[] = $firstDate;
                                $arr[] = $lastDate;
                                $prefix = implode("_", $arr);
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-sm btn-success btn-report-show" data-href="{{ route('reports.show', ['id'=> $prefix]) }}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Sale By Period</strong>
                        </td>
                        <td>
                            @php 
                                $arr = array();
                                $arr[] = 1;
                                $arr[] = 1;
                                $arr[] = $firstDate;
                                $arr[] = $lastDate;
                                $prefix = implode("_", $arr);
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-sm btn-success btn-report-show" data-href="{{ route('reports.show', ['id'=> $prefix]) }}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Sale By Customer</strong>
                        </td>
                        <td>
                            @php 
                                $arr = array();
                                $arr[] = 1;
                                $arr[] = 2;
                                $arr[] = $firstDate;
                                $arr[] = $lastDate;
                                $prefix = implode("_", $arr);
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-sm btn-success btn-report-show" data-href="{{ route('reports.show', ['id'=> $prefix]) }}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Sale By Product</strong>
                        </td>
                        <td>
                            @php 
                                $arr = array();
                                $arr[] = 1;
                                $arr[] = 3;
                                $arr[] = $firstDate;
                                $arr[] = $lastDate;
                                $prefix = implode("_", $arr);
                            @endphp
                            <a href="javascript:void(0);" class="btn btn-sm btn-success btn-report-show" data-href="{{ route('reports.show', ['id'=> $prefix]) }}">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">  &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-line-chart"></i>&nbsp;Report Preview
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group col-md-6">
                        <label for="first_date">First Date:</label>
                        <input type="text" class="form-control date-filter" id="first_date" value="{{ $firstDate }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_date">Last Date:</label>
                        <input type="text" class="form-control date-filter" id="last_date" value="{{ $lastDate }}">
                    </div>
                    <div class="form-group col-md-6">
                        <a href="javascript:void(0);" class="btn btn-sm btn-success" id="btn-print">
                            <i class="fa fa-print"></i>&nbsp;Print Report
                        </a>
                    </div>
                </form>
                <div class="clearfix"></div>
                <hr>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" id="iframe-report" src="{{ url("") }}"></iframe>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
        

@endsection



@section('scripts')
<script src="{{ asset('scripts/reports.js') }}"></script>
@endsection
