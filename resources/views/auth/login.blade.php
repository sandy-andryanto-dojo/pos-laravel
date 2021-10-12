@extends('layouts.app')
@section('title') Login @endsection
@section('shortcut-link')
    <li><a href="{{ route('register') }}"><i class="fa fa-edit"></i>&nbsp;Register</a></li>
@endsection
@section('content')
    
    <div class="col-md-4 col-centered">
        <h1></h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-sign-in"></i>&nbsp; <strong>Sign in to start your session</strong>
            </div>
            <div class="panel-body">
                @include('layouts.alert')
                <form role="form" action="{{ route('login') }}" method="post">
                    {{ csrf_field() }} 
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="name">Username Or Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus> 
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
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default btn-block">
                        <i class="fa fa-sign-in"></i>&nbsp;Submit
                    </button>
                </form>
            </div>
            <div class="panel-footer text-center">
                <a href="{{ route('password.request') }}" class="btn btn-sm btn-success">
                    Forgot Password ?
                </a>
            </div>
        </div>
    </div>

@endsection