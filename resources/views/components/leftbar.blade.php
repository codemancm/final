<div class="main-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-section">
            <div class="sidebar-buttons">
                @if(auth()->user()->isVendor())
                    <button onclick="window.location.href='{{ route('vendor.index') }}'" 
                            class="sidebar-btn {{ request()->routeIs('vendor.*') ? 'active' : '' }}">
                        👥 Vendor-Panel
                    </button>
                @endif

                @if(auth()->user()->isAdmin())
                    <button onclick="window.location.href='{{ route('admin.index') }}'" 
                            class="sidebar-btn {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        🛠️ Admin-Panel
                    </button>
                    <button onclick="window.location.href='{{ route('admin.roles.list') }}'"
                            class="sidebar-btn {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        📜 Roles
                    </button>
                    <button onclick="window.location.href='{{ route('admin.admins.list') }}'"
                            class="sidebar-btn {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        👮 Admins
                    </button>
                @endif
                <button class="sidebar-btn {{ request()->routeIs('products.*') ? 'active' : '' }}"onclick="window.location.href='{{ route('products.index') }}'">📦 Products</button>
                <button class="sidebar-btn {{ request()->routeIs('services.*') ? 'active' : '' }}"onclick="window.location.href='{{ route('services.index') }}'">🛎️ Services</button>
                <button class="sidebar-btn {{ request()->routeIs('vendors.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('vendors.index') }}'" >👥 Vendors</button>
                <button class="sidebar-btn {{ request()->routeIs('orders.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('orders.index') }}'">🧳 Order</button>
                <button class="sidebar-btn {{ request()->routeIs('become.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('become.vendor') }}'">🏪 Be a Vendor</button>
                <button class="sidebar-btn {{ request()->routeIs('return-addresses.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('return-addresses.index') }}'">📍 Addresses</button>
                <button class="sidebar-btn {{ request()->routeIs('references.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('references.index') }}'">📋 References</button>
                <button class="sidebar-btn {{ request()->routeIs('disputes.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('disputes.index') }}'">⚖️ Disputes</button>
                <button class="sidebar-btn" onclick="window.location.href='{{ route('canary') }}'">🚦 Canary</button>
                <button class="sidebar-btn {{ request()->routeIs('rules') ? 'active' : '' }}" onclick="window.location.href='{{ route('rules') }}'">📜 Rules</button>
                <button class="sidebar-btn {{ request()->routeIs('guides.*') ? 'active' : '' }}" onclick="window.location.href='{{ route('guides.index') }}'">📖 Guide</button>
                <button class="sidebar-btn " onclick="window.location.href='{{ route('pgp-key') }}'">🔒 PGP Key</button>
                @if(config('marketplace.show_javascript_warning'))
                    <div class="footer-javascript-warning-left js-warning-elements">
                        <span class="footer-javascript-warning-text-left">Please Disable JavaScript</span>
                    </div>
                @endif



            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-title">🔍 Quick Search</div>
            <div class="quick-search">
                <input type="text" placeholder="Search...">
                <button>🔍</button>
            </div>
            <div style="margin-top: 10px;">
                <label style="font-size: 12px; margin-bottom: 5px; display: block;">Search Vendor:</label>
                <input type="text" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px;">
            </div>
            <div style="margin-top: 10px;">
                <label style="font-size: 12px; margin-bottom: 5px; display: block;">Sort by:</label>
                <select style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px;">
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Rating</option>
                    <option>Newest</option>
                </select>
            </div>
            <button style="width: 100%; background-color: #333; color: white; border: none; padding: 8px; border-radius: 4px; margin-top: 10px; cursor: pointer;">Search</button>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-title">Browse Categories</div>
            <ul class="category-list">
                <li class="category-item">🧪 computer (21)</li>
                <li class="category-item">🌿 laptop (17)</li>
                <li class="category-item">💻 phones (8)</li>
                <li class="category-item">💊 watch (15)</li>
                <li class="category-item">🏥 clothe (12)</li>
                <li class="category-item">🔐 shoe (5)</li>
            </ul>
        </div>
    </div>

    <!-- Content Sections -->
    <div style="flex: 1;">
        <!-- Products Section -->
        <div class="content-section active" id="products">
            <div class="products-container">
                <div class="products-header">Featured Products</div>
                
                <div class="products-grid">
                    <!-- Product 1 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #8B4513, #D2691E);">CREDIT CARD</div>
                        <div class="product-info">
                            <div class="quality-badge">Quality: 500ml</div>
                            <div class="product-title">CREDIT CARD</div>
                            <div class="product-vendor">Vendor: Amazon</div>
                            <div class="product-type">Type: Credit Card</div>
                            <div class="product-details">
                                <div class="product-price">99.30 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">Germany - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #FF6B6B, #FFA07A);">Qualuude 300mg</div>
                        <div class="product-info">
                            <div class="quality-badge">Quality: 300mg</div>
                            <div class="product-title">Qualuude 300mg</div>
                            <div class="product-vendor">Vendor: MedSupply</div>
                            <div class="product-type">Type: computer</div>
                            <div class="product-details">
                                <div class="product-price">5.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">Australia - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #4ECDC4, #45B7D1);">High quality heroin powder</div>
                        <div class="product-info">
                            <div class="quality-badge">Quality: 1g</div>
                            <div class="product-title">High quality heroin powder</div>
                            <div class="product-vendor">Vendor: DrugStore</div>
                            <div class="product-type">Type: laptop</div>
                            <div class="product-details">
                                <div class="product-price">100.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">USA - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>
                    <!-- Product 4 -->
                        <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #FFB6C1, #FF69B4);">High quality cocaine</div>
                        <div class="product-info">
                            <div class="quality-badge">Quality: 1g</div>
                            <div class="product-title">High quality cocaine</div>
                            <div class="product-vendor">Vendor: DrugStore</div>
                            <div class="product-type">Type: phones</div>
                            <div class="product-details">
                                <div class="product-price">150.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">USA - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>
                                            <!-- Product 5 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #98FB98, #90EE90);">Premium Cannabis</div>
                        <div class="product-info">
                            <div class="quality-badge">Quality: 5g</div>
                            <div class="product-title">Premium Cannabis</div>
                            <div class="product-vendor">Vendor: GreenSupply</div>
                            <div class="product-type">Type: watch</div>
                            <div class="product-details">
                                <div class="product-price">75.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">Canada - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 6 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #DDA0DD, #DA70D6);">Fake ID Card</div>
                        <div class="product-info">
                            <div class="featured-badge">Featured</div>
                            <div class="product-title">Fake ID Card</div>
                            <div class="product-vendor">Vendor: IDMaster</div>
                            <div class="product-type">Type: clothe</div>
                            <div class="product-details">
                                <div class="product-price">200.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">UK - Europe</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 7 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #F0E68C, #FFD700);">Bitcoin Wallet</div>
                        <div class="product-info">
                            <div class="quality-badge">Quality: Digital</div>
                            <div class="product-title">Bitcoin Wallet</div>
                            <div class="product-vendor">Vendor: CryptoKing</div>
                            <div class="product-type">Type: shoe</div>
                            <div class="product-details">
                                <div class="product-price">50.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">Global - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 8 -->
                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(45deg, #FF7F50, #FF6347);">Stolen Data Package</div>
                        <div class="product-info">
                            <div class="featured-badge">Hot</div>
                            <div class="product-title">Stolen Data Package</div>
                            <div class="product-vendor">Vendor: DataBroker</div>
                            <div class="product-type">Type: computer</div>
                            <div class="product-details">
                                <div class="product-price">25.00 XMR</div>
                                <div class="product-rating">
                                    <span class="stars">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <div class="product-location">Russia - Worldwide</div>
                            <div class="product-actions">
                                <button class="buy-btn">Buy Now</button>
                                <button class="view-btn">View | Select</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendors Section -->
        <div class="content-section" id="vendors">
            <div class="section-title">Trusted Vendors</div>
            <div class="vendor-grid">
                <div class="vendor-card">
                    <div class="vendor-name">Amazon</div>
                    <div class="vendor-rating">⭐⭐⭐⭐⭐ (4.9/5)</div>
                    <div class="vendor-stats">Products: 45 | Sales: 1,234 | Since: 2020</div>
                    <p>Specializes in credit cards and financial services. Trusted vendor with excellent reputation.</p>
                </div>
                <div class="vendor-card">
                    <div class="vendor-name">MedSupply</div>
                    <div class="vendor-rating">⭐⭐⭐⭐⭐ (4.8/5)</div>
                    <div class="vendor-stats">Products: 67 | Sales: 2,156 | Since: 2019</div>
                    <p>Premium pharmaceutical supplier with worldwide shipping and quality guarantee.</p>
                </div>
                <div class="vendor-card">
                    <div class="vendor-name">DrugStore</div>
                    <div class="vendor-rating">⭐⭐⭐⭐⭐ (4.7/5)</div>
                    <div class="vendor-stats">Products: 23 | Sales: 987 | Since: 2021</div>
                    <p>High-quality products with discreet packaging and fast delivery worldwide.</p>
                </div>
                <div class="vendor-card">
                    <div class="vendor-name">GreenSupply</div>
                    <div class="vendor-rating">⭐⭐⭐⭐⭐ (4.9/5)</div>
                    <div class="vendor-stats">Products: 34 | Sales: 1,567 | Since: 2020</div>
                    <p>Premium cannabis products sourced from the finest growers in Canada.</p>
                </div>
            </div>
        </div>

        <!-- Be a Vendor Section -->
        <div class="content-section" id="be-vendor">
            <div class="section-title">Become a Vendor</div>
            <div class="address-form">
                <div class="form-group">
                    <label>Vendor Name</label>
                    <input type="text" placeholder="Enter your vendor name">
                </div>
                <div class="form-group">
                    <label>Product Category</label>
                    <select>
                        <option>Select category</option>
                        <option>Computer</option>
                        <option>Laptop</option>
                        <option>Phones</option>
                        <option>Watch</option>
                        <option>Clothe</option>
                        <option>Shoe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea placeholder="Describe your products and services"></textarea>
                </div>
                <div class="form-group">
                    <label>Contact Information</label>
                    <input type="text" placeholder="Secure contact method">
                </div>
                <button class="btn-primary">Apply to Become Vendor</button>
            </div>
        </div>

        <!-- Addresses Section -->
        <div class="content-section" id="addresses">
            <div class="section-title">Shipping Addresses</div>
            <div class="address-form">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label>Address Line 1</label>
                    <input type="text" placeholder="Street address">
                </div>
                <div class="form-group">
                    <label>Address Line 2</label>
                    <input type="text" placeholder="Apartment, suite, etc. (optional)">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" placeholder="City">
                </div>
                <div class="form-group">
                    <label>State/Province</label>
                    <input type="text" placeholder="State or Province">
                </div>
                <div class="form-group">
                    <label>ZIP/Postal Code</label>
                    <input type="text" placeholder="ZIP or Postal Code">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select>
                        <option>Select Country</option>
                        <option>United States</option>
                        <option>Canada</option>
                        <option>United Kingdom</option>
                        <option>Germany</option>
                        <option>Australia</option>
                    </select>
                </div>
                <button class="btn-primary">Save Address</button>
            </div>
        </div>

        <!-- References Section -->
        <div class="content-section" id="references">
            <div class="section-title">User References</div>
            <div class="reference-item">
                <div class="reference-rating">
                    <span class="stars">⭐⭐⭐⭐⭐</span>
                    <strong>Excellent Buyer</strong>
                </div>
                <p>"Fast payment, great communication. Would definitely do business again!"</p>
                <small>- Vendor: Amazon | Date: 2024-01-15</small>
            </div>
            <div class="reference-item">
                <div class="reference-rating">
                    <span class="stars">⭐⭐⭐⭐⭐</span>
                    <strong>Trusted Customer</strong>
                </div>
                <p>"Professional and reliable. Quick to finalize transactions."</p>
                <small>- Vendor: MedSupply | Date: 2024-01-10</small>
            </div>
            <div class="reference-item">
                <div class="reference-rating">
                    <span class="stars">⭐⭐⭐⭐⭐</span>
                    <strong>Great Experience</strong>
                </div>
                <p>"Smooth transaction, no issues whatsoever. Highly recommended!"</p>
                <small>- Vendor: DrugStore | Date: 2024-01-05</small>
            </div>
        </div>

        <!-- Disputes Section -->
        <div class="content-section" id="disputes">
            <div class="section-title">Dispute Resolution</div>
            <div class="dispute-item">
                <div class="dispute-status dispute-resolved">RESOLVED</div>
                <h4>Order #12345 - Product not as described</h4>
                <p><strong>Issue:</strong> Product quality was lower than advertised</p>
                <p><strong>Resolution:</strong> Partial refund of 25 XMR issued</p>
                <small>Resolved on: 2024-01-12</small>
            </div>
            <div class="dispute-item">
                <div class="dispute-status dispute-open">OPEN</div>
                <h4>Order #12346 - Late delivery</h4>
                <p><strong>Issue:</strong> Package arrived 5 days late</p>
                <p><strong>Status:</strong> Waiting for vendor response</p>
                <small>Opened on: 2024-01-18</small>
            </div>
        </div>

        <!-- Support Section -->
        <div class="content-section" id="support">
            <div class="section-title">Customer Support</div>
            <div class="address-form">
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="Brief description of your issue">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select>
                        <option>Select category</option>
                        <option>Order Issue</option>
                        <option>Payment Problem</option>
                        <option>Technical Support</option>
                        <option>Account Issue</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea placeholder="Describe your issue in detail"></textarea>
                </div>
                <button class="btn-primary">Submit Support Ticket</button>
            </div>
        </div>

        <!-- Rules Section -->
        <div class="content-section" id="rules">
            <div class="section-title">Marketplace Rules</div>
            <div class="rules-section">
                <div class="rules-title">General Rules</div>
                <ol class="rules-list">
                    <li>All users must maintain anonymity and use secure communication methods</li>
                    <li>No scamming, fraud, or dishonest business practices</li>
                    <li>Disputes must be resolved through the official resolution system</li>
                    <li>Vendors must provide accurate product descriptions and images</li>
                    <li>All transactions must use the escrow system for protection</li>
                </ol>
            </div>
            <div class="rules-section">
                <div class="rules-title">Vendor Rules</div>
                <ol class="rules-list">
                    <li>Maintain a minimum 4.0 star rating to continue selling</li>
                    <li>Ship orders within 48 hours of payment confirmation</li>
                    <li>Provide tracking information when available</li>
                    <li>Respond to customer messages within 24 hours</li>
                    <li>Honor all product guarantees and return policies</li>
                </ol>
            </div>
            <div class="rules-section">
                <div class="rules-title">Buyer Rules</div>
                <ol class="rules-list">
                    <li>Complete payment within 24 hours of placing an order</li>
                    <li>Provide accurate shipping information</li>
                    <li>Finalize orders promptly upon satisfactory delivery</li>
                    <li>Leave honest feedback for all transactions</li>
                    <li>Report any issues through proper channels</li>
                                        </ol>
            </div>
        </div>

        <!-- Guide Section -->
        <div class="content-section" id="guide">
            <div class="section-title">User Guide</div>
            <div class="guide-step">
                <span class="guide-step-number">1</span>
                <div>
                    <h4>Account Setup</h4>
                    <p>Create your account using secure credentials. Enable two-factor authentication for enhanced security. Set up your PGP key for encrypted communications.</p>
                </div>
            </div>
            <div class="guide-step">
                <span class="guide-step-number">2</span>
                <div>
                    <h4>Wallet Setup</h4>
                    <p>Fund your wallet with Bitcoin or other accepted cryptocurrencies. Always verify wallet addresses before sending funds. Keep your private keys secure.</p>
                </div>
            </div>
            <div class="guide-step">
                <span class="guide-step-number">3</span>
                <div>
                    <h4>Making a Purchase</h4>
                    <p>Browse products, read vendor reviews, and check ratings. Add items to cart and proceed to checkout. Funds will be held in escrow until delivery confirmation.</p>
                </div>
            </div>
            <div class="guide-step">
                <span class="guide-step-number">4</span>
                <div>
                    <h4>Security Best Practices</h4>
                    <p>Always use Tor browser and VPN. Never share personal information. Use encrypted messaging for vendor communication. Regularly update your security settings.</p>
                </div>
            </div>
            <div class="guide-step">
                <span class="guide-step-number">5</span>
                <div>
                    <h4>Order Tracking</h4>
                    <p>Monitor your orders in the dashboard. Communicate with vendors through the secure messaging system. Confirm receipt and leave feedback upon delivery.</p>
                </div>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="content-section" id="messages">
            <div class="section-title">Secure Messages</div>
            <div style="border: 1px solid #ddd; border-radius: 6px; padding: 20px; background-color: #f9f9f9;">
                <div style="margin-bottom: 20px;">
                    <h4>Conversation with Amazon</h4>
                    <div style="background-color: #e3f2fd; padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                        <strong>Amazon:</strong> Your order has been processed and will ship within 24 hours.
                        <small style="display: block; color: #666; margin-top: 5px;">2 hours ago</small>
                    </div>
                    <div style="background-color: #f0f0f0; padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                        <strong>You:</strong> Thank you for the update. Please provide tracking information when available.
                        <small style="display: block; color: #666; margin-top: 5px;">1 hour ago</small>
                    </div>
                    <div style="background-color: #e3f2fd; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                        <strong>Amazon:</strong> Tracking number: TR123456789. Package will arrive in 3-5 business days.
                        <small style="display: block; color: #666; margin-top: 5px;">30 minutes ago</small>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" placeholder="Type your message..." style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <button class="btn-primary">Send</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wallet Section -->
        <div class="content-section" id="wallet">
            <div class="section-title">Wallet Management</div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
                


                <div style="border: 1px solid #ddd; border-radius: 6px; padding: 20px; background-color: #f9f9f9;">
                    <h4>Monero Wallet</h4>
                    <div style="font-size: 24px; font-weight: bold; color: #333; margin: 10px 0;">2.45 XMR</div>
                    <div style="color: #666; margin-bottom: 15px;">≈ 367.50 XMR</div>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-primary" style="flex: 1;">Deposit</button>
                        <button class="btn-primary" style="flex: 1;">Withdraw</button>
                    </div>
                </div>
            </div>
            <div style="border: 1px solid #ddd; border-radius: 6px; padding: 20px; background-color: #f9f9f9;">
                <h4>Recent Transactions</h4>
                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">
                        <div>
                            <strong>Purchase - Order #12345</strong>
                            <div style="font-size: 12px; color: #666;">2024-01-18 14:30</div>
                        </div>
                        <div style="color: #e74c3c; font-weight: bold;">-0.00230 BTC</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">
                        <div>
                            <strong>Deposit</strong>
                            <div style="font-size: 12px; color: #666;">2024-01-17 09:15</div>
                        </div>
                        <div style="color: #28a745; font-weight: bold;">+0.01000 BTC</div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">
                        <div>
                            <strong>Purchase - Order #12344</strong>
                            <div style="font-size: 12px; color: #666;">2024-01-16 16:45</div>
                        </div>
                        <div style="color: #e74c3c; font-weight: bold;">-0.00115 BTC</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Section -->
        <div class="content-section" id="account">
            <div class="section-title">Account Settings</div>
            <div class="address-form">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" value="username" readonly>
                </div>
                <div class="form-group">
                    <label>Account Type</label>
                    <input type="text" value="ADMIN" readonly>
                </div>
                <div class="form-group">
                    <label>Member Since</label>
                    <input type="text" value="January 2024" readonly>
                </div>
                <div class="form-group">
                    <label>Change Password</label>
                    <input type="password" placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" placeholder="Confirm new password">
                </div>
                <div class="form-group">
                    <label>PGP Public Key</label>
                    <textarea placeholder="Paste your PGP public key here for encrypted communications"></textarea>
                </div>
                <div class="form-group">
                    <label>Two-Factor Authentication</label>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" id="2fa" checked>
                        <label for="2fa" style="margin: 0;">Enable 2FA (Recommended)</label>
                    </div>
                </div>
                <button class="btn-primary">Update Account</button>
            </div>
        </div>

        <!-- Notifications Section -->
        <div class="content-section" id="notifications">
            <div class="section-title">Notifications</div>
            <div class="notification-item notification-unread">
                <div class="notification-icon-wrapper">📦</div>
                <div class="notification-content">
                    <div class="notification-title">Order Shipped</div>
                    <div>Your order #12345 has been shipped and is on its way!</div>
                    <div class="notification-time">2 hours ago</div>
                </div>
            </div>
            <div class="notification-item notification-unread">
                <div class="notification-icon-wrapper">💬</div>
                <div class="notification-content">
                    <div class="notification-title">New Message</div>
                    <div>You have a new message from vendor Amazon</div>
                    <div class="notification-time">4 hours ago</div>
                </div>
            </div>
            <div class="notification-item notification-unread">
                <div class="notification-icon-wrapper">⚖️</div>
                <div class="notification-content">
                    <div class="notification-title">Dispute Resolved</div>
                    <div>Your dispute for order #12344 has been resolved in your favor</div>
                    <div class="notification-time">1 day ago</div>
                </div>
            </div>
            <div class="notification-item">
                <div class="notification-icon-wrapper">🔔</div>
                <div class="notification-content">
                    <div class="notification-title">System Maintenance</div>
                    <div>Scheduled maintenance will occur tonight from 2-4 AM UTC</div>
                    <div class="notification-time">2 days ago</div>
                </div>
            </div>
            <div class="notification-item">
                <div class="notification-icon-wrapper">⭐</div>
                <div class="notification-content">
                    <div class="notification-title">New Review</div>
                    <div>Vendor Amazon left you a 5-star review</div>
                    <div class="notification-time">3 days ago</div>
                </div>
            </div>
        </div>
    </div>
</div>


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

        /* Main Content */
        .main-container {
            max-width: 1800px;
            margin: 20px auto;
            padding: 0 20px;
            display: flex;
            gap: 20px;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 140px;
        }

        .sidebar-section {
            margin-bottom: 30px;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .sidebar-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar-btn {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 10px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-align: left;
            font-size: 14px;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-btn:hover {
            background-color: #e0e0e0;
        }

        .sidebar-btn.active {
            background-color: #333;
            color: white;
        }

        .quick-search {
            display: flex;
            margin-bottom: 10px;
        }

        .quick-search input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 14px;
        }

        .quick-search button {
            background-color: #333;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            padding: 8px 0;
            cursor: pointer;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
            transition: color 0.2s;
        }

        .category-item:hover {
            color: #007bff;
        }

        /* Products Grid - Modified for 4 columns */
        .products-container {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        .products-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.2s;
            height: 280px;
            min-width: 0; /* Allows cards to shrink if needed */
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            background-color: #f0f0f0;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .product-info {
            padding: 10px;
            height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
            color: #333;
            line-height: 1.2;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .product-price {
            font-size: 14px;
            font-weight: bold;
            color: #e74c3c;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stars {
            color: #ffd700;
            font-size: 12px;
        }

        .product-location {
            font-size: 10px;
            color: #666;
            margin-bottom: 8px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
        }

        .buy-btn {
            background-color: #333;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px;
            flex: 1;
        }

        .view-btn {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px;
            flex: 1;
        }

        .quality-badge {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 8px;
            margin-bottom: 3px;
        }

        .featured-badge {
            display: inline-block;
            background-color: #ff6b00;
            color: white;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 8px;
            margin-bottom: 3px;
        }

        .product-vendor {
            font-size: 10px;
            color: #666;
            margin-bottom: 3px;
        }

        .product-type {
            font-size: 10px;
            color: #666;
            margin-bottom: 3px;
        }

        /* Content Sections */
        .content-section {
            display: none;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .content-section.active {
            display: block;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .vendor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .vendor-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .vendor-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .vendor-rating {
            color: #ffd700;
            margin-bottom: 5px;
        }

        .vendor-stats {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }

        .address-form {
            display: grid;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .dispute-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .dispute-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dispute-open {
            background-color: #ffeaa7;
            color: #d63031;
        }

        .dispute-resolved {
            background-color: #55efc4;
            color: #00b894;
        }

        .reference-item {
            border-left: 4px solid #007bff;
            padding: 10px 15px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }

        .reference-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .rules-section {
            margin-bottom: 30px;
        }

        .rules-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .rules-list {
            list-style: decimal;
            margin-left: 20px;
        }

        .rules-list li {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .guide-step {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .guide-step-number {
            display: inline-block;
            background-color: #007bff;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }

        .notification-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-unread {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }

        .notification-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #007bff;
            color: white;
            font-size: 18px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .notification-time {
            font-size: 12px;
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

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

            .main-container {
                flex-direction: column;
                gap: 15px;
            }

            .sidebar {
                width: 100%;
                position: relative;
                top: auto;
                order: 2;
            }

            .products-container {
                order: 1;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .vendor-grid {
                grid-template-columns: 1fr;
            }

            .mobile-menu.active {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 0 10px;
            }

            .sidebar {
                padding: 15px;
            }

            .products-container {
                padding: 15px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .logo-text {
                font-size: 18px;
            }

            .search-input {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
    </style>