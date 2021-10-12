@extends('layouts.app')
@section('title') 400 Bad Request @endsection

@section('content')

<div class="text-center">
    <h1 class="error">400</h1>
    <p>Your browser sent an invalid request</p>
    <a href="{{ url('') }}" class="btn btn-sm btn-success">
        <i class="fa fa-home"></i>&nbsp;Back to home
    </a>
</div>

@endsection