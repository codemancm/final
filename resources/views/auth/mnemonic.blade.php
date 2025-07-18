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

    /* Mnemonic Container */
    .auth-mnemonic-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-mnemonic-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
        text-align: center;
    }

    .auth-mnemonic-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .auth-mnemonic-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 20px;
        border-radius: 6px;
        margin-bottom: 30px;
        text-align: left;
    }

    .auth-mnemonic-warning strong {
        display: block;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .auth-mnemonic-warning-text {
        line-height: 1.6;
    }

    .auth-mnemonic-display {
        background-color: #f8f9fa;
        border: 2px solid #28a745;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
    }

    .auth-mnemonic-words {
        font-family: 'Courier New', monospace;
        font-size: 18px;
        font-weight: bold;
        color: #333;
        line-height: 1.8;
        word-spacing: 10px;
        margin: 0;
        user-select: all;
    }

    .copy-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    .copy-btn:hover {
        background-color: #0056b3;
    }

    .auth-mnemonic-submit-btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .auth-mnemonic-submit-btn:hover {
        background-color: #218838;
    }

    .security-tips {
        background-color: #e8f5e8;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: left;
    }

    .security-tips h4 {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .security-tips ul {
        margin-left: 20px;
        line-height: 1.6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
            gap: 15px;
        }

        .auth-mnemonic-inner {
            padding: 30px 20px;
        }

        .auth-mnemonic-title {
            font-size: 20px;
        }

        .auth-mnemonic-words {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .auth-mnemonic-container {
            padding: 0 10px;
        }

        .auth-mnemonic-inner {
            padding: 20px 15px;
        }

        .auth-mnemonic-words {
            font-size: 14px;
            word-spacing: 5px;
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

<!-- Mnemonic Display -->
<div class="auth-mnemonic-container">
    <div class="auth-mnemonic-inner">
        <h2 class="auth-mnemonic-title">🔑 Your Mnemonic Phrase</h2>
        
        <div class="auth-mnemonic-warning">
            <strong>⚠️ Critical Security Warning:</strong>
            <div class="auth-mnemonic-warning-text">
                This is the ONLY time you will see this mnemonic phrase. Write it down and store it securely offline. You will need this to recover your account if you forget your password. Anyone with this phrase can access your account.
            </div>
        </div>

        <div class="security-tips">
            <h4>🛡️ Security Tips:</h4>
            <ul>
                <li>Write this phrase on paper and store it in a safe place</li>
                <li>Never share this phrase with anyone</li>
                <li>Don't store it digitally (screenshots, files, etc.)</li>
                <li>Consider making multiple physical copies</li>
                <li>Verify you've written it correctly before continuing</li>
            </ul>
        </div>
        
        <div class="auth-mnemonic-display">
            <button class="copy-btn" onclick="copyMnemonic()">📋 Copy</button>
            <p class="auth-mnemonic-words" id="mnemonicWords">{{ $mnemonic }}</p>
        </div>
        
        <form method="GET" action="{{ route('login') }}" class="auth-mnemonic-form">
            <button type="submit" class="auth-mnemonic-submit-btn" id="continueBtn">
                ✅ I've Saved My Mnemonic - Continue to Login
            </button>
        </form>
    </div>
</div>

<script>
    function copyMnemonic() {
        const mnemonicText = document.getElementById('mnemonicWords').textContent;
        navigator.clipboard.writeText(mnemonicText).then(() => {
            const btn = document.querySelector('.copy-btn');
            const originalText = btn.textContent;
            btn.textContent = '✅ Copied!';
            btn.style.backgroundColor = '#28a745';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.backgroundColor = '#007bff';
            }, 2000);
        });
    }

    // Prevent accidental navigation
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = 'Are you sure you want to leave? Make sure you have saved your mnemonic phrase!';
    });

    // Remove warning after form submission
    document.querySelector('.auth-mnemonic-form').addEventListener('submit', function() {
        window.removeEventListener('beforeunload', arguments.callee);
    });

    // Auto-select text when clicked
    document.getElementById('mnemonicWords').addEventListener('click', function() {
        window.getSelection().selectAllChildren(this);
    });
</script>

@endsection
