@extends('layouts.app')
@section('title') 403 Forbidden @endsection

@section('content')

<div class="text-center">
    <h1 class="error">403</h1>
    <p>You don't have permission to access on this server.</p>
    <a href="{{ url('') }}" class="btn btn-sm btn-success">
        <i class="fa fa-home"></i>&nbsp;Back to home
    </a>
</div>

@endsection