@extends('layouts.app')
@section('title') 503 This site is getting a tune-up @endsection

@section('content')

<div class="text-center">
    <h1 class="error">503</h1>
    <p>This site is getting a tune-up, Why don't you come back in a little while and see if our expert are finished tinkering.</p>
    <a href="{{ url('') }}" class="btn btn-sm btn-success">
        <i class="fa fa-home"></i>&nbsp;Back to home
    </a>
</div>

@endsection