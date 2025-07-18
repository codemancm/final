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

    /* Reset Password Container */
    .auth-reset-password-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .auth-reset-password-inner {
        background-color: #fff;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #ddd;
    }

    .auth-reset-password-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .reset-password-description {
        text-align: center;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 6px;
        border-left: 4px solid #28a745;
    }

    .auth-reset-password-form-group {
        margin-bottom: 20px;
    }

    .auth-reset-password-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
        font-size: 14px;
    }

    .auth-reset-password-input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .auth-reset-password-input:focus {
        outline: none;
        border-color: #333;
        box-shadow: 0 0 0 2px rgba(51, 51, 51, 0.1);
    }

    .auth-reset-password-submit-btn {
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
        margin-top: 10px;
    }

    .auth-reset-password-submit-btn:hover {
        background-color: #218838;
    }

    .auth-reset-password-submit-btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .auth-reset-password-links {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .auth-reset-password-links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-reset-password-links a:hover {
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
    .auth-reset-password-input.error {
        border-color: #e74c3c;
        background-color: #fdf2f2;
    }

    .auth-reset-password-input.success {
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

    .password-strength-text {
        font-size: 11px;
        margin-top: 3px;
        color: #666;
    }

    /* Password requirements */
    .password-requirements {
        margin-top: 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e9ecef;
    }

    .password-requirements-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        font-size: 12px;
    }

    .requirement {
        font-size: 11px;
        color: #666;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .requirement.met {
        color: #28a745;
    }

    .requirement.not-met {
        color: #e74c3c;
    }

    /* Password visibility toggle */
    .password-input-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: #666;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-toggle:hover {
        color: #333;
    }

    /* Security notice */
    .security-notice {
        background-color: #e8f5e8;
        border: 1px solid #c3e6cb;
        color: #155724;
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

    /* Match indicator */
    .password-match {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 5px;
        font-size: 12px;
    }

    .password-match.match {
        color: #28a745;
    }

    .password-match.no-match {
        color: #e74c3c;
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

        .auth-reset-password-inner {
            padding: 30px 20px;
        }

        .auth-reset-password-title {
            font-size: 20px;
        }

        .logo-text {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .auth-reset-password-container {
            padding: 0 10px;
        }

        .auth-reset-password-inner {
            padding: 20px 15px;
        }

        .auth-reset-password-input {
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

<!-- Reset Password Form -->
<div class="auth-reset-password-container">
    <div class="auth-reset-password-inner">
        <h2 class="auth-reset-password-title">🔐 Reset Password</h2>
        
        <div class="reset-password-description">
            <strong>Create New Password</strong><br>
            Your identity has been verified. Please create a new secure password for your account. Make sure it's strong and unique.
        </div>

        <div class="security-notice">
            <div class="security-notice-title">
                ✅ Security Tips
            </div>
            <div>
                • Use a combination of uppercase, lowercase, numbers, and symbols<br>
                • Avoid using personal information or common words<br>
                • Consider using a password manager for better security<br>
                • Never share your password with anyone
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

        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="auth-reset-password-form-group">
                <label for="password" class="auth-reset-password-label">🔑 New Password</label>
                <div class="password-input-wrapper">
                    <input type="password" name="password" id="password" class="auth-reset-password-input" 
                           minlength="8" maxlength="40" required
                           placeholder="Enter your new password">
                    <button type="button" class="password-toggle" id="passwordToggle">👁️</button>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
                <div class="password-strength-text" id="passwordStrengthText">Password strength will appear here</div>
                <div id="password-validation" class="validation-message" style="display: none;"></div>
                
                <div class="password-requirements">
                    <div class="password-requirements-title">Password Requirements:</div>
                    <div class="requirement" id="req-length">
                        <span class="req-icon">❌</span>
                        <span>At least 8 characters long</span>
                    </div>
                    <div class="requirement" id="req-uppercase">
                        <span class="req-icon">❌</span>
                        <span>Contains uppercase letter (A-Z)</span>
                    </div>
                    <div class="requirement" id="req-lowercase">
                        <span class="req-icon">❌</span>
                        <span>Contains lowercase letter (a-z)</span>
                    </div>
                    <div class="requirement" id="req-number">
                        <span class="req-icon">❌</span>
                        <span>Contains number (0-9)</span>
                    </div>
                    <div class="requirement" id="req-special">
                        <span class="req-icon">❌</span>
                        <span>Contains special character (!@#$%^&*)</span>
                    </div>
                </div>
            </div>
            
            <div class="auth-reset-password-form-group">
                <label for="password_confirmation" class="auth-reset-password-label">🔑 Confirm New Password</label>
                <div class="password-input-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="auth-reset-password-input" 
                           minlength="8" maxlength="40" required
                           placeholder="Re-enter your new password">
                    <button type="button" class="password-toggle" id="passwordToggle">👁️</button>
                </div>
                <div class="password-match" id="passwordMatch" style="display: none;">
                    <span class="match-icon"></span>
                    <span class="match-text"></span>
                </div>
                <div id="password-confirm-validation" class="validation-message" style="display: none;"></div>
            </div>
            
            <button type="submit" class="auth-reset-password-submit-btn" id="submitBtn">
                Reset Password
            </button>
        </form>
        <div class="auth-reset-password-links">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('resetPasswordForm');
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        const submitBtn = document.getElementById('submitBtn');
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordConfirmToggle = document.getElementById('passwordConfirmToggle');
        const passwordStrengthBar = document.getElementById('passwordStrengthBar');
        const passwordStrengthText = document.getElementById('passwordStrengthText');
        const passwordMatch = document.getElementById('passwordMatch');

        // Password requirements elements
        const requirements = {
            length: document.getElementById('req-length'),
            uppercase: document.getElementById('req-uppercase'),
            lowercase: document.getElementById('req-lowercase'),
            number: document.getElementById('req-number'),
            special: document.getElementById('req-special')
        };

        // Password visibility toggles
        passwordToggle.addEventListener('click', function() {
            togglePasswordVisibility(password, this);
        });

        passwordConfirmToggle.addEventListener('click', function() {
            togglePasswordVisibility(passwordConfirm, this);
        });

        function togglePasswordVisibility(input, button) {
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🙈';
            } else {
                input.type = 'password';
                button.textContent = '👁️';
            }
        }

        // Password validation and strength checking
        password.addEventListener('input', function() {
            const value = this.value;
            const validation = document.getElementById('password-validation');
            
            // Check requirements
            const checks = {
                length: value.length >= 8,
                uppercase: /[A-Z]/.test(value),
                lowercase: /[a-z]/.test(value),
                number: /[0-9]/.test(value),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value)
            };

            // Update requirement indicators
            Object.keys(checks).forEach(req => {
                const element = requirements[req];
                const icon = element.querySelector('.req-icon');
                
                if (checks[req]) {
                    element.classList.add('met');
                    element.classList.remove('not-met');
                    icon.textContent = '✅';
                } else {
                    element.classList.add('not-met');
                    element.classList.remove('met');
                    icon.textContent = '❌';
                }
            });

            // Calculate password strength
            let strength = 0;
            let strengthText = '';
            
            if (value.length === 0) {
                strengthText = 'Password strength will appear here';
                passwordStrengthBar.className = 'password-strength-bar';
            } else {
                Object.values(checks).forEach(check => {
                    if (check) strength++;
                });

                // Additional strength factors
                if (value.length >= 12) strength += 0.5;
                if (value.length >= 16) strength += 0.5;
                if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{2,}/.test(value)) strength += 0.5;

                if (strength < 2) {
                    strengthText = 'Very Weak - Add more character types';
                    passwordStrengthBar.className = 'password-strength-bar weak';
                    showValidation(this, validation, 'Password is too weak', 'error');
                } else if (strength < 3) {
                    strengthText = 'Weak - Consider adding more complexity';
                    passwordStrengthBar.className = 'password-strength-bar weak';
                    showValidation(this, validation, 'Password could be stronger', 'error');
                } else if (strength < 4) {
                    strengthText = 'Medium - Good but could be better';
                    passwordStrengthBar.className = 'password-strength-bar medium';
                    showValidation(this, validation, 'Password strength is acceptable', 'success');
                } else if (strength < 5) {
                    strengthText = 'Strong - Great password!';
                    passwordStrengthBar.className = 'password-strength-bar strong';
                    showValidation(this, validation, 'Strong password!', 'success');
                } else {
                    strengthText = 'Very Strong - Excellent security!';
                    passwordStrengthBar.className = 'password-strength-bar strong';
                    showValidation(this, validation, 'Very strong password!', 'success');
                }
            }

            passwordStrengthText.textContent = strengthText;

            // Validate length constraints
            if (value.length > 40) {
                showValidation(this, validation, 'Password must be no more than 40 characters', 'error');
            }

            // Re-validate password confirmation if it has a value
            if (passwordConfirm.value) {
                passwordConfirm.dispatchEvent(new Event('input'));
            }

            updateSubmitButton();
        });

        // Password confirmation validation
        passwordConfirm.addEventListener('input', function() {
            const value = this.value;
            const validation = document.getElementById('password-confirm-validation');
            const matchElement = passwordMatch;
            const matchIcon = matchElement.querySelector('.match-icon');
            const matchText = matchElement.querySelector('.match-text');
            
            if (value.length === 0) {
                matchElement.style.display = 'none';
                hideValidation(this, validation);
            } else if (value !== password.value) {
                matchElement.style.display = 'flex';
                matchElement.className = 'password-match no-match';
                matchIcon.textContent = '❌';
                matchText.textContent = 'Passwords do not match';
                showValidation(this, validation, 'Passwords do not match', 'error');
            } else {
                matchElement.style.display = 'flex';
                matchElement.className = 'password-match match';
                matchIcon.textContent = '✅';
                matchText.textContent = 'Passwords match!';
                showValidation(this, validation, 'Passwords match!', 'success');
            }

            updateSubmitButton();
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate password
            const passwordValue = password.value;
            if (passwordValue.length < 8 || passwordValue.length > 40) {
                isValid = false;
                showValidation(password, document.getElementById('password-validation'), 
                    'Password must be between 8 and 40 characters', 'error');
            }

            // Check password requirements
            const checks = {
                length: passwordValue.length >= 8,
                uppercase: /[A-Z]/.test(passwordValue),
                lowercase: /[a-z]/.test(passwordValue),
                number: /[0-9]/.test(passwordValue),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(passwordValue)
            };

            const metRequirements = Object.values(checks).filter(Boolean).length;
            if (metRequirements < 3) {
                isValid = false;
                showValidation(password, document.getElementById('password-validation'), 
                    'Password must meet at least 3 requirements', 'error');
            }
            
            // Validate password confirmation
            if (password.value !== passwordConfirm.value) {
                isValid = false;
                showValidation(passwordConfirm, document.getElementById('password-confirm-validation'), 
                    'Passwords do not match', 'error');
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.auth-reset-password-input.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.textContent = '🔄 Resetting Password...';
        });

        // Update submit button state
        function updateSubmitButton() {
            const passwordValue = password.value;
            const passwordConfirmValue = passwordConfirm.value;
            
            const passwordValid = passwordValue.length >= 8 && passwordValue.length <= 40;
            const passwordsMatch = passwordValue === passwordConfirmValue && passwordConfirmValue.length > 0;
            
            // Check minimum requirements
            const checks = {
                length: passwordValue.length >= 8,
                uppercase: /[A-Z]/.test(passwordValue),
                lowercase: /[a-z]/.test(passwordValue),
                number: /[0-9]/.test(passwordValue),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(passwordValue)
            };
            
            const metRequirements = Object.values(checks).filter(Boolean).length >= 3;
            
            if (passwordValid && passwordsMatch && metRequirements) {
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
        document.querySelectorAll('.auth-reset-password-input').forEach(input => {
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
        const maxAttempts = 3;
        
        form.addEventListener('submit', function() {
            attemptCount++;
            if (attemptCount >= maxAttempts) {
                setTimeout(() => {
                    submitBtn.disabled = true;
                    submitBtn.textContent = '🚫 Too many attempts. Please wait...';
                    setTimeout(() => {
                        attemptCount = 0;
                        submitBtn.disabled = false;
                        submitBtn.textContent = '🔄 Reset Password';
                    }, 30000); // 30 second cooldown
                }, 100);
            }
        });

        // Disable right-click on password inputs
        [password, passwordConfirm].forEach(input => {
            input.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
        });

        // Clear form data on page unload for security
        window.addEventListener('beforeunload', function() {
            password.value = '';
            passwordConfirm.value = '';
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+Enter to submit form
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                if (!submitBtn.disabled) {
                    form.submit();
                }
            }
            
            // Escape to clear current input
            if (e.key === 'Escape') {
                if (document.activeElement === password) {
                    password.value = '';
                    password.dispatchEvent(new Event('input'));
                } else if (document.activeElement === passwordConfirm) {
                    passwordConfirm.value = '';
                    passwordConfirm.dispatchEvent(new Event('input'));
                }
            }
        });

        // Password generation suggestion (optional feature)
        function generateStrongPassword() {
            const lowercase = 'abcdefghijklmnopqrstuvwxyz';
            const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
            
            let password = '';
            
            // Ensure at least one character from each category
            password += lowercase[Math.floor(Math.random() * lowercase.length)];
            password += uppercase[Math.floor(Math.random() * uppercase.length)];
            password += numbers[Math.floor(Math.random() * numbers.length)];
            password += symbols[Math.floor(Math.random() * symbols.length)];
            
            // Fill the rest randomly
            const allChars = lowercase + uppercase + numbers + symbols;
            for (let i = 4; i < 16; i++) {
                password += allChars[Math.floor(Math.random() * allChars.length)];
            }
            
            // Shuffle the password
            return password.split('').sort(() => Math.random() - 0.5).join('');
        }

        // Add password generator button (optional)
        const generateBtn = document.createElement('button');
        generateBtn.type = 'button';
        generateBtn.textContent = '🎲 Generate Strong Password';
        generateBtn.style.cssText = `
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.2s;
        `;
        
        generateBtn.addEventListener('click', function() {
            const generatedPassword = generateStrongPassword();
            password.value = generatedPassword;
            passwordConfirm.value = generatedPassword;
            
            // Trigger input events to update validation
            password.dispatchEvent(new Event('input'));
            passwordConfirm.dispatchEvent(new Event('input'));
            
            // Show temporary notification
            const notification = document.createElement('div');
            notification.textContent = '✅ Strong password generated!';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                color: white;
                padding: 10px 15px;
                border-radius: 4px;
                z-index: 1000;
                font-size: 14px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            `;
            
            document.body.appendChild(notification);
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 3000);
        });
        
        generateBtn.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#0056b3';
        });
        
        generateBtn.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '#007bff';
        });
        
        // Insert generate button after password requirements
        const passwordRequirements = document.querySelector('.password-requirements');
        passwordRequirements.parentNode.insertBefore(generateBtn, passwordRequirements.nextSibling);

        // Initialize
        updateSubmitButton();
        
        // Focus management
        password.focus();
        
        // Enhanced tab navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                const focusableElements = form.querySelectorAll('input, button:not(.password-toggle)');
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

        // Password strength animation
        function animateStrengthBar() {
            const bar = passwordStrengthBar;
            bar.style.transition = 'width 0.3s ease-in-out, background-color 0.3s ease-in-out';
        }

        // Call animation setup
        animateStrengthBar();

        // Caps Lock detection
        document.addEventListener('keydown', function(e) {
            if (e.getModifierState && e.getModifierState('CapsLock')) {
                showCapsLockWarning();
            }
        });

        document.addEventListener('keyup', function(e) {
            if (e.getModifierState && !e.getModifierState('CapsLock')) {
                hideCapsLockWarning();
            }
        });

        function showCapsLockWarning() {
            let warning = document.getElementById('capsLockWarning');
            if (!warning) {
                warning = document.createElement('div');
                warning.id = 'capsLockWarning';
                warning.textContent = '⚠️ Caps Lock is ON';
                warning.style.cssText = `
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: #f39c12;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 4px;
                    z-index: 1001;
                    font-size: 14px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                `;
                document.body.appendChild(warning);
            }
        }

        function hideCapsLockWarning() {
            const warning = document.getElementById('capsLockWarning');
            if (warning) {
                document.body.removeChild(warning);
            }
        }

        // Form auto-save prevention (security)
        password.setAttribute('autocomplete', 'new-password');
        passwordConfirm.setAttribute('autocomplete', 'new-password');

        // Prevent form submission on Enter in password fields (force button click)
        [password, passwordConfirm].forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (!submitBtn.disabled) {
                        submitBtn.click();
                    }
                }
            });
        });

        // Session timeout warning
        let sessionTimeout;
        const SESSION_TIMEOUT = 10 * 60 * 1000; // 10 minutes

        function resetSessionTimeout() {
            clearTimeout(sessionTimeout);
            sessionTimeout = setTimeout(() => {
                alert('⚠️ Session timeout warning: Please complete the password reset soon or you may need to start over.');
            }, SESSION_TIMEOUT);
        }

        // Reset timeout on user activity
        ['input', 'click', 'keydown'].forEach(event => {
            document.addEventListener(event, resetSessionTimeout);
        });

        resetSessionTimeout();

        // Accessibility improvements
        password.setAttribute('aria-describedby', 'password-validation password-requirements');
        passwordConfirm.setAttribute('aria-describedby', 'password-confirm-validation passwordMatch');

        // Add ARIA live regions for screen readers
        const liveRegion = document.createElement('div');
        liveRegion.setAttribute('aria-live', 'polite');
        liveRegion.setAttribute('aria-atomic', 'true');
        liveRegion.style.cssText = `
            position: absolute;
            left: -10000px;
            width: 1px;
            height: 1px;
            overflow: hidden;
        `;
        document.body.appendChild(liveRegion);

        // Update live region when password strength changes
        password.addEventListener('input', function() {
            setTimeout(() => {
                liveRegion.textContent = passwordStrengthText.textContent;
            }, 500);
        });
    });

    // Additional security: Clear sensitive data from memory
    window.addEventListener('unload', function() {
        // Clear any sensitive variables
        if (typeof password !== 'undefined') {
            password.value = '';
        }
        if (typeof passwordConfirm !== 'undefined') {
            passwordConfirm.value = '';
        }
    });

    // Prevent password managers from auto-filling (additional security)
    setTimeout(function() {
        document.querySelectorAll('.auth-reset-password-input').forEach(input => {
            input.setAttribute('autocomplete', 'off');
            input.setAttribute('data-lpignore', 'true');
        });
    }, 100);

    // Browser back button handling
    window.addEventListener('popstate', function(e) {
        if (confirm('⚠️ Are you sure you want to leave? Your password reset progress will be lost.')) {
            // Clear sensitive data before leaving
            document.querySelectorAll('.auth-reset-password-input').forEach(input => {
                input.value = '';
            });
        } else {
            history.pushState(null, null, window.location.pathname);
        }
    });

    // Push initial state to handle back button
    history.pushState(null, null, window.location.pathname);
</script>

@endsection
