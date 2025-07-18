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

    /* 2FA Container */
    .auth-two-fa-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-two-fa-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }

    .auth-two-fa-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .auth-two-fa-content {
        display: grid;
        gap: 30px;
    }

    .auth-two-fa-message-section {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 25px;
    }

    .auth-two-fa-message-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .auth-two-fa-encrypted-message {
        background-color: #2d3748;
        color: #e2e8f0;
        padding: 20px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        line-height: 1.4;
        white-space: pre-wrap;
        word-break: break-all;
        margin-bottom: 15px;
        border: 2px solid #4a5568;
        position: relative;
        max-height: 200px;
        overflow-y: auto;
    }

    .copy-message-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
    }

    .copy-message-btn:hover {
        background-color: #0056b3;
    }

    .auth-two-fa-instruction {
        color: #666;
        line-height: 1.6;
        background-color: #e8f5e8;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        border-radius: 6px;
    }

    .auth-two-fa-form-group {
        margin-bottom: 20px;
    }

    .auth-two-fa-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-two-fa-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: 'Courier New', monospace;
        resize: vertical;
        min-height: 80px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .auth-two-fa-textarea:focus {
        outline: none;
        border-color: #333;
        box-shadow: 0 0 0 2px rgba(51, 51, 51, 0.1);
    }

    .auth-two-fa-submit-btn {
        width: 100%;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .auth-two-fa-submit-btn:hover {
        background-color: #218838;
    }

    .auth-two-fa-submit-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .auth-two-fa-links {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .auth-two-fa-links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-two-fa-links a:hover {
        color: #007bff;
    }

    .pgp-help {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .pgp-help h4 {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pgp-help ul {
        margin-left: 20px;
        line-height: 1.6;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
            gap: 15px;
        }

        .auth-two-fa-inner {
            padding: 30px 20px;
        }

        .auth-two-fa-title {
            font-size: 20px;
        }

        .auth-two-fa-encrypted-message {
            font-size: 11px;
        }
    }

    @media (max-width: 480px) {
        .auth-two-fa-container {
            padding: 0 10px;
        }

        .auth-two-fa-inner {
            padding: 20px 15px;
        }

        .auth-two-fa-encrypted-message {
            font-size: 10px;
            padding: 15px;
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

<!-- 2FA Challenge -->
<div class="auth-two-fa-container">
    <div class="auth-two-fa-inner">
        <h1 class="auth-two-fa-title">🔐 2-Step PGP Verification</h1>
        
        <div class="pgp-help">
            <h4>🔑 How to decrypt:</h4>
            <ul>
                <li>Copy the encrypted message below</li>
                <li>Use your PGP private key to decrypt it</li>
                <li>Enter the decrypted message in the text area</li>
                <li>Click "Complete Verification" to proceed</li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <div class="auth-two-fa-content">
            <div class="auth-two-fa-message-section">
                <h5 class="auth-two-fa-message-title">🔒 Encrypted Message</h5>
                <pre class="auth-two-fa-encrypted-message" id="encryptedMessage">{{ $encryptedMessage }}<button class="copy-message-btn" onclick="copyEncryptedMessage()">📋 Copy</button></pre>
                <p class="auth-two-fa-instruction">
                    🔓 Please decrypt this message using your private PGP key and enter the decrypted message below to complete the verification process.
                </p>
            </div>
            
            <form method="POST" action="{{ route('pgp.2fa.verify') }}" class="auth-two-fa-form">
                @csrf
                <div class="auth-two-fa-form-group">
                    <label for="decrypted_message" class="auth-two-fa-label">📝 Decrypted Message</label>
                    <textarea name="decrypted_message" id="decrypted_message" rows="3" required autocomplete="off" 
                              class="auth-two-fa-textarea" placeholder="Paste your decrypted message here..."></textarea>
                </div>
                <div class="auth-two-fa-submit-group">
                    <button type="submit" class="auth-two-fa-submit-btn" id="submitBtn">
                        ✅ Complete 2-Step PGP Verification
                    </button>
                </div>
                <div class="auth-two-fa-links">
                    <a href="{{ route('login') }}">← Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function copyEncryptedMessage() {
        const messageText = document.getElementById('encryptedMessage').textContent.replace('📋 Copy', '').trim();
        navigator.clipboard.writeText(messageText).then(() => {
            const btn = document.querySelector('.copy-message-btn');
            const originalText = btn.textContent;
            btn.textContent = '✅ Copied!';
            btn.style.backgroundColor = '#28a745';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.backgroundColor = '#007bff';
            }, 2000);
        });
    }

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.auth-two-fa-form');
        const textarea = document.getElementById('decrypted_message');
        const submitBtn = document.getElementById('submitBtn');

        // Real-time validation
        textarea.addEventListener('input', function() {
            const value = this.value.trim();
            if (value.length > 0) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
            }
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            const value = textarea.value.trim();
            if (value.length === 0) {
                e.preventDefault();
                textarea.focus();
                return;
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = '🔄 Verifying...';
        });

        // Auto-resize textarea
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.max(80, this.scrollHeight) + 'px';
        });

        // Focus textarea on load
        textarea.focus();

        // Initialize button state
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
    });
</script>

@endsection
