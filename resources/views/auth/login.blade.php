@extends('layouts.app', ['title' => 'Log in'])

@section('content')
    <div class="card shadow-sm mx-auto auth-card">
        <div class="card-body p-4">
            <h1 class="h4 mb-4">Log in</h1>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" @checked(old('remember'))>
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>

                <button type="submit" class="btn btn-dark w-100">Log in</button>
            </form>

            <p class="text-center small mt-3 mb-0">
                New to Readit? <a href="{{ route('register') }}">Create an account</a>
            </p>
        </div>
    </div>
@endsection
