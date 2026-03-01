@extends('layouts.app')
@section('title', 'Login - TechDrop')

@section('content')
<div class="auth-section">
    <div class="auth-card">
        <div style="text-align:center;margin-bottom:20px;">
            <div class="logo-icon" style="margin:0 auto 12px;width:50px;height:50px;font-size:1.3rem;"><i class="fas fa-bolt"></i></div>
        </div>
        <h2>Welcome Back</h2>
        <p class="subtitle">Sign in to your TechDrop account</p>

        @if($errors->any())
            <div class="errors-box"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="you@example.com"></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required placeholder="••••••••"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                <label style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:var(--text-muted);cursor:pointer;"><input type="checkbox" name="remember" style="accent-color:var(--accent);"> Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fas fa-sign-in-alt"></i> Sign In</button>
        </form>
        <p class="auth-footer">Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
    </div>
</div>
@endsection
