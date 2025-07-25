@extends('layouts.app')

@section('content')

<div class="products-index-container">
    <div class="products-index-content">
        {{-- Search and Filter Form --}}
        <div class="products-index-filter-card">
            <form action="{{ route('products.index') }}" method="GET">
                {{-- Top Row: Vendor + Dropdowns --}}
                <div class="products-index-filter-row">
                    <div class="products-index-filter-left">
                        <div class="products-index-form-group">
                            <label for="vendor" class="products-index-label">By Vendor</label>
                            <input type="text" 
                                   name="vendor" 
                                   id="vendor" 
                                   value="{{ $filters['vendor'] ?? '' }}"
                                   placeholder="Search vendor 🔎"
                                   minlength="1"
                                   maxlength="16"
                                   class="products-index-input">
                        </div>
                    </div>
                    
                    <div class="products-index-filter-right">
                        <div class="products-index-form-group">
                            <label for="type" class="products-index-label">By Product Type</label>
                            <select name="type" 
                                    id="type" 
                                    class="products-index-select">
                                <option value="">All Types</option>
                                <option value="digital" {{ ($currentType === 'digital') ? 'selected' : '' }}>Digital</option>
                                <option value="cargo" {{ ($currentType === 'cargo') ? 'selected' : '' }}>Cargo</option>
                                <option value="deaddrop" {{ ($currentType === 'deaddrop') ? 'selected' : '' }}>Dead Drop</option>
                            </select>
                        </div>

                        <div class="products-index-form-group">
                            <label for="category" class="products-index-label">By Category</label>
                            <select name="category" 
                                    id="category" 
                                    class="products-index-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="products-index-form-group">
                            <label for="sort_by" class="products-index-label">Sort by</label>
                            <select name="sort_by"
                                    id="sort_by"
                                    class="products-index-select">
                                <option value="">Random</option>
                                <option value="price_asc" {{ ($filters['sort_by'] ?? '') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ ($filters['sort_by'] ?? '') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="rating" {{ ($filters['sort_by'] ?? '') === 'rating' ? 'selected' : '' }}>Rating</option>
                                <option value="newest" {{ ($filters['sort_by'] ?? '') === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="popular" {{ ($filters['sort_by'] ?? '') === 'popular' ? 'selected' : '' }}>Popular</option>
                            </select>
                        </div>
                        <div class="products-index-form-group">
                            <label for="ships_to" class="products-index-label">Ships to</label>
                            <input type="text"
                                   name="ships_to"
                                   id="ships_to"
                                   value="{{ $filters['ships_to'] ?? '' }}"
                                   placeholder="Enter country"
                                   class="products-index-input">
                        </div>
                        <div class="products-index-form-group">
                            <label for="price_min" class="products-index-label">Min Price (XMR)</label>
                            <input type="number"
                                   name="price_min"
                                   id="price_min"
                                   value="{{ $filters['price_min'] ?? '' }}"
                                   class="products-index-input">
                        </div>
                        <div class="products-index-form-group">
                            <label for="price_max" class="products-index-label">Max Price (XMR)</label>
                            <input type="number"
                                   name="price_max"
                                   id="price_max"
                                   value="{{ $filters['price_max'] ?? '' }}"
                                   class="products-index-input">
                        </div>
                    </div>
                </div>

                {{-- Middle Row: Main Search --}}
                <div class="products-index-search-container">
                    <div class="products-index-main-search">
                        <label for="search" class="products-index-main-search-label">Search Product</label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ $filters['search'] ?? '' }}"
                               placeholder="Search by product title 🔎"
                               minlength="1"
                               maxlength="80"
                               class="products-index-main-search-input">
                    </div>
                </div>

                
                {{-- Bottom Row: Buttons --}}
                <div class="products-index-filter-actions">
                    <a href="{{ route('products.index') }}" class="products-index-button products-index-button-secondary">
                        Reset Filters
                    </a>
                    <button type="submit" class="products-index-button products-index-button-primary">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($products->isEmpty())
        <div class="products-index-empty">
            <p>No products found.</p>
        </div>
    @else
        <x-products 
            :products="$products"
        />
    @endif
</div>

@endsection



