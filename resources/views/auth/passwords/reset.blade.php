@extends('layouts.app')
@section('title') Register @endsection
@section('shortcut-link')
    <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i>&nbsp;Login</a></li>
@endsection
@section('content')
    
    <div class="col-md-4 col-centered">
        <h1></h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-sign-in"></i>&nbsp; <strong>Please enter your email and password</strong>
            </div>
            <div class="panel-body">
                @include('layouts.alert')
                <form role="form" action="{{ route('password.request') }}" method="post">
                    {{ csrf_field() }} 
                    <input type="hidden" name="token" value="{{ $token }}">
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
                        <i class="fa fa-refresh"></i>&nbsp;Reset Password
                    </button>
                </form>
            </div>
            <div class="panel-footer text-center"></div>
        </div>
    </div>

@endsection