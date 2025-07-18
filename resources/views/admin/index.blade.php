@extends('layouts.app')

@section('content')
<div class="a-v-panel-container admin-dashboard">
    <div class="a-v-panel-card">
        <h1 class="a-v-panel-title">Admin Dashboard</h1>
        <p class="a-v-panel-welcome">Welcome to the Admin Panel. Here you can manage various aspects of {{ config('app.name') }}.</p>

        <div class="statistics-section">
            <h2 class="statistics-title">Platform Statistics</h2>
            <div class="statistics-grid">
                <div class="statistic-card">
                    <div class="statistic-card-title">Total Users</div>
                    <div class="statistic-card-value">{{ $totalUsers }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Total Products</div>
                    <div class="statistic-card-value">{{ $totalProducts }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Banned Users</div>
                    <div class="statistic-card-value">{{ $bannedUsersCount }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">PGP Keys</div>
                    <div class="statistic-card-value">{{ $totalPgpKeys }}</div>
                </div>
            </div>
        </div>

        <div class="statistics-section">
            <h2 class="statistics-title">Overview Panel</h2>
            <div class="statistics-grid">
                <div class="statistic-card">
                    <div class="statistic-card-title">XMR Volume (24h)</div>
                    <div class="statistic-card-value">{{ number_format($dashboardStats['xmr_transaction_volume']['daily'], 5) }} XMR</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">XMR Volume (7d)</div>
                    <div class="statistic-card-value">{{ number_format($dashboardStats['xmr_transaction_volume']['weekly'], 5) }} XMR</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">XMR Volume (30d)</div>
                    <div class="statistic-card-value">{{ number_format($dashboardStats['xmr_transaction_volume']['monthly'], 5) }} XMR</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Total in Escrow</div>
                    <div class="statistic-card-value">{{ number_format($dashboardStats['escrow_status']['total_escrowed'], 5) }} XMR</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Open Disputes</div>
                    <div class="statistic-card-value">{{ $dashboardStats['disputes']['open'] }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Resolved Disputes</div>
                    <div class="statistic-card-value">{{ $dashboardStats['disputes']['resolved'] }}</div>
                </div>
            </div>
        </div>

        <div class="statistics-section">
            <h2 class="statistics-title">System Health</h2>
            <div class="statistics-grid">
                <div class="statistic-card">
                    <div class="statistic-card-title">Server Load</div>
                    <div class="statistic-card-value">{{ $systemHealth['server_load'] }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">TOR Mirrors</div>
                    <div class="statistic-card-value">{{ $systemHealth['tor_mirrors'] }}</div>
                </div>
            </div>
        </div>

        <div class="a-v-panel-grid">
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">User Management</h3>
                <p class="a-v-panel-item-description">View and manage user accounts, roles, and permissions.</p>
                <a href="{{ route('admin.users') }}" class="a-v-panel-item-link">Manage Users</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Manage Products</h3>
                <p class="a-v-panel-item-description">Edit or remove products in the market.</p>
                <a href="{{ route('admin.all-products') }}" class="a-v-panel-item-link">Product Management</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Support Requests</h3>
                <p class="a-v-panel-item-description">View and respond to user support requests.</p>
                <a href="{{ route('admin.support.requests') }}" class="a-v-panel-item-link">Manage Requests</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Bulk Message</h3>
                <p class="a-v-panel-item-description">Send bulk messages to all users or specific roles.</p>
                <a href="{{ route('admin.bulk-message.list') }}" class="a-v-panel-item-link">Send Message</a>
            </div>

            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Disputes</h3>
                <p class="a-v-panel-item-description">View and respond to user disputes for both sides.</p>
                <a href="{{ route('admin.disputes.index') }}" class="a-v-panel-item-link">View Disputes</a>
            </div>

            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Categories</h3>
                <p class="a-v-panel-item-description">Add, remove, or modify site categories.</p>
                <a href="{{ route('admin.categories') }}" class="a-v-panel-item-link">View Categories</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">System Logs</h3>
                <p class="a-v-panel-item-description">Access and analyze system logs for security and performance.</p>
                <a href="{{ route('admin.logs') }}" class="a-v-panel-item-link">View Logs</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Canary</h3>
                <p class="a-v-panel-item-description">Update the current canary of {{ config('app.name') }} with a signed message.</p>
                <a href="{{ route('admin.canary') }}" class="a-v-panel-item-link">Update Canary</a>
            </div>

            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Vendor Applications</h3>
                <p class="a-v-panel-item-description">Review and approve/deny vendor applications requiring verification.</p>
                <a href="{{ route('admin.vendor-applications.index') }}" class="a-v-panel-item-link">Manage Applications</a>
            </div>

            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Web Pop-Up</h3>
                <p class="a-v-panel-item-description">Create and manage website-wide pop-up notifications.</p>
                <a href="{{ route('admin.popup.index') }}" class="a-v-panel-item-link">Configure Popups</a>
            </div>

            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Statistics</h3>
                <p class="a-v-panel-item-description">Access platform analytics and performance metrics dashboards.</p>
                <a href="{{ route('admin.statistics') }}" class="a-v-panel-item-link">View Stats</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.body.classList.add('admin-dashboard');
</script>
@endsection
