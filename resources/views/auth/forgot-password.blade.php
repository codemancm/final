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

    /* Forgot Password Container */
    .auth-forgot-password-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-forgot-password-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }

    .auth-forgot-password-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .forgot-password-description {
        text-align: center;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #007bff;
    }

    .auth-forgot-password-form-group {
        margin-bottom: 20px;
    }

    .auth-forgot-password-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-forgot-password-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
        resize: vertical;
    }

    .auth-forgot-password-input:focus {
        outline: none;
        border-color: #333;
        box-shadow: 0 0 0 2px rgba(51, 51, 51, 0.1);
    }

    .auth-forgot-password-input[name="mnemonic"] {
        min-height: 120px;
        font-family: 'Courier New', monospace;
        line-height: 1.5;
    }

    .auth-forgot-password-submit-btn {
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

    .auth-forgot-password-submit-btn:hover {
        background-color: #555;
    }

    .auth-forgot-password-submit-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .auth-forgot-password-links {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .auth-forgot-password-links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-forgot-password-links a:hover {
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

    .alert-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
    }

    .alert-info {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
    }

    /* Form validation styles */
    .auth-forgot-password-input.error {
        border-color: #e74c3c;
        background-color: #fdf2f2;
    }

    .auth-forgot-password-input.success {
        border-color: #28a745;
        background-color: #f2f8f2;
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

    /* Mnemonic helper */
    .mnemonic-helper {
        margin-top: 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e9ecef;
    }

    .mnemonic-helper-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        font-size: 12px;
    }

    .mnemonic-helper-text {
        font-size: 11px;
        color: #666;
        line-height: 1.4;
    }

    .word-counter {
        font-size: 11px;
        color: #666;
        text-align: right;
        margin-top: 5px;
    }

    .word-counter.error {
        color: #e74c3c;
    }

    .word-counter.success {
        color: #28a745;
    }

    /* Security notice */
    .security-notice {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .security-notice-title {
        font-weight: bold;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Loading state */
    .loading {
        position: relative;
        overflow: hidden;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { left: -100%; }
        100% { left: 100%; }
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

        .auth-forgot-password-inner {
            padding: 30px 20px;
        }

        .auth-forgot-password-title {
            font-size: 20px;
        }

        .logo-text {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .auth-forgot-password-container {
            padding: 0 10px;
        }

        .auth-forgot-password-inner {
            padding: 20px 15px;
        }

        .auth-forgot-password-input {
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

<!-- Forgot Password Form -->
<div class="auth-forgot-password-container">
    <div class="auth-forgot-password-inner">
        <h2 class="auth-forgot-password-title">🔐 Forgot Password</h2>
        
        <div class="forgot-password-description">
            <strong>Password Recovery Process</strong><br>
            To recover your account, please provide your username and the 12-word mnemonic phrase that was given to you during registration. This phrase is your master key to account recovery.
        </div>

        <div class="security-notice">
            <div class="security-notice-title">
                🛡️ Security Notice
            </div>
            <div>
                • Never share your mnemonic phrase with anyone<br>
                • Ensure you're on the correct website before entering sensitive information<br>
                • This process will allow you to reset your password securely
            </div>
        </div>
        
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

        <form method="POST" action="{{ route('password.verify') }}" id="forgotPasswordForm">
            @csrf
            
            <div class="auth-forgot-password-form-group">
                <label for="username" class="auth-forgot-password-label">👤 Username</label>
                <input type="text" name="username" id="username" class="auth-forgot-password-input" 
                       value="{{ old('username') }}" minlength="4" maxlength="16" required autofocus
                       placeholder="Enter your username">
                <div id="username-validation" class="validation-message" style="display: none;"></div>
            </div>
            
            <div class="auth-forgot-password-form-group">
                <label for="mnemonic" class="auth-forgot-password-label">🔑 12-Word Mnemonic Phrase</label>
                <textarea name="mnemonic" id="mnemonic" class="auth-forgot-password-input" 
                          minlength="40" maxlength="512" required 
                          placeholder="Enter your 12-word mnemonic phrase separated by spaces (e.g., word1 word2 word3...)">{{ old('mnemonic') }}</textarea>
                <div class="word-counter" id="wordCounter">Words: 0/12</div>
                <div id="mnemonic-validation" class="validation-message" style="display: none;"></div>
                
                <div class="mnemonic-helper">
                    <div class="mnemonic-helper-title">💡 Mnemonic Phrase Help:</div>
                    <div class="mnemonic-helper-text">
                        • Your mnemonic phrase consists of exactly 12 words<br>
                        • Words should be separated by single spaces<br>
                        • Each word should be from the standard BIP39 wordlist<br>
                        • This phrase was provided during your initial registration
                    </div>
                </div>
            </div>
            
            <button type="submit" class="auth-forgot-password-submit-btn" id="submitBtn">
                🔍 Verify Mnemonic Phrase
            </button>
        </form>
        
        <div class="auth-forgot-password-links">
            <a href="{{ route('login') }}">← Back to Login</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('forgotPasswordForm');
        const username = document.getElementById('username');
        const mnemonic = document.getElementById('mnemonic');
        const submitBtn = document.getElementById('submitBtn');
        const wordCounter = document.getElementById('wordCounter');

        // Username validation
        username.addEventListener('input', function() {
            const value = this.value.trim();
            const validation = document.getElementById('username-validation');
            
            if (value.length === 0) {
                showValidation(this, validation, 'Username is required', 'error');
            } else if (value.length < 4) {
                showValidation(this, validation, 'Username must be at least 4 characters', 'error');
            } else if (value.length > 16) {
                showValidation(this, validation, 'Username must be no more than 16 characters', 'error');
            } else if (!/^[a-zA-Z0-9_-]+$/.test(value)) {
                showValidation(this, validation, 'Username can only contain letters, numbers, underscores, and hyphens', 'error');
            } else {
                showValidation(this, validation, 'Username format is valid', 'success');
            }
            
            updateSubmitButton();
        });

        // Mnemonic validation with word counting
        mnemonic.addEventListener('input', function() {
            const value = this.value.trim();
            const validation = document.getElementById('mnemonic-validation');
            const words = value.split(/\s+/).filter(word => word.length > 0);
            
            // Update word counter
            wordCounter.textContent = `Words: ${words.length}/12`;
            wordCounter.classList.remove('error', 'success');
            
            if (words.length === 0) {
                showValidation(this, validation, 'Mnemonic phrase is required', 'error');
                wordCounter.classList.add('error');
            } else if (words.length < 12) {
                showValidation(this, validation, `Need ${12 - words.length} more words`, 'error');
                wordCounter.classList.add('error');
            } else if (words.length > 12) {
                showValidation(this, validation, `Too many words. Remove ${words.length - 12} words`, 'error');
                wordCounter.classList.add('error');
            } else {
                // Validate word format (basic check)
                const invalidWords = words.filter(word => !/^[a-z]+$/.test(word.toLowerCase()));
                if (invalidWords.length > 0) {
                    showValidation(this, validation, `Invalid words detected: ${invalidWords.join(', ')}`, 'error');
                    wordCounter.classList.add('error');
                } else {
                    showValidation(this, validation, 'Mnemonic phrase format looks correct', 'success');
                    wordCounter.classList.add('success');
                }
            }
            
            updateSubmitButton();
        });

        // Auto-format mnemonic input
        mnemonic.addEventListener('blur', function() {
            const value = this.value.trim();
            const words = value.split(/\s+/).filter(word => word.length > 0);
            this.value = words.join(' ').toLowerCase();
        });

        // Prevent paste of non-text content
        mnemonic.addEventListener('paste', function(e) {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const cleanPaste = paste.replace(/[^a-zA-Z\s]/g, '').replace(/\s+/g, ' ').trim();
            
            // Insert cleaned text
            const start = this.selectionStart;
            const end = this.selectionEnd;
            const currentValue = this.value;
            this.value = currentValue.substring(0, start) + cleanPaste + currentValue.substring(end);
            
            // Trigger input event
            this.dispatchEvent(new Event('input'));
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate username
            const usernameValue = username.value.trim();
            if (usernameValue.length < 4 || usernameValue.length > 16) {
                isValid = false;
                showValidation(username, document.getElementById('username-validation'), 
                    'Username must be between 4 and 16 characters', 'error');
            }
            
            // Validate mnemonic
            const mnemonicValue = mnemonic.value.trim();
            const words = mnemonicValue.split(/\s+/).filter(word => word.length > 0);
            
            if (words.length !== 12) {
                isValid = false;
                showValidation(mnemonic, document.getElementById('mnemonic-validation'), 
                    'Mnemonic phrase must contain exactly 12 words', 'error');
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.auth-forgot-password-input.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.textContent = '🔄 Verifying...';
        });

        // Update submit button state
        function updateSubmitButton() {
            const usernameValid = username.value.trim().length >= 4 && username.value.trim().length <= 16;
            const mnemonicWords = mnemonic.value.trim().split(/\s+/).filter(word => word.length > 0);
            const mnemonicValid = mnemonicWords.length === 12;
            
            if (usernameValid && mnemonicValid) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.6';
            }
        }

        // Helper functions
        function showValidation(input, validationElement, message, type) {
            input.classList.remove('error', 'success');
            input.classList.add(type);
            
            validationElement.classList.remove('validation-error', 'validation-success');
            validationElement.classList.add('validation-' + type);
            validationElement.textContent = message;
            validationElement.style.display = 'block';
        }

        function hideValidation(input, validationElement) {
            input.classList.remove('error', 'success');
            validationElement.style.display = 'none';
        }

        // Input focus effects
        document.querySelectorAll('.auth-forgot-password-input').forEach(input => {
            input.addEventListener('focus', function() {
                if (!this.classList.contains('error')) {
                    this.style.borderColor = '#333';
                }
            });
            
            input.addEventListener('blur', function() {
                if (!this.classList.contains('error') && !this.classList.contains('success')) {
                    this.style.borderColor = '#ddd';
                }
            });
        });

        // Security features
        let attemptCount = 0;
        const maxAttempts = 5;
        
        form.addEventListener('submit', function() {
            attemptCount++;
            if (attemptCount >= maxAttempts) {
                setTimeout(() => {
                    submitBtn.disabled = true;
                    submitBtn.textContent = '🚫 Too many attempts. Please wait...';
                    setTimeout(() => {
                        attemptCount = 0;
                        submitBtn.disabled = false;
                        submitBtn.textContent = '🔍 Verify Mnemonic Phrase';
                    }, 60000); // 1 minute cooldown
                }, 100);
            }
        });

        // Disable right-click on sensitive inputs
        [username, mnemonic].forEach(input => {
            input.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
        });

        // Clear form data on page unload for security
        window.addEventListener('beforeunload', function() {
            username.value = '';
            mnemonic.value = '';
        });

        // Auto-resize textarea
        mnemonic.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.max(120, this.scrollHeight) + 'px';
        });

        // Initialize
        updateSubmitButton();
        
        // Focus management
        username.focus();
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+Enter to submit form
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                if (!submitBtn.disabled) {
                    form.submit();
                }
            }
            
            // Tab navigation enhancement
            if (e.key === 'Tab') {
                const focusableElements = form.querySelectorAll('input, textarea, button');
                const currentIndex = Array.from(focusableElements).indexOf(document.activeElement);
                
                if (e.shiftKey && currentIndex === 0) {
                    e.preventDefault();
                    focusableElements[focusableElements.length - 1].focus();
                } else if (!e.shiftKey && currentIndex === focusableElements.length - 1) {
                    e.preventDefault();
                    focusableElements[0].focus();
                }
            }
        });

        // Mnemonic word suggestions (basic implementation)
        const commonBIP39Words = [
            'abandon', 'ability', 'able', 'about', 'above', 'absent', 'absorb', 'abstract',
            'absurd', 'abuse', 'access', 'accident', 'account', 'accuse', 'achieve', 'acid',
            'acoustic', 'acquire', 'across', 'act', 'action', 'actor', 'actress', 'actual'
            // Add more BIP39 words as needed
        ];

        // Simple word validation against common words
        function validateMnemonicWords(words) {
            return words.every(word => {
                return word.length >= 3 && word.length <= 8 && /^[a-z]+$/.test(word);
            });
        }

        // Enhanced mnemonic validation
        mnemonic.addEventListener('input', function() {
            const value = this.value.trim();
            const words = value.split(/\s+/).filter(word => word.length > 0);
            
            if (words.length === 12) {
                const isValidFormat = validateMnemonicWords(words);
                if (!isValidFormat) {
                    showValidation(this, document.getElementById('mnemonic-validation'), 
                        'Some words may not be valid BIP39 words', 'error');
                }
            }
        });
    });

    // Additional security: Clear sensitive data from memory
    window.addEventListener('unload', function() {
        // Clear any sensitive variables
        if (typeof mnemonic !== 'undefined') {
            mnemonic.value = '';
        }
        if (typeof username !== 'undefined') {
            username.value = '';
        }
    });
</script>

@endsection
