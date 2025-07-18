<div class="sidebar">
    <a href="{{ route('admin.index') }}" class="sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
        <i class="fas fa-users"></i>
        <span>Users</span>
    </a>
    <a href="{{ route('admin.all-products') }}" class="sidebar-link {{ request()->routeIs('admin.all-products') ? 'active' : '' }}">
        <i class="fas fa-box"></i>
        <span>Products</span>
    </a>
    <a href="{{ route('admin.support.requests') }}" class="sidebar-link {{ request()->routeIs('admin.support.requests') ? 'active' : '' }}">
        <i class="fas fa-headset"></i>
        <span>Support</span>
    </a>
    <a href="{{ route('admin.bulk-message.list') }}" class="sidebar-link {{ request()->routeIs('admin.bulk-message.list') ? 'active' : '' }}">
        <i class="fas fa-envelope"></i>
        <span>Bulk Message</span>
    </a>
    <a href="{{ route('admin.disputes.index') }}" class="sidebar-link {{ request()->routeIs('admin.disputes.index') ? 'active' : '' }}">
        <i class="fas fa-gavel"></i>
        <span>Disputes</span>
    </a>
    <a href="{{ route('admin.categories') }}" class="sidebar-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
        <i class="fas fa-tags"></i>
        <span>Categories</span>
    </a>
    <a href="{{ route('admin.logs') }}" class="sidebar-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i>
        <span>Logs</span>
    </a>
    <a href="{{ route('admin.canary') }}" class="sidebar-link {{ request()->routeIs('admin.canary') ? 'active' : '' }}">
        <i class="fas fa-shield-alt"></i>
        <span>Canary</span>
    </a>
    <a href="{{ route('admin.vendor-applications.index') }}" class="sidebar-link {{ request()->routeIs('admin.vendor-applications.index') ? 'active' : '' }}">
        <i class="fas fa-store"></i>
        <span>Vendor Applications</span>
    </a>
    <a href="{{ route('admin.popup.index') }}" class="sidebar-link {{ request()->routeIs('admin.popup.index') ? 'active' : '' }}">
        <i class="fas fa-bullhorn"></i>
        <span>Pop-up</span>
    </a>
    <a href="{{ route('admin.statistics') }}" class="sidebar-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i>
        <span>Statistics</span>
    </a>
    <a href="{{ route('admin.escrow.index') }}" class="sidebar-link {{ request()->routeIs('admin.escrow.index') ? 'active' : '' }}">
        <i class="fas fa-money-check-alt"></i>
        <span>Escrow</span>
    </a>
</div>
