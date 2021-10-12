@extends('layouts.app')
@section('title') 404 Page Not Found @endsection

@section('content')

<div class="text-center">
    <h1 class="error">404</h1>
    <p>This page cannot found or is missing.</p>
    <p>Use the navigation above or the button below to get back and track.</p>
    <a href="{{ url('') }}" class="btn btn-sm btn-success">
        <i class="fa fa-home"></i>&nbsp;Back to home
    </a>
</div>

@endsection