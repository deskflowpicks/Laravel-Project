
@extends('layouts.app')

@section('title', 'Admin Login | Komdigital')

@section('content')

<section class="auth-section">
    <div class="auth-card">

        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your Komdigital account.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                Sign In
            </button>

        </form>

        <div class="auth-footer">
            <a href="{{ route('password.request') }}">
                Forgot your password?
            </a>
        </div>

    </div>
</section>

@endsection
