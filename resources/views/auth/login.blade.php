@extends('layouts.auth')
@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        overflow-x: hidden;
    }

    /* Header */
    .header {
        background-color: #fff;
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        margin: 0;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 200px;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background-color: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .logo-text {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    /* Navigation */
    .nav {
        background-color: #ffd700;
        padding: 10px 0;
        position: sticky;
        top: 60px;
        z-index: 99;
        margin: 0;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        padding: 0 20px;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .nav-link {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .nav-link:hover {
        background-color: rgba(0,0,0,0.1);
    }

    /* Login Container */
    .auth-login-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-login-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }

    .auth-login-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    .auth-login-form-group {
        margin-bottom: 20px;
    }

    .auth-login-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-login-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .auth-login-input:focus {
        outline: none;
        border-color: #333;
    }

    .auth-login-captcha-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .auth-login-captcha-label {
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-login-captcha-image {
        max-width: 200px;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f0f0f0;
    }

    .auth-login-submit-btn {
        width: 100%;
        background-color: #333;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 10px;
    }

    .auth-login-submit-btn:hover {
        background-color: #555;
    }

    .auth-login-links {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .auth-login-links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-login-links a:hover {
        color: #007bff;
    }

    .auth-login-links-separator {
        margin: 0 10px;
        color: #666;
    }

    /* Error Messages */
    .alert {
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
            gap: 15px;
        }

        .nav-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .auth-login-inner {
            padding: 30px 20px;
        }

        .auth-login-title {
            font-size: 20px;
        }

        .logo-text {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .auth-login-container {
            padding: 0 10px;
        }

        .auth-login-inner {
            padding: 20px 15px;
        }

        .auth-login-input {
            font-size: 16px; /* Prevents zoom on iOS */
        }
    }
</style>

<!-- Header -->
<div class="header">
    <div class="header-top">
        <div class="logo">
            <div class="logo-icon">S</div>
            <div class="logo-text">Silk Highway</div>
        </div>
        
        <div class="header-right">
            <span>🇺🇸 EN</span>
            <span>💰 XMR</span>
        </div>
    </div>
</div>

<!-- Navigation -->
<div class="nav">
    <div class="nav-container">
        <a href="#" class="nav-link">🏠 Home</a>
        <a href="#" class="nav-link">📋 Rules</a>
        <a href="#" class="nav-link">📖 Guide</a>
        <a href="#" class="nav-link">🎧 Support</a>
    </div>
</div>

<!-- Login Form -->
<div class="auth-login-container">
    <div class="auth-login-inner">
        <h2 class="auth-login-title">Login to {{ config('app.name') }}</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="auth-login-form-group">
                <label for="username" class="auth-login-label">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                       class="auth-login-input" required minlength="4" maxlength="16" 
                       placeholder="Enter your username">
            </div>
            
            <div class="auth-login-form-group">
                <label for="password" class="auth-login-label">Password</label>
                <input type="password" id="password" name="password" 
                       class="auth-login-input" required minlength="8" maxlength="40"
                       placeholder="Enter your password">
            </div>
            
            <div class="auth-login-form-group">
                <div class="auth-login-captcha-wrapper">
                    <div class="auth-login-captcha-label">CAPTCHA</div>
                    <img src="{{ new Mobicms\Captcha\Image($captchaCode) }}" alt="CAPTCHA Image" class="auth-login-captcha-image">
                    <input type="text" id="captcha" name="captcha" class="auth-login-input" 
                           required minlength="1" maxlength="8" placeholder="Enter CAPTCHA code">
                </div>
            </div>
            
            <button type="submit" class="auth-login-submit-btn">🔐 Login</button>
        </form>
        
        <div class="auth-login-links">
            <a href="{{ route('register') }}">Create an Account</a>
            <span class="auth-login-links-separator">|</span>
            <a href="{{ route('password.request') }}">Forgot Password</a>
        </div>
    </div>
</div>

<script>
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const captcha = document.getElementById('captcha').value;
        
        if (username.length < 4 || username.length > 16) {
            e.preventDefault();
            alert('Username must be between 4 and 16 characters');
            return;
        }
        
        if (password.length < 8 || password.length > 40) {
            e.preventDefault();
            alert('Password must be between 8 and 40 characters');
            return;
        }
        
        if (captcha.length < 1) {
            e.preventDefault();
            alert('Please enter the CAPTCHA code');
            return;
        }
    });

    // Input focus effects
    document.querySelectorAll('.auth-login-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = '#333';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = '#ddd';
        });
    });

    // CAPTCHA refresh functionality (if needed)
    document.querySelector('.auth-login-captcha-image').addEventListener('click', function() {
        // Refresh CAPTCHA image
        this.src = this.src + '?' + new Date().getTime();
    });
</script>

@endsection
