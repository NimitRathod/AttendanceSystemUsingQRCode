@extends('backend.layout.appLog')

@section('content')
<!-- nimitrathod1997@gmail.com=>142536 -->
<div class="login-box">
    <div class="login-logo">
        <a href="/bck" style="margin-left: -25%;">
            "<b>{{ config('app.name') }}</b>"
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form method="POST" action="{{ route('login') }}" class="user" >
            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" placeholder="Enter Email Address..." required autofocus>
                @if ($errors->has('email'))
                <span class="invalid-feedback text-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}  form-control-user" name="password" placeholder="Password" required>

                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                {{ __('Login') }}
            </button>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
</body>
@endsection
