@extends('layouts.app')
@section('content')

<div class="account-container">
    <!-- Tab Navigation -->
    <div class="account-tabs">
        <button class="account-tab-button active" data-tab="dashboard">Dashboard</button>
        <button class="account-tab-button" data-tab="profile">Profile</button>
        <button class="account-tab-button" data-tab="settings">Settings</button>
        @if(Auth::user()->pgpKey && !Auth::user()->pgpKey->verified)
            <button class="account-tab-button" data-tab="pgp-verify">Verify PGP</button>
        @endif
    </div>

    <!-- Dashboard Tab -->
    <div class="account-tab-content active" id="dashboard">
        <div class="dashboard-container">
            <div class="dashboard-grid">
                <!-- Profile Information Card -->
                <div class="dashboard-card dashboard-profile-card">
                    <div class="dashboard-profile-header">
                        <div class="dashboard-profile-image-container">
                            <img class="dashboard-profile-image" src="{{ $profile ? $profile->profile_picture_url : asset('images/default-profile-picture.png') }}" alt="Profile Picture">
                        </div>
                        <h2 class="dashboard-profile-name">{{ e($user->username) }}</h2>
                        <p class="dashboard-profile-role">{{ $userRole }}</p>
                        @if($showFullInfo)
                            <p class="dashboard-profile-last-login">Last Login: {{ $user->last_login ? $user->last_login->format('d-m-Y') : 'Never' }}</p>
                        @endif
                    </div>
                    
                    <h3 class="dashboard-card-title">PGP Key Status</h3>
                    <div class="dashboard-pgp-status">
                        @if($pgpKey)
                            @if($pgpKey->verified)
                                <span class="dashboard-pgp-badge dashboard-pgp-verified">Verified</span>
                            @else
                                <span class="dashboard-pgp-badge dashboard-pgp-unverified">Unverified</span>
                            @endif
                        @else
                            <span class="dashboard-pgp-badge dashboard-pgp-none">No PGP Key</span>
                        @endif
                    </div>
                </div>

                <!-- Profile Description and PGP Key Card -->
                <div>
                    <!-- Profile Description -->
                    <div class="dashboard-card">
                        <h3 class="dashboard-card-title">Profile Description</h3>
                        <div class="dashboard-description">
                            <p>{!! $description !!}</p>
                        </div>
                    </div>

                    <!-- Current PGP Key -->
                    <div class="dashboard-card" style="margin-top: 30px;">
                        <h3 class="dashboard-card-title">Current PGP Key</h3>
                        <div class="dashboard-pgp-key-container">
                            <div class="dashboard-pgp-key">
                                @if($pgpKey)
                                    <pre>{{ $pgpKey->public_key }}</pre>
                                @else
                                    <div class="dashboard-pgp-empty">
                                        <p>No PGP key added yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Tab -->
    <div class="account-tab-content" id="profile">
        <div class="profile-container">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="profile-card">
                    <div class="profile-grid">
                        <div class="profile-sidebar">
                            <div class="profile-picture-container">
                                <div class="profile-picture">
                                    <img src="{{ $profile->profile_picture_url }}" alt="Profile Picture">
                                </div>
                                <div class="profile-picture-upload">
                                    <label for="profile_picture" class="profile-picture-label">
                                        Change Picture
                                    </label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="profile-picture-input">
                                    <small class="profile-picture-hint">Allowed: JPEG, PNG, GIF, WebP. Maximum: 800KB. Will be resized to 160x160px.</small>
                                </div>
                            </div>
                            <div class="profile-pgp-section">
                                <h5 class="profile-pgp-title">PGP Key Status</h5>
                                @if(Auth::user()->pgpKey)
                                    @if(Auth::user()->pgpKey->verified)
                                        <div class="profile-pgp-status profile-pgp-verified">
                                            <span>Verified PGP Public Key</span>
                                        </div>
                                    @else
                                        <div class="profile-pgp-status profile-pgp-unverified">
                                            <span>Unverified PGP Public Key</span>
                                        </div>
                                        <div>
                                            <button type="button" class="profile-pgp-verify" onclick="switchTab('pgp-verify')">Verify PGP Public Key</button>
                                        </div>
                                    @endif
                                @else
                                    <div class="profile-pgp-status profile-pgp-none">
                                        <span>No PGP Key Added</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="profile-form-section">
                            <h2 class="profile-form-title">Update Your Profile</h2>
                            <div class="profile-form-group">
                                <label for="description" class="profile-form-label">Description</label>
                                <textarea name="description" id="description" rows="10" required minlength="4" maxlength="800" class="profile-form-textarea">{{ old('description', $profile->description ? e(Crypt::decryptString($profile->description)) : '') }}</textarea>
                                <small class="profile-form-hint">You can write between 4 and 800 characters. Letters, numbers, spaces and punctuation marks are allowed. Adding a description is required before adding a profile picture.</small>
                            </div>
                            <div>
                                <button type="submit" class="profile-submit-btn">Update Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Settings Tab -->
    <div class="account-tab-content" id="settings">
        <div class="settings-container">
            <div class="settings-grid">
                <div class="settings-card">
                    <div class="settings-card-title">Need a New Password?</div>
                    <form method="POST" action="{{ route('settings.changePassword') }}">
                        @csrf
                        <div class="settings-form-group">
                            <label class="settings-form-label" for="current_password">Current Password</label>
                            <input class="settings-form-input" id="current_password" type="password" name="current_password" required minlength="8" maxlength="40" autocomplete="current-password">
                        </div>
                        <div class="settings-form-group">
                            <label class="settings-form-label" for="password">New Password</label>
                            <input class="settings-form-input" id="password" type="password" name="password" required minlength="8" maxlength="40" autocomplete="new-password">
                        </div>
                        <div class="settings-form-group">
                            <label class="settings-form-label" for="password_confirmation">Confirm New Password</label>
                            <input class="settings-form-input" id="password_confirmation" type="password" name="password_confirmation" required minlength="8" maxlength="40" autocomplete="new-password">
                        </div>
                        <button class="settings-button" type="submit">
                            Change Password
                        </button>
                    </form>
                </div>

                <div class="settings-card">
                    <div class="settings-card-title">Manage PGP Key</div>
                    <form method="POST" action="{{ route('settings.updatePgpKey') }}">
                        @csrf
                        <div class="settings-form-group">
                            <label class="settings-form-label" for="public_key">PGP Public Key</label>
                            <textarea class="settings-form-textarea" id="public_key" name="public_key" rows="10" required minlength="100" maxlength="8000">{{ old('public_key', $user->pgpKey->public_key ?? '') }}</textarea>
                        </div>
                        <p class="settings-info-text">You can check the Guides section to learn about PGP.</p>
                        <button class="settings-button" type="submit">
                            {{ $user->pgpKey ? 'Update PGP Key' : 'Add PGP Key' }}
                        </button>
                    </form>
                </div>

                <div class="settings-card">
                    <div class="settings-card-title">Anti‑Phishing Secret Phrase</div>
                    @if ($user->secretPhrase)
                        <div class="settings-highlight">
                            <p>Your Secret Phrase</p>
                            <p class="settings-phrase">{{ $user->secretPhrase->phrase }}</p>
                            <p>This phrase will always be displayed on your settings page. If you don't see this phrase when logging in, you may be on a phishing site.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('settings.updateSecretPhrase') }}">
                            @csrf
                            <div class="settings-form-group">
                                <label class="settings-form-label" for="secret_phrase">Secret Phrase (4‑16 letters, no numbers)</label>
                                <input class="settings-form-input" id="secret_phrase" type="text" name="secret_phrase" required minlength="4" maxlength="16">
                            </div>
                            <p class="settings-info-text">This is a one‑time setting to help prevent phishing attacks. Your phrase will always be visible on this page.</p>
                            <button class="settings-button" type="submit">Set Secret Phrase</button>
                        </form>
                    @endif
                </div>

                <div class="settings-card">
                    <div class="settings-card-title">Account Protection</div>
                    @if (!$user->pgpKey || !$user->pgpKey->verified)
                        <div class="settings-message settings-message-warning">
                            <p>You need to verify your PGP key to enable 2‑factor authentication.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('pgp.2fa.update') }}">
                            @csrf
                            @method('PUT')
                            <label class="settings-form-label" for="two_fa">2‑Factor Authentication</label>
                            <div class="settings-toggle-container">
                                <button class="settings-toggle-button{{ $user->pgpKey->two_fa_enabled ? ' active' : '' }}" type="submit" name="two_fa_enabled" value="1">ON</button>
                                <button class="settings-toggle-button{{ !$user->pgpKey->two_fa_enabled ? ' active' : '' }}" type="submit" name="two_fa_enabled" value="0">OFF</button>
                            </div>
                            <p class="settings-info-text">With 2FA enabled, you'll need your PGP key to decrypt a message during login. This prevents unauthorized access even if your password is compromised.</p>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- PGP Verification Tab -->
    @if(Auth::user()->pgpKey && !Auth::user()->pgpKey->verified)
        <div class="account-tab-content" id="pgp-verify">
            <div class="container">
                <div class="pgp-confirm-container">
                    <h1 class="pgp-confirm-title">Confirm PGP Public Key</h1>
                    <div class="pgp-confirm-card">
                        <div class="pgp-confirm-card-body">
                            <h5 class="pgp-confirm-card-title text-center">Encrypted Message</h5>
                            <pre class="pgp-confirm-encrypted-message">{{ $encryptedMessage ?? 'Loading encrypted message...' }}</pre>
                            <p class="pgp-confirm-instruction">Please decrypt this message using your private key and enter the decrypted message below.</p>
                            <form method="POST" action="{{ route('pgp.confirm.submit') }}" class="pgp-confirm-form">
                                @csrf
                                <div class="pgp-confirm-form-group">
                                    <label for="decrypted_message" class="pgp-confirm-label text-center">Decrypted Message</label>
                                    <textarea name="decrypted_message" id="decrypted_message" class="pgp-confirm-textarea" rows="1" required minlength="16" maxlength="20"></textarea>
                                </div>
                                <div class="pgp-confirm-submit-wrapper">
                                    <button type="submit" class="pgp-confirm-submit-btn">Confirm PGP Key</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Tab Navigation Styles */
.account-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.account-tabs {
    display: flex;
    border-bottom: 2px solid #e0e0e0;
    margin-bottom: 30px;
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
    overflow: hidden;
}

.account-tab-button {
    flex: 1;
    padding: 15px 20px;
    background: #f8f9fa;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    color: #666;
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
}

.account-tab-button:hover {
    background: #e9ecef;
    color: #333;
}

.account-tab-button.active {
    background: #fff;
    color: #007bff;
    border-bottom-color: #007bff;
}

.account-tab-content {
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}

.account-tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .account-tabs {
        flex-direction: column;
    }
    
    .account-tab-button {
        border-bottom: 1px solid #e0e0e0;
        border-radius: 0;
    }
    
    .account-tab-button.active {
        border-bottom-color: #007bff;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.account-tab-button');
    const tabContents = document.querySelectorAll('.account-tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all tabs and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
    
    // Function to switch tabs programmatically
    window.switchTab = function(tabName) {
        const targetButton = document.querySelector(`[data-tab="${tabName}"]`);
        if (targetButton) {
            targetButton.click();
        }
    };
});
</script>

@endsection