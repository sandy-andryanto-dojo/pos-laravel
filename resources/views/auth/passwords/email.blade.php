@extends('layouts.app')
@section('title') Reset Password @endsection
@section('shortcut-link')
    <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i>&nbsp;Login</a></li>
    <li><a href="{{ route('register') }}"><i class="fa fa-edit"></i>&nbsp;Register</a></li>
@endsection
@section('content')
    
    <div class="col-md-4 col-centered">
        <h1></h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-sign-in"></i>&nbsp; <strong>Please enter your email </strong>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form role="form" action="{{ route('password.email') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">E-Mail Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus> 
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-default btn-block">
                        <i class="fa fa-sign-in"></i>&nbsp;Send Password Reset Link
                    </button>
                </form>
            </div>
            <div class="panel-footer text-center"> </div>
        </div>
    </div>

@endsection