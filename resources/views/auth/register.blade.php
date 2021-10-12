@extends('layouts.app')
@section('title') Register @endsection
@section('shortcut-link')
    <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i>&nbsp;Login</a></li>
@endsection
@section('content')
    
    <div class="ccol-md-4 col-centered">
        <h1></h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-sign-in"></i>&nbsp; <strong>Sign up to start your session</strong>
            </div>
            <div class="panel-body">
                @include('layouts.alert')
                <form role="form" action="{{ route('register') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required autofocus> 
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required> 
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-default btn-block">
                        <i class="fa fa-edit"></i>&nbsp;Sign Up Now
                    </button>
                </form>
            </div>
            <div class="panel-footer text-center"></div>
        </div>
    </div>

@endsection