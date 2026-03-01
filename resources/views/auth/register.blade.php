@extends('layouts.app')
@section('title', 'Register - TechDrop')

@section('content')
<div class="auth-section">
    <div class="auth-card">
        <div style="text-align:center;margin-bottom:20px;">
            <div class="logo-icon" style="margin:0 auto 12px;width:50px;height:50px;font-size:1.3rem;"><i class="fas fa-bolt"></i></div>
        </div>
        <h2>Create Account</h2>
        <p class="subtitle">Join TechDrop for exclusive deals</p>

        @if($errors->any())
            <div class="errors-box"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="form-group"><label>Full Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="John Doe"></div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="you@example.com"></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required placeholder="Min 6 characters"></div>
            <div class="form-group"><label>Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••"></div>
            <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:8px;"><i class="fas fa-user-plus"></i> Create Account</button>
        </form>
        <p class="auth-footer">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </div>
</div>
@endsection
