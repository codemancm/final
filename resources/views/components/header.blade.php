<!-- Header -->
<div class="header">
    <div class="header-top">
        <div class="logo">
            <div class="logo-icon">S</div>
            <div class="logo-text">Silk Highway</div>
        </div>
        
        <div class="search-bar">
            <input name="search" id="search" type="text" class="search-input" value="{{ $filters['search'] ?? '' }}" minlength="1" maxlength="80" placeholder="Search products, vendors...">
            <button class="search-btn">🔍</button>
        </div>

        
        <div class="header-right">
            <span>🇺🇸 EN</span>
            <span>💰 XMR</span>
            <div class="user-info">
                @auth
                    <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile Picture" class="user-avatar">
                @else
                    <div class="user-avatar-placeholder"></div>
                @endauth
                <span>username</span>
                @auth
                    <span style="background-color: #333; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">{{ e(auth()->user()->username) }}</span>
                @endauth
            </div>

            @auth
                <a href="{{ route('notifications.index') }}" class="notification-icon {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                    🔔
                    @if(auth()->user()->unread_notifications_count > 0)
                        <span class="notification-badge">{{ auth()->user()->unread_notifications_count }}</span>
                    @endif
                </a>
            @endauth


            @auth
                <a href="{{ route('cart.index') }}" class="cart-icon {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    🛒
                    @if(auth()->user()->cartItems()->count() > 0)
                        <span class="cart-count">{{ auth()->user()->cartItems()->count() }}</span>
                    @endif
                </a>
            @endauth

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="navbar-btn navbar-btn-logout">
                        Logout
                        <img src="{{ asset('icons/logout.png') }}" alt="Logout" class="navbar-btn-icon navbar-btn-icon-logout">
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>

<!-- Navigation -->
<div class="nav">
    <div class="nav-container">
        <button class="nav-btn mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
        <button class="nav-btn">📋 Categories</button>
        <div class="nav-links">
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">🏠 Home</a>
            <a href="{{ route('messages.index') }}" class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" >💬 Messages</a>
            <a href="{{ route('wishlist.index') }}" class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}" >❤️ Wishlist</a>
            <a href="{{ route('wallet.index') }}" class="nav-link {{ request()->routeIs('wallet.*') ? 'active' : '' }}">💰 Wallet</a>
            @auth
                <span class="navbar-text">
                    Balance: {{ Auth::user()->wallet->balance }} XMR
                </span>
            @endauth
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">👤 Account</a>
            <a href="{{ route('support.index') }}" class="nav-link {{ request()->routeIs('support.*') ? 'active' : '' }}">🎧 Support</a>
        </div>
    </div>
</div>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-content">
        <button class="mobile-menu-close" onclick="toggleMobileMenu()">×</button>
        <div style="margin-top: 30px;">
            <a href="#" class="nav-link" onclick="showSection('products'); toggleMobileMenu()">🏠 Home</a>
            <a href="#" class="nav-link" onclick="showSection('messages'); toggleMobileMenu()">💬 Messages</a>
            <a href="#" class="nav-link" onclick="showSection('wishlist'); toggleMobileMenu()">❤️ Wishlist</a>
            <a href="#" class="nav-link" onclick="showSection('wallet'); toggleMobileMenu()">💰 Wallet</a>
            <a href="#" class="nav-link" onclick="showSection('account'); toggleMobileMenu()">👤 Account</a>
            <a href="#" class="nav-link" onclick="showSection('canary'); toggleMobileMenu()">🚦 Canary</a>
            <a href="#" class="nav-link" onclick="showSection('support'); toggleMobileMenu()">🎧 Support</a>
            <a href="#" class="nav-link" onclick="showSection('disputes'); toggleMobileMenu()">⚖️ Disputes</a>
            <a href="#" class="nav-link" onclick="showSection('references'); toggleMobileMenu()">📋 References</a>
            <a href="#" class="nav-link" onclick="showSection('addresses'); toggleMobileMenu()">📍 Addresses</a>
            <a href="#" class="nav-link" onclick="showSection('rules'); toggleMobileMenu()">📜 Rules</a>
            <a href="#" class="nav-link" onclick="showSection('guide'); toggleMobileMenu()">📖 Guide</a>
            <a href="#" class="nav-link" onclick="showSection('pgpkey'); toggleMobileMenu()">🔒PGP Key</a>
        </div>
    </div>
</div>

<style>
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

.search-bar {
    display: flex;
    flex: 1;
    max-width: 600px;
    margin: 0 20px;
    min-width: 300px;
}

.search-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px 0 0 4px;
    font-size: 14px;
}

.search-btn {
    background-color: #333;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
}

.user-avatar-placeholder {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #333;
}

.cart-icon {
    position: relative;
    background-color: #333;
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    white-space: nowrap;
}

.cart-count {
    position: absolute;
    top: -8px;
    right: -10px;
    background-color: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    font-weight: bold;
}
.notification-icon {
    position: relative;
    background-color: #e74c3c;
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #ff0000;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Navigation */
.nav {
    background-color: #ffd700;
    padding: 10px 0;
    position: sticky;
    top: 60px; /* Adjust based on your actual header height */
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
}

.nav-btn {
    background-color: #333;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 20px;
}

.nav-links {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
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

/* Mobile Menu */
.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

.mobile-menu {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.8);
    z-index: 1000;
}

.mobile-menu-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 80%;
    height: 100%;
    background-color: white;
    padding: 20px;
    overflow-y: auto;
}

.mobile-menu-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 30px;
    cursor: pointer;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-top {
        flex-direction: column;
        gap: 15px;
    }

    .search-bar {
        width: 100%;
        margin: 0;
        min-width: auto;
    }

    .header-right {
        width: 100%;
        justify-content: space-between;
    }

    .nav-container {
        flex-direction: column;
        align-items: flex-start;
    }

    .nav-links {
        width: 100%;
        justify-content: space-around;
    }

    .mobile-menu-btn {
        display: block;
    }

    .nav-links {
        display: none;
    }

    .mobile-menu.active {
        display: block;
    }

    .logo-text {
        font-size: 18px;
    }

    .search-input {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}
</style>