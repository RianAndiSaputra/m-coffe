<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kifa Bakery Pusat - POS System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .empty-cart {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #9CA3AF;
        }
        .empty-cart i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .cart-items-container {
            overflow-y: auto;
            max-height: calc(100vh - 400px);
        }
        .cart-item-grid {
            display: grid;
            grid-template-columns: minmax(150px, 2fr) 120px 80px 100px 40px;
            gap: 10px;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
        @media (max-width: 1024px) {
            .cart-item-grid {
                grid-template-columns: minmax(120px, 2fr) 100px 70px 90px 40px;
            }
        }
        .qty-control {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .qty-input {
            width: 40px;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 4px;
        }
        .discount-input {
            width: 50px;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 4px;
        }
    </style>
</head>
<body class="bg-white font-sans overflow-x-hidden">
    <div class="container-fluid p-0">
        <!-- Enhanced Navbar -->
        <nav class="navbar bg-white shadow-sm border-b py-4 px-5">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-3">
                <a href="#" class="text-orange-500 font-bold text-xl md:text-2xl">Kifa Bakery Pusat</a>
                <div class="flex flex-wrap gap-2 items-center">
                   <button id="btnStockModal" class="px-3 py-1.5 text-sm text-black font-bold bg-orange-50 border border-orange-300 rounded-md hover:bg-orange-100 transition-colors">
                        <i class="fas fa-box mr-1.5 text-orange-500 text-base"></i> Stok
                    </button>

                    <button id="btnIncomeModal" class="px-3 py-1.5 text-sm text-black font-bold bg-orange-50 border border-orange-300 rounded-md hover:bg-orange-100 transition-colors">
                        <i class="fas fa-money-bill mr-1.5 text-orange-500 text-base"></i> Rp 0
                    </button>

                    <button id="btnCashierModal" class="px-3 py-1.5 text-sm text-black font-bold bg-orange-50 border border-orange-300 rounded-md hover:bg-orange-100 transition-colors">
                        <i class="fas fa-cash-register mr-1.5 text-orange-500 text-base"></i> Kas kasir
                    </button>
                    
                  <button class="px-5 py-2.5 text-base text-black font-bold rounded-md hover:bg-orange-50 transition-colors">
                    <i class="fas fa-user mr-2 text-orange-500 text-base"></i>
                    <span id="userLabel" class="font-medium">Loading...</span>
                    </button>

                    <button id="logoutButton" class="px-3 py-1.5 text-sm text-black font-bold border border-orange-300 rounded-md hover:bg-orange-100 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1.5 text-orange-500 text-lg"></i>
                    </button>

                </div>
            </div>
        </nav>

        <div class="main-container flex h-[calc(100vh-68px)] overflow-hidden">
            <!-- Products Section -->
            <div class="products-section w-2/3 bg-white flex flex-col border-r-2 border-orange-200">
                <!-- Search and Categories Section -->
                <div class="p-4">
                    <div class="search-bar mb-3">
                        <input
                            id="searchInput"
                            type="text"
                            class="w-full px-3 py-2 text-sm rounded-md border border-orange-300 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-gray-400 transition-all duration-200"
                            placeholder="Cari produk..."
                        >
                    </div>

                    <div class="category-container overflow-x-auto whitespace-nowrap pb-1 mb-2">
                        <ul id="categoryTabs" class="nav flex-nowrap">
                            <!-- Categories will be dynamically added here -->
                        </ul>
                    </div>
                </div>

                <hr class="border-t border-orange-500 opacity-30 my-0">

                <!-- Products List -->
                <div id="productsContainer" class="flex-1 overflow-y-auto p-4">
                    <div class="empty-cart p-8 text-center">
                        <i class="fas fa-spinner fa-spin text-gray-300"></i>
                        <p class="text-gray-500 text-lg font-medium">Memuat produk...</p>
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="cart-section w-1/3 bg-white flex flex-col overflow-hidden border-l-2 border-orange-200">
                  <div class="cart-header p-4 border-b-2 border-orange-200">
                    <h4 class="text-lg m-0 flex items-center font-semibold">
                        <i class="fas fa-shopping-cart text-orange-500 mr-3"></i> Keranjang
                    </h4>
                </div>

                <div class="cart-column-headers p-4 text-sm font-semibold text-gray-600 bg-gray-50">
                    <div class="grid grid-cols-12">
                        <div class="col-span-5">Produk</div>
                        <div class="col-span-3 text-center">Qty</div>
                        <div class="col-span-2 text-center">Diskon</div>
                        <div class="col-span-2 text-right">Subtotal</div>
                    </div>
                </div>

                <div id="cartItems" class="cart-items-container">
                    <!-- Empty cart state -->
                    <div id="emptyCart" class="empty-cart p-8 text-center">
                        <i class="fas fa-shopping-cart text-gray-300"></i>
                        <p class="text-gray-500 text-lg font-medium">Keranjang kosong</p>
                        <p class="text-gray-400 text-sm mt-1">Tambahkan produk ke keranjang</p>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="payment-section p-5 border-t border-orange-200">
                    <div class="flex justify-between mb-1">
                        <div class="summary-item text-base text-gray-700">Subtotal</div>
                        <div id="subtotal" class="summary-item text-base text-gray-700">Rp 0</div>
                    </div>
                    <div class="flex justify-between mb-3">
                        <div class="summary-item text-base text-gray-500">Pajak (0%)</div>
                        <div class="summary-item text-base text-gray-500">Rp 0</div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-orange-200 my-3"></div>

                    <div class="flex justify-between mb-5">
                        <div class="summary-item text-lg text-gray-800 font-bold">Total</div>
                        <div id="total" class="text-orange-500 font-extrabold text-2xl">Rp 0</div>
                    </div>
                    <div class="border-t border-orange-200 my-3 mb-3"></div>
                    <!-- Tombol Pembayaran -->
                    <button id="btnPaymentModal" class="bg-orange-500 text-white border border-orange-500 w-full py-2 font-semibold rounded-md text-sm mb-3 hover:bg-orange-600 transition-colors">
                        <i class="fas fa-money-bill-wave mr-2"></i> Pembayaran
                    </button>

                    <!-- Tombol Riwayat Transaksi -->
                    <button id="btnHistoryModal" class="border border-gray-300 w-full py-2 text-sm rounded-md bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-history mr-2"></i> Riwayat Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals would be included here -->
    @include('partials.pos.cashier-modal')
    @include('partials.pos.history-modal')
    @include('partials.pos.income-modal')
    @include('partials.pos.payment-modal')
    @include('partials.pos.stock')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Initialize cart and product data
        let cart = [];
        let products = [];
        let categories = [];
        
        // DOM elements
        const searchInput = document.getElementById('searchInput');
        const categoryTabs = document.getElementById('categoryTabs');
        const productsContainer = document.getElementById('productsContainer');
        const cartItemsContainer = document.getElementById('cartItems');
        const emptyCartElement = document.getElementById('emptyCart');
        const subtotalElement = document.getElementById('subtotal');
        const totalElement = document.getElementById('total');
        
        // Modal buttons
        const btnCashierModal = document.getElementById('btnCashierModal');
        const btnHistoryModal = document.getElementById('btnHistoryModal');
        const btnIncomeModal = document.getElementById('btnIncomeModal');
        const btnPaymentModal = document.getElementById('btnPaymentModal');
        const btnStockModal = document.getElementById('btnStockModal');
        
        // API Configuration
        const API_URL = 'http://127.0.0.1:8000/api/products/outlet/1';
        const API_TOKEN = localStorage.getItem('token') || '';
        
        // Show SweetAlert notification
        function showNotification(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
            let icon = 'check-circle';
            let background = '#F97316'; // orange
            
            if (type === 'error') {
                icon = 'x-circle';
                background = '#EF4444'; // red
            } else if (type === 'warning') {
                icon = 'alert-circle';
                background = '#F59E0B'; // yellow
            } else if (type === 'info') {
                icon = 'info';
                background = '#3B82F6'; // blue
            }
            
            Toast.fire({
                iconHtml: `<i data-lucide="${icon}" class="text-white"></i>`,
                title: message,
                background: background,
                color: 'white',
                iconColor: 'white'
            });
            
            // Refresh Lucide icons after showing notification
            lucide.createIcons();
        }
        
        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        
        // Modal event listeners
        btnCashierModal.addEventListener('click', function() {
            openModal('cashierModal');
        });
        
        btnHistoryModal.addEventListener('click', function() {
            openModal('historyModal');
        });
        
        btnIncomeModal.addEventListener('click', function() {
            openModal('incomeModal');
        });
        
        btnPaymentModal.addEventListener('click', function() {
            if (cart.length === 0) {
                showNotification('Keranjang belanja kosong', 'warning');
                return;
            }
            openModal('paymentModal');
        });
        
        btnStockModal.addEventListener('click', function() {
            openModal('stockModal');
        });
        
        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function() {
                const modalId = this.closest('.modal').id;
                closeModal(modalId);
            });
        });
        
        // Fetch products from API
        async function fetchProducts() {
            try {
                if (!API_TOKEN) {
                    throw new Error('Token tidak ditemukan');
                }
                
                const response = await fetch(API_URL, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${API_TOKEN}`,
                        'Accept': 'application/json'
                    },
                    credentials: 'include'
                });
                
                if (response.status === 401) {
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                    return;
                }
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    // Format products correctly
                    products = data.data.map(product => ({
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price), // Convert string to number
                        quantity: product.quantity,
                        min_stock: product.min_stock,
                        category: product.category || { name: 'uncategorized' },
                        outlets: product.outlets
                    }));
                    
                    organizeProductsByCategory();
                    renderProducts();
                    renderCategories();
                    
                    // Store products in localStorage
                    const storageData = {
                        timestamp: new Date().getTime(),
                        products: products
                    };
                    localStorage.setItem('posProducts', JSON.stringify(storageData));
                    showNotification('Produk berhasil dimuat', 'success');
                } else {
                    throw new Error(data.message || 'Failed to load products');
                }
            } catch (error) {
                console.error('Error fetching products:', error);
                showNotification('Koneksi error, menggunakan data lokal', 'warning');
                loadProductsFromLocalStorage();
            }
        }
        
        // Load products from localStorage
        function loadProductsFromLocalStorage() {
            try {
                const storedData = localStorage.getItem('posProducts');
                if (storedData) {
                    const parsedData = JSON.parse(storedData);
                    
                    if (parsedData.products && Array.isArray(parsedData.products)) {
                        products = parsedData.products;
                    } else if (Array.isArray(parsedData)) {
                        products = parsedData;
                    }
                    
                    if (products.length > 0) {
                        organizeProductsByCategory();
                        renderProducts();
                        renderCategories();
                        return true;
                    }
                }
                return false;
            } catch (error) {
                console.error('Error loading products from localStorage:', error);
                return false;
            }
        }
        
        // Organize products by category
        function organizeProductsByCategory() {
            const uniqueCategories = [...new Set(products.map(product => 
                product.category && product.category.name ? 
                product.category.name.toLowerCase() : 'uncategorized'
            ))];
            categories = ['all', ...uniqueCategories];
        }
        
        // Render categories to the tabs
        function renderCategories() {
            categoryTabs.innerHTML = '';
            
            categories.forEach(category => {
                const categoryName = category === 'all' ? 'Semua' : 
                                    category === 'uncategorized' ? 'Lainnya' : 
                                    category.charAt(0).toUpperCase() + category.slice(1);
                const isActive = category === 'all';
                
                const tabItem = document.createElement('li');
                tabItem.className = 'inline-flex';
                
                tabItem.innerHTML = `
                    <a href="#" data-category="${category}" class="nav-link ${isActive ? 'active' : ''} px-3 py-1.5 text-xs font-medium rounded-full mr-2 ${isActive ? 'bg-orange-500 text-white border-orange-400' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-100'} border shadow-sm transition-all duration-200">
                        ${categoryName}
                    </a>
                `;
                
                categoryTabs.appendChild(tabItem);
            });
            
            // Add event listeners to category tabs
            document.querySelectorAll('#categoryTabs .nav-link').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active tab
                    document.querySelectorAll('#categoryTabs .nav-link').forEach(t => {
                        t.classList.remove('active', 'bg-orange-500', 'text-white', 'border-orange-400');
                        t.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
                    });
                    
                    this.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
                    this.classList.add('active', 'bg-orange-500', 'text-white', 'border-orange-400');
                    
                    const category = this.getAttribute('data-category');
                    const searchTerm = searchInput.value;
                    renderProducts(category, searchTerm);
                });
            });
        }
        
        // Render products to the DOM
        function renderProducts(filterCategory = 'all', searchTerm = '') {
            productsContainer.innerHTML = '';
            
            if (!products || products.length === 0) {
                productsContainer.innerHTML = `
                    <div class="empty-cart p-8 text-center">
                        <i data-lucide="package-x" class="w-12 h-12 mx-auto text-gray-300"></i>
                        <p class="text-gray-500 text-lg font-medium mt-4">Tidak ada produk tersedia</p>
                        <p class="text-gray-400 text-sm mt-1">Silakan perbarui data produk</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }
            
            const filteredProducts = products.filter(product => {
                const productCategory = product.category && product.category.name ? 
                                    product.category.name.toLowerCase() : 'uncategorized';
                
                const matchesCategory = filterCategory === 'all' || productCategory === filterCategory;
                const matchesSearch = product.name.toLowerCase().includes(searchTerm.toLowerCase());
                return matchesCategory && matchesSearch;
            });
            
            if (filteredProducts.length === 0) {
                productsContainer.innerHTML = `
                    <div class="empty-cart p-8 text-center">
                        <i data-lucide="search-x" class="w-12 h-12 mx-auto text-gray-300"></i>
                        <p class="text-gray-500 text-lg font-medium mt-4">Produk tidak ditemukan</p>
                        <p class="text-gray-400 text-sm mt-1">Coba kata kunci atau kategori lain</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }
            
            filteredProducts.forEach(product => {
                const productElement = document.createElement('div');
                productElement.className = 'product-item mb-3';
                
                const categoryName = product.category && product.category.name ? 
                                    product.category.name : 'Uncategorized';
                
                productElement.setAttribute('data-category', categoryName.toLowerCase());
                productElement.setAttribute('data-name', product.name.toLowerCase());
                
                // Determine stock status
                const quantity = product.quantity || 0;
                const isOutOfStock = quantity <= 0;
                const isLowStock = quantity > 0 && quantity <= (product.min_stock || 5);
                
                productElement.innerHTML = `
                    <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                        <div>
                            <div class="product-name text-base font-medium">${product.name} (${quantity})</div>
                            <div class="product-price text-orange-500 font-semibold text-base">Rp ${product.price.toLocaleString('id-ID')}</div>
                            ${isLowStock ? '<span class="low-stock bg-yellow-100 px-2 py-1 rounded text-sm text-yellow-800 font-medium mt-1 inline-block">Produk menipis</span>' : ''}
                        </div>
                        <div class="flex items-center">
                            <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">
                                ${categoryName.toUpperCase()}
                            </span>
                            ${isOutOfStock ? 
                                '<button class="bg-gray-100 text-gray-500 border border-gray-300 rounded px-4 py-2 text-sm w-24">Habis</button>' : 
                                `<button class="btn-add-to-cart bg-orange-500 text-white border-none rounded px-4 py-2 text-sm flex items-center justify-center w-24 hover:bg-orange-600 transition-colors">
                                    <i data-lucide="plus" class="w-4 h-4 mr-1"></i> Tambah
                                </button>`
                            }
                        </div>
                    </div>
                `;
                
                productsContainer.appendChild(productElement);
            });
            
            // Refresh Lucide icons
            lucide.createIcons();
            
            // Add event listeners to all "Add to Cart" buttons
            document.querySelectorAll('.btn-add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const productName = productCard.querySelector('.product-name').textContent.split(' (')[0];
                    const product = products.find(p => p.name === productName);
                    
                    if (!product) return;
                    
                    // Check if product already in cart
                    const existingItem = cart.find(item => item.id === product.id);
                    
                    if (existingItem) {
                        existingItem.quantity += 1;
                        existingItem.subtotal = existingItem.quantity * existingItem.price;
                    } else {
                        cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            quantity: 1,
                            discount: 0,
                            subtotal: product.price
                        });
                    }
                    
                    updateCart();
                    showNotification(`${product.name} telah ditambahkan ke keranjang`);
                });
            });
        }
        
        // Update cart display
        function updateCart() {
            cartItemsContainer.innerHTML = '';
            
            let subtotal = 0;
            
            if (cart.length === 0) {
                emptyCartElement.classList.remove('hidden');
                cartItemsContainer.appendChild(emptyCartElement);
                subtotalElement.textContent = 'Rp 0';
                totalElement.textContent = 'Rp 0';
                return;
            } else {
                emptyCartElement.classList.add('hidden');
            }
            
            cart.forEach((item, index) => {
                const itemSubtotal = calculateItemSubtotal(item);
                subtotal += itemSubtotal;
                
                item.subtotal = itemSubtotal;
                
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item hover:bg-gray-50';
                
                cartItemElement.innerHTML = `
                    <div class="cart-item-grid">
                        <div class="product-info">
                            <div class="product-name font-medium text-gray-800">${item.name}</div>
                            <div class="product-price text-sm text-gray-500">Rp ${item.price.toLocaleString('id-ID')}</div>
                        </div>
                        
                        <div class="quantity-control">
                            <div class="qty-control">
                                <button class="btn-decrease px-2 py-1 border border-gray-300 bg-gray-100 rounded hover:bg-gray-200" data-index="${index}">
                                    <i data-lucide="minus" class="w-3 h-3"></i>
                                </button>
                                <input type="text" class="qty-input" value="${item.quantity}" data-index="${index}">
                                <button class="btn-increase px-2 py-1 border border-gray-300 bg-gray-100 rounded hover:bg-gray-200" data-index="${index}">
                                    <i data-lucide="plus" class="w-3 h-3"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="discount-control">
                            <input type="text" class="discount-input" value="${item.discount}" data-index="${index}" placeholder="0">
                        </div>
                        
                        <div class="subtotal text-right font-medium">
                            Rp ${itemSubtotal.toLocaleString('id-ID')}
                        </div>
                        
                        <div class="delete-btn">
                            <button class="btn-remove text-gray-400 hover:text-red-500" data-index="${index}">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                `;
                
                cartItemsContainer.appendChild(cartItemElement);
            });
            
            subtotalElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            totalElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            
            lucide.createIcons();
            
            document.querySelectorAll('.btn-decrease').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    if (cart[index].quantity > 1) {
                        cart[index].quantity -= 1;
                        cart[index].subtotal = calculateItemSubtotal(cart[index]);
                        updateCart();
                    }
                });
            });
            
            document.querySelectorAll('.btn-increase').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart[index].quantity += 1;
                    cart[index].subtotal = calculateItemSubtotal(cart[index]);
                    updateCart();
                });
            });
            
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const newQty = parseInt(this.value) || 1;
                    if (newQty <= 0) {
                        this.value = 1;
                        cart[index].quantity = 1;
                    } else {
                        cart[index].quantity = newQty;
                    }
                    cart[index].subtotal = calculateItemSubtotal(cart[index]);
                    updateCart();
                });
            });
            
            document.querySelectorAll('.discount-input').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const discount = parseInt(this.value) || 0;
                    cart[index].discount = discount;
                    cart[index].subtotal = calculateItemSubtotal(cart[index]);
                    updateCart();
                });
            });
            
            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const removedItem = cart.splice(index, 1)[0];
                    showNotification(`${removedItem.name} telah dihapus dari keranjang`, 'info');
                    updateCart();
                });
            });
        }
        
        function calculateItemSubtotal(item) {
            const basePrice = item.price * item.quantity;
            const discountAmount = item.discount || 0;
            return Math.max(0, basePrice - discountAmount);
        }
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value;
            const activeCategory = document.querySelector('#categoryTabs .nav-link.active')?.getAttribute('data-category') || 'all';
            renderProducts(activeCategory, searchTerm);
        });
        
        function initCart() {
            const savedCart = localStorage.getItem('posCart');
            if (savedCart) {
                try {
                    cart = JSON.parse(savedCart);
                    updateCart();
                } catch (e) {
                    console.error('Error loading cart from localStorage:', e);
                    cart = [];
                }
            }
        }
        
        function saveCart() {
            localStorage.setItem('posCart', JSON.stringify(cart));
        }
        
        ['click', 'change', 'input'].forEach(eventType => {
            document.addEventListener(eventType, function(e) {
                if (e.target.closest('.cart-item') || e.target.closest('.btn-add-to-cart')) {
                    setTimeout(saveCart, 100);
                }
            });
        });
        
        window.clearCart = function() {
            cart = [];
            updateCart();
            saveCart();
            showNotification('Keranjang telah dikosongkan', 'info');
        };
        
        window.refreshProducts = function() {
            fetchProducts();
        };
        
        initCart();
        const loadedFromStorage = loadProductsFromLocalStorage();
        fetchProducts();
    });

    // Logout function
    document.getElementById('logoutButton').addEventListener('click', function() {
        fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
            },
            credentials: 'include'
        })
        .then(res => {
            if (!res.ok) {
                throw new Error(`Logout failed with status ${res.status}`);
            }
            return res.json();
        })
        .then(() => {
            localStorage.removeItem('token');
            window.location.href = '/';
        })
        .catch(err => {
            console.error('Logout error:', err);
            showNotification('Gagal logout!', 'error');
        });
    });

    // Load user data
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem("token");
        const userLabel = document.getElementById("userLabel");

        if (!token) {
            console.warn("Token tidak ditemukan di localStorage.");
            userLabel.innerText = "Belum login";
            return;
        }

        fetch("/api/me", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`
            },
            credentials: 'include'
        })
        .then(response => {
            if (response.status === 401) {
                localStorage.removeItem('token');
                window.location.href = '/login';
                return;
            }
            
            if (!response.ok) {
                throw new Error(`HTTP status ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.data) {
                const user = data.data;
                userLabel.innerText = user.name || user.email || "Pengguna";
            } else {
                userLabel.innerText = "User tidak ditemukan";
            }
        })
        .catch(error => {
            console.error("Error saat ambil data user:", error);
            userLabel.innerText = "Gagal ambil user";
        });
    });
</script>
</body>
</html>