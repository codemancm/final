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
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        padding: 0 20px;
        justify-content: center;
        gap: 20px;
    }

    .nav-link {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    .nav-link:hover {
        background-color: rgba(0,0,0,0.1);
    }

    /* Banned Container */
    .auth-banned-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-banned-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
        text-align: center;
        border-left: 5px solid #e74c3c;
    }

    .auth-banned-title {
        font-size: 24px;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .auth-banned-message {
        color: #666;
        margin-bottom: 30px;
        font-size: 16px;
        line-height: 1.6;
    }

    .auth-banned-details {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: left;
    }

    .auth-banned-details p {
        margin-bottom: 10px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .auth-banned-details p:last-child {
        margin-bottom: 0;
    }

    .auth-banned-details strong {
        color: #333;
        min-width: 80px;
    }

    .auth-banned-contact {
        background-color: #e8f5e8;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.6;
    }

    .auth-banned-links a {
        display: inline-block;
        background-color: #333;
        color: white;
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 4px;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .auth-banned-links a:hover {
        background-color: #555;
    }

    .countdown {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
            gap: 15px;
        }

        .auth-banned-inner {
            padding: 30px 20px;
        }

        .auth-banned-title {
            font-size: 20px;
        }
    }

    @media (max-width: 480px) {
        .auth-banned-container {
            padding: 0 10px;
        }

        .auth-banned-inner {
            padding: 20px 15px;
        }

        .auth-banned-details p {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
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

<!-- Banned Notice -->
<div class="auth-banned-container">
    <div class="auth-banned-inner">
        <h2 class="auth-banned-title">
            🚫 Account Suspended
        </h2>
        
        <p class="auth-banned-message">
            Your account has been temporarily suspended for violating our marketplace rules and terms of service.
        </p>
        
        <div class="auth-banned-details">
            <p>
                <strong>📋 Reason:</strong> 
                <span>{{ $bannedUser->bannedUser->reason }}</span>
            </p>
            <p>
                <strong>⏰ Until:</strong> 
                <span id="banEndTime">{{ $bannedUser->bannedUser->banned_until->format('Y-m-d / H:i:s') }}</span>
            </p>
        </div>

        <div class="countdown" id="countdown">
            <div>⏳ Time remaining: <span id="timeRemaining">Calculating...</span></div>
        </div>
        
        <p class="auth-banned-contact">
            💬 If you believe this suspension was issued in error, you may contact our support team by creating a new account and submitting a dispute through the proper channels.
        </p>
        
        <div class="auth-banned-links">
            <a href="{{ route('login') }}">← Return to Login</a>
        </div>
    </div>
</div>

<script>
    // Countdown timer
    function updateCountdown() {
        const banEndTime = new Date('{{ $bannedUser->bannedUser->banned_until->toISOString() }}');
        const now = new Date();
        const timeLeft = banEndTime - now;

        if (timeLeft <= 0) {
            document.getElementById('countdown').innerHTML = '<div>✅ Your suspension has expired. You may now try to log in again.</div>';
            document.getElementById('countdown').style.backgroundColor = '#d4edda';
            document.getElementById('countdown').style.borderColor = '#c3e6cb';
            document.getElementById('countdown').style.color = '#155724';
            return;
        }

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        let timeString = '';
        if (days > 0) timeString += `${days}d `;
        if (hours > 0) timeString += `${hours}h `;
        if (minutes > 0) timeString += `${minutes}m `;
        timeString += `${seconds}s`;

        document.getElementById('timeRemaining').textContent = timeString;
    }

    // Update countdown every second
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Auto-refresh page when ban expires
    setTimeout(() => {
        const banEndTime = new Date('{{ $bannedUser->bannedUser->banned_until->toISOString() }}');
        const now = new Date();
        const timeLeft = banEndTime - now;
        
        if (timeLeft > 0) {
            setTimeout(() => {
                location.reload();
            }, timeLeft);
        }
    }, 1000);
</script>

@endsection
