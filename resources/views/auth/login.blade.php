@extends('layouts.app')
@section('title', 'Login')
@section('hide_error_summary', true)

@section('content')
<div class="card narrow">
    <h1>Login</h1>
    <p class="muted">Sign in to add, edit or delete students.</p>
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="@error('email') invalid @enderror">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="@error('password') invalid @enderror">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button class="btn primary" type="submit">Login</button>
    </form>
    <p class="hint">Demo: admin@example.com / password</p>
</div>
@endsection
