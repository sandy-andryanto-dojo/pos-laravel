@extends('layouts.app')
@section('title') 500 Internal Server Error @endsection

@section('content')

<div class="text-center">
    <h1 class="error">500</h1>
    <p>Internal Server Error, Why not try refreshing your page? or you can contact</p>
    <a href="{{ url('') }}" class="btn btn-sm btn-success">
        <i class="fa fa-home"></i>&nbsp;Back to home
    </a>
</div>

@endsection