@php $pageName = "Category"; @endphp
@extends('layouts.app')
@section('title') {{ $pageName }} @endsection
@section('content')

<h1 class="page-header">{{ $pageName }}
    <small>Management</small>
</h1>

<ol class="breadcrumb">
    <li><a href="{{ url('') }}">Home</a></li>
    <li><a href="javascript:void(0);">Master</a></li>
    <li class="active">{{ $pageName }}</li>
</ol>

@include('layouts.alert')

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                <i class="fa fa-table"></i>&nbsp;<strong>List {{ $pageName }}</strong>
            </div>
            <div class="pull-right">
                @can("add_".$route)
                <a href="{{ route($route.'.create') }}" class="btn btn-sm btn-info">
                    <i class="fa fa-plus"></i>&nbsp;Create New
                </a>
                @endcan
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="container-fluid table-responsive">
            <table class="table table-striped" id="table-data">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer"></div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('scripts/categories.js') }}"></script>
@endsection