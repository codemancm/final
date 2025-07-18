@extends('layouts.app')

@section('content')
<div class="statistics-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="dashboard-title">
                <i class="fas fa-chart-line"></i>
                Marketplace Analytics
            </h1>
            <p class="dashboard-subtitle">Real-time insights and statistics</p>
        </div>
        <div class="header-actions">
            <button class="refresh-btn" onclick="refreshStats()">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
        </div>
    </div>

    <!-- Quick Stats Overview -->
    <div class="quick-stats-grid">
        <div class="quick-stat-card users">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalUsers) }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+12%</span>
            </div>
        </div>

        <div class="quick-stat-card products">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalProducts) }}</h3>
                <p>Total Products</p>
            </div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+8%</span>
            </div>
        </div>

        <div class="quick-stat-card security">
            <div class="stat-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($pgpVerificationRate, 1) }}%</h3>
                <p>PGP Verification</p>
            </div>
            <div class="stat-trend {{ $pgpVerificationRate > 50 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $pgpVerificationRate > 50 ? 'up' : 'down' }}"></i>
                <span>{{ $pgpVerificationRate > 50 ? '+' : '-' }}{{ abs($pgpVerificationRate - 50) }}%</span>
            </div>
        </div>

        <div class="quick-stat-card security-alt">
            <div class="stat-icon">
                <i class="fas fa-lock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($twoFaAdoptionRate, 1) }}%</h3>
                <p>2FA Adoption</p>
            </div>
            <div class="stat-trend {{ $twoFaAdoptionRate > 30 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $twoFaAdoptionRate > 30 ? 'up' : 'down' }}"></i>
                <span>{{ $twoFaAdoptionRate > 30 ? '+' : '-' }}{{ abs($twoFaAdoptionRate - 30) }}%</span>
            </div>
        </div>
    </div>

    <!-- Main Statistics Grid -->
    <div class="main-stats-grid">
        <!-- User Analytics Card -->
        <div class="stat-card user-analytics">
            <div class="card-header">
                <h2>
                    <i class="fas fa-user-friends"></i>
                    User Analytics
                </h2>
                <div class="card-actions">
                    <button class="action-btn" title="Export Data">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="total-metric">
                    <span class="metric-value">{{ number_format($totalUsers) }}</span>
                    <span class="metric-label">Total Users</span>
                </div>
                
                <div class="user-roles-breakdown">
                    @foreach($usersByRole as $role)
                        <div class="role-item">
                            <div class="role-info">
                                <span class="role-name">{{ ucfirst($role->name) }}s</span>
                                <span class="role-count">{{ number_format($role->users_count) }}</span>
                            </div>
                            <div class="role-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $totalUsers > 0 ? ($role->users_count / $totalUsers) * 100 : 0 }}%"></div>
                                </div>
                                <span class="percentage">
                                    {{ $totalUsers > 0 ? number_format(($role->users_count / $totalUsers) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="banned-users-section">
                    <div class="alert-banner">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="alert-content">
                            <span class="alert-title">Banned Users</span>
                            <span class="alert-value">{{ number_format($bannedUsersCount) }}</span>
                            <span class="alert-percentage">
                                ({{ $totalUsers > 0 ? number_format(($bannedUsersCount / $totalUsers) * 100, 1) : 0 }}%)
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Overview Card -->
        <div class="stat-card security-overview">
            <div class="card-header">
                <h2>
                    <i class="fas fa-shield-alt"></i>
                    Security Overview
                </h2>
                <div class="security-score">
                    <div class="score-circle">
                        <span class="score-value">{{ number_format(($pgpVerificationRate + $twoFaAdoptionRate) / 2, 0) }}</span>
                        <span class="score-label">Security Score</span>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="security-metrics">
                    <div class="metric-row">
                        <div class="metric-icon pgp">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="metric-details">
                            <h4>PGP Keys</h4>
                            <div class="metric-stats">
                                <span class="primary-stat">{{ number_format($totalPgpKeys) }}</span>
                                <span class="secondary-stat">
                                    {{ $totalUsers > 0 ? number_format(($totalPgpKeys / $totalUsers) * 100, 1) : 0 }}% of users
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="verification-breakdown">
                        <div class="breakdown-item verified">
                            <div class="breakdown-info">
                                <i class="fas fa-check-circle"></i>
                                <span>Verified</span>
                            </div>
                            <div class="breakdown-stats">
                                <span class="count">{{ number_format($verifiedPgpKeys) }}</span>
                                <span class="percentage">{{ number_format($pgpVerificationRate, 1) }}%</span>
                            </div>
                        </div>
                        <div class="breakdown-item unverified">
                            <div class="breakdown-info">
                                <i class="fas fa-times-circle"></i>
                                <span>Unverified</span>
                            </div>
                            <div class="breakdown-stats">
                                <span class="count">{{ number_format($totalPgpKeys - $verifiedPgpKeys) }}</span>
                                <span class="percentage">{{ number_format(100 - $pgpVerificationRate, 1) }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="metric-row">
                        <div class="metric-icon twofa">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="metric-details">
                            <h4>Two-Factor Authentication</h4>
                            <div class="metric-stats">
                                <span class="primary-stat">{{ number_format($twoFaEnabled) }}</span>
                                <span class="secondary-stat">{{ number_format($twoFaAdoptionRate, 1) }}% adoption</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Analytics Card -->
        <div class="stat-card product-analytics">
            <div class="card-header">
                <h2>
                    <i class="fas fa-box-open"></i>
                    Product Analytics
                </h2>
                <div class="card-actions">
                    <select class="filter-select">
                        <option>All Time</option>
                        <option>Last 30 Days</option>
                        <option>Last 7 Days</option>
                    </select>
                </div>
            </div>
            <div class="card-content">
                <div class="total-metric">
                    <span class="metric-value">{{ number_format($totalProducts) }}</span>
                    <span class="metric-label">Total Products</span>
                </div>

                <div class="product-types-grid">
                    <div class="product-type-card digital">
                        <div class="type-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="type-content">
                            <h4>Digital Products</h4>
                            <span class="type-count">{{ number_format($productsByType['digital']) }}</span>
                            <span class="type-percentage">
                                {{ $totalProducts > 0 ? number_format(($productsByType['digital'] / $totalProducts) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="type-chart">
                            <div class="chart-fill" style="height: {{ $totalProducts > 0 ? ($productsByType['digital'] / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="product-type-card cargo">
                        <div class="type-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="type-content">
                            <h4>Cargo Products</h4>
                            <span class="type-count">{{ number_format($productsByType['cargo']) }}</span>
                            <span class="type-percentage">
                                {{ $totalProducts > 0 ? number_format(($productsByType['cargo'] / $totalProducts) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="type-chart">
                            <div class="chart-fill" style="height: {{ $totalProducts > 0 ? ($productsByType['cargo'] / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="product-type-card deaddrop">
                        <div class="type-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="type-content">
                            <h4>Dead Drop</h4>
                            <span class="type-count">{{ number_format($productsByType['deaddrop']) }}</span>
                            <span class="type-percentage">
                                {{ $totalProducts > 0 ? number_format(($productsByType['deaddrop'] / $totalProducts) * 100, 1) : 0 }}%
                            </span>
                        </div>
                        <div class="type-chart">
                            <div class="chart-fill" style="height: {{ $totalProducts > 0 ? ($productsByType['deaddrop'] / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.statistics-dashboard {
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.header-content {
    color: white;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.8;
    margin: 0;
}

.refresh-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.refresh-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.quick-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.quick-stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.quick-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.quick-stat-card.users .stat-icon { background: linear-gradient(45deg, #667eea, #764ba2); }
.quick-stat-card.products .stat-icon { background: linear-gradient(45deg, #f093fb, #f5576c); }
.quick-stat-card.security .stat-icon { background: linear-gradient(45deg, #4facfe, #00f2fe); }
.quick-stat-card.security-alt .stat-icon { background: linear-gradient(45deg, #43e97b, #38f9d7); }

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    color: #333;
}

.stat-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.stat-trend {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.stat-trend.up { color: #10b981; }
.stat-trend.down { color: #ef4444; }

.main-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 0;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 0.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.filter-select {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
}

.card-content {
    padding: 2rem;
}

.total-metric {
    text-align: center;
    margin-bottom: 2rem;
}

.metric-value {
    display: block;
    font-size: 3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
}

.metric-label {
    color: #666;
    font-size: 1.1rem;
}

.user-roles-breakdown {
    margin-bottom: 2rem;
}

.role-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding: 1rem;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
}

.role-info {
    display: flex;
    flex-direction: column;
}

.role-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.role-count {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
}

.role-progress {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    max-width: 200px;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background: rgba(102, 126, 234, 0.2);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s ease;
}

.percentage {
    font-weight: 600;
    color: #667eea;
    min-width: 45px;
}

.banned-users-section {
    margin-top: 1rem;
}

.alert-banner {
    background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-title {
    font-weight: 600;
}

.alert-value {
    font-size: 1.25rem;
    font-weight: 700;
}

.alert-percentage {
    opacity: 0.8;
    font-size: 0.9rem;
}

.security-score {
    display: flex;
    align-items: center;
}

.score-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.score-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
}

.score-label {
    font-size: 0.7rem;
    color: white;
    opacity: 0.8;
}

.security-metrics {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.metric-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
}

.metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.metric-icon.pgp { background: linear-gradient(45deg, #4facfe, #00f2fe); }
.metric-icon.twofa { background: linear-gradient(45deg, #43e97b, #38f9d7); }

.metric-details h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    color: #333;
}

.metric-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.primary-stat {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
}

.secondary-stat {
    color: #666;
    font-size: 0.9rem;
}

.verification-breakdown {
    margin: 1rem 0;
    padding: 1rem;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 12px;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
}

.breakdown-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breakdown-item.verified .breakdown-info i { color: #10b981; }
.breakdown-item.unverified .breakdown-info i { color: #ef4444; }

.breakdown-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.breakdown-stats .count {
    font-weight: 600;
    color: #333;
}

.breakdown-stats .percentage {
    font-weight: 600;
    color: #667eea;
}

.product-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
}

.product-type-card {
    background: rgba(102, 126, 234, 0.1);
    border-radius: 16px;
    padding: 1.5rem 1rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-type-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.type-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    margin: 0 auto 1rem;
}

.product-type-card.digital .type-icon { background: linear-gradient(45deg, #667eea, #764ba2); }
.product-type-card.cargo .type-icon { background: linear-gradient(45deg, #f093fb, #f5576c); }
.product-type-card.deaddrop .type-icon { background: linear-gradient(45deg, #4facfe, #00f2fe); }

.type-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 0.9rem;
    color: #333;
    font-weight: 600;
}

.type-count {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.25rem;
}

.type-percentage {
    font-size: 0.8rem;
    color: #666;
}

.type-chart {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(102, 126, 234, 0.2);
}

.chart-fill {
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: height 0.3s ease;
}

@media (max-width: 768px) {
    .statistics-dashboard {
        padding: 1rem;
    }
    
    .dashboard-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
    
    .main-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .role-item {
        flex-direction: column;
        gap: 1rem;
    }
    
    .role-progress {
        max-width: none;
        width: 100%;
    }
}

/* Animation for cards */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card {
    animation: slideInUp 0.6s ease-out;
}

.quick-stat-card {
    animation: slideInUp 0.4s ease-out;
}

/* Refresh animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.refresh-btn.loading i {
    animation: spin 1s linear infinite;
}
</style>

<script>
function refreshStats() {
    const btn = document.querySelector('.refresh-btn');
    btn.classList.add('loading');
    
    // Simulate refresh (replace with actual AJAX call)
    setTimeout(() => {
        btn.classList.remove('loading');
        // Add any refresh logic here
    }, 2000);
}

// Add smooth animations on scroll
window.addEventListener('scroll', () => {
    const cards = document.querySelectorAll('.stat-card');
    cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }
    });
});
</script>
@endsection