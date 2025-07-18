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

    /* Register Container */
    .auth-register-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-register-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }

    .auth-register-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 30px;
    }

    .auth-register-form-group {
        margin-bottom: 20px;
    }

    .auth-register-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-register-optional-text {
        font-weight: normal;
        color: #666;
        font-size: 12px;
    }

    .auth-register-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .auth-register-input:focus {
        outline: none;
        border-color: #333;
    }

    .auth-register-captcha-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .auth-register-captcha-label {
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-register-captcha-image {
        max-width: 200px;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .auth-register-submit-btn {
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

    .auth-register-submit-btn:hover {
        background-color: #555;
    }

    .auth-register-links {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .auth-register-links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-register-links a:hover {
        color: #007bff;
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

    .alert-info {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
    }

    /* Form validation styles */
    .auth-register-input.error {
        border-color: #e74c3c;
    }

    .auth-register-input.success {
        border-color: #28a745;
    }

    .validation-message {
        font-size: 12px;
        margin-top: 5px;
        padding: 5px;
        border-radius: 3px;
    }

    .validation-error {
        color: #e74c3c;
        background-color: #fdf2f2;
    }

    .validation-success {
        color: #28a745;
        background-color: #f2f8f2;
    }

    /* Password strength indicator */
    .password-strength {
        margin-top: 5px;
        height: 4px;
        background-color: #f0f0f0;
        border-radius: 2px;
        overflow: hidden;
    }

    .password-strength-bar {
        height: 100%;
        transition: width 0.3s, background-color 0.3s;
        width: 0%;
        background-color: #e74c3c;
    }

    .password-strength-bar.weak {
        width: 33%;
        background-color: #e74c3c;
    }

    .password-strength-bar.medium {
        width: 66%;
        background-color: #f39c12;
    }

    .password-strength-bar.strong {
        width: 100%;
        background-color: #28a745;
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

        .auth-register-inner {
            padding: 30px 20px;
        }

        .auth-register-title {
            font-size: 20px;
        }

        .logo-text {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .auth-register-container {
            padding: 0 10px;
        }

        .auth-register-inner {
            padding: 20px 15px;
        }

        .auth-register-input {
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

<!-- Register Form -->
<div class="auth-register-container">
    <div class="auth-register-inner">
        <h2 class="auth-register-title">Register to {{ config('app.name') }}</h2>
        
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

        @if (config('marketplace.require_reference_code', true))
            <div class="alert alert-info">
                <strong>Note:</strong> A valid reference code is required to register. Contact an existing member to obtain one.
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf
            
            <div class="auth-register-form-group">
                <label for="username" class="auth-register-label">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                       class="auth-register-input" required minlength="4" maxlength="16" 
                       placeholder="Enter your username (4-16 characters)">
                <div id="username-validation" class="validation-message" style="display: none;"></div>
            </div>
            
            <div class="auth-register-form-group">
                <label for="password" class="auth-register-label">Password</label>
                <input type="password" id="password" name="password" 
                       class="auth-register-input" required minlength="8" maxlength="40"
                       placeholder="Enter your password (8-40 characters)">
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
                <div id="password-validation" class="validation-message" style="display: none;"></div>
            </div>
            
            <div class="auth-register-form-group">
                <label for="password_confirmation" class="auth-register-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="auth-register-input" required minlength="8" maxlength="40"
                       placeholder="Confirm your password">
                <div id="password-confirm-validation" class="validation-message" style="display: none;"></div>
            </div>
            
            <div class="auth-register-form-group">
                <label for="reference_code" class="auth-register-label">
                    Reference Code
                    @if(!config('marketplace.require_reference_code', true))
                        <span class="auth-register-optional-text">(Optional)</span>
                    @endif
                </label>
                <input type="text" 
                       id="reference_code" 
                       name="reference_code" 
                       value="{{ old('reference_code') }}"
                       class="auth-register-input"
                       @if(config('marketplace.require_reference_code', true)) required @endif
                       minlength="12" maxlength="20"
                       placeholder="Enter reference code (12-20 characters)">
                <div id="reference-validation" class="validation-message" style="display: none;"></div>
            </div>
            
            <div class="auth-register-form-group">
                <div class="auth-register-captcha-wrapper">
                    <div class="auth-register-captcha-label">CAPTCHA</div>
                    <img src="{{ $captchaImage }}" alt="CAPTCHA Image" class="auth-register-captcha-image" id="captchaImage">
                    <input type="text" id="captcha" name="captcha" class="auth-register-input" 
                           required minlength="1" maxlength="8" placeholder="Enter CAPTCHA code">
                    <div id="captcha-validation" class="validation-message" style="display: none;"></div>
                </div>
            </div>
            
            <button type="submit" class="auth-register-submit-btn">🚀 Register</button>
        </form>
        
        <div class="auth-register-links">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>

<script>
    // Form validation and real-time feedback
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registerForm');
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        const referenceCode = document.getElementById('reference_code');
        const captcha = document.getElementById('captcha');
        const captchaImage = document.getElementById('captchaImage');

        // Username validation
        username.addEventListener('input', function() {
            const value = this.value;
            const validation = document.getElementById('username-validation');
            
            if (value.length < 4) {
                showValidation(this, validation, 'Username must be at least 4 characters', 'error');
            } else if (value.length > 16) {
                showValidation(this, validation, 'Username must be no more than 16 characters', 'error');
            } else if (!/^[a-zA-Z0-9_</script>
@endsection
