@extends('layouts.app')

@section('content')
<div class="a-v-panel-container vendor-dashboard">
    <div class="a-v-panel-card">
        <h1 class="a-v-panel-title">Vendor Dashboard</h1>
        <p class="a-v-panel-welcome">Welcome to the Vendor Panel. Here you can manage your products in {{ config('app.name') }}.</p>

        <div class="statistics-section">
            <h2 class="statistics-title">Your Statistics</h2>
            <div class="statistics-grid">
                <div class="statistic-card">
                    <div class="statistic-card-title">Total Products</div>
                    <div class="statistic-card-value">{{ $totalProducts }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Total Sales</div>
                    <div class="statistic-card-value">{{ $totalSales }}</div>
                </div>
                <div class="statistic-card">
                    <div class="statistic-card-title">Total Disputes</div>
                    <div class="statistic-card-value">{{ $totalDisputes }}</div>
                </div>
            </div>
        </div>

        <div class="a-v-panel-grid">
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Add Digital Product</h3>
                <p class="a-v-panel-item-description">You can add digital products to {{ config('app.name') }}.</p>
                <a href="{{ route('vendor.products.create', 'digital') }}" class="a-v-panel-item-link">Add Digital Product</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Add Cargo Product</h3>
                <p class="a-v-panel-item-description">You can add physical products that can be delivered by shipping.</p>
                <a href="{{ route('vendor.products.create', 'cargo') }}" class="a-v-panel-item-link">Add Cargo Product</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Add Dead Drop Product</h3>
                <p class="a-v-panel-item-description">You can add products that can be delivered via dead drop.</p>
                <a href="{{ route('vendor.products.create', 'deaddrop') }}" class="a-v-panel-item-link">Add Dead Drop Product</a>
            </div>
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">Vendor Appearance</h3>
                <p class="a-v-panel-item-description">You can customize your store appearance and profile.</p>
                <a href="{{ route('vendor.appearance') }}" class="a-v-panel-item-link">Edit Appearance</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">My Products</h3>
                <p class="a-v-panel-item-description">You can view all products you have listed for sale on {{ config('app.name') }}.</p>
                <a href="{{ route('vendor.my-products') }}" class="a-v-panel-item-link">View My Products</a>
            </div>
            
            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">My Sales</h3>
                <p class="a-v-panel-item-description">You can view all your completed sales.</p>
                <a href="{{ route('vendor.sales') }}" class="a-v-panel-item-link">View My Sales</a>
            </div>

            <div class="a-v-panel-item">
                <h3 class="a-v-panel-item-title">My Disputes</h3>
                <p class="a-v-panel-item-description">View and manage customer disputes and resolution cases.</p>
                <a href="{{ route('vendor.disputes.index') }}" class="a-v-panel-item-link">View Disputes</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.body.classList.add('vendor-dashboard');
</script>
@endsection
