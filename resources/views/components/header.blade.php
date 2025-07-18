<header class="header">
    <div class="header-left">
        <a href="{{ route('home') }}" class="logo-link">
            <img src="{{ asset('images/omega.png') }}" alt="Logo" class="logo-img">
            <span class="logo-text">{{ config('app.name') }}</span>
        </a>
        <form action="{{ route('products.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search..." class="search-input" value="{{ request('search') }}">
            <select name="category" class="search-category">
                <option value="">All Categories</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
    <div class="header-right">
        <a href="{{ route('guides.index') }}" class="header-link">Guides</a>
        <a href="{{ route('rules') }}" class="header-link">Rules</a>
        <a href="{{ route('references.index') }}" class="header-link">References</a>
        @auth
            <a href="{{ route('cart.index') }}" class="header-link">Cart ({{ \App\Models\Cart::getTotalItems() }})</a>
            <a href="{{ route('wallet.index') }}" class="header-link">Wallet</a>
            <a href="{{ route('dashboard') }}" class="header-link">Dashboard</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="header-link">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="header-link">Login</a>
            <a href="{{ route('register') }}" class="header-link">Register</a>
        @endauth
    </div>
</header>
