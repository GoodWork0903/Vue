@extends('layouts.app')
@section('content')
    <form class="form-signin" class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <h1>Project with VueJs</h1>
        <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" value="{{ old('email') }}" placeholder="Email address" required autofocus>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
        </div>
        <button class="btn btn-lg btn-block" type="submit" style="background-color: #81c44d; color: white">Login</button>
        <p class="mt-5 mb-3 text-muted"> &copy; 2018  </p>
    </form>
@endsection
