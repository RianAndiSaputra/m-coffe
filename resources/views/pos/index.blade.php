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
            flex-grow: 1;
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
            width: 70px;
            text-align: right;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 4px;
        }
        /* New styles for sticky cart footer */
        .cart-section {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .payment-section {
            margin-top: auto;
            background: white;
        }
        /* Scrollable products */
        .products-list-container {
            overflow-y: auto;
            flex-grow: 1;
        }
        /* Payment method selection */
        .payment-method {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .payment-method:hover {
            border-color: #F97316;
        }
        .payment-method.selected {
            border-color: #F97316;
            background-color: #FFF7ED;
        }
        /* Print styles for invoice */
        @media print {
            body * {
                visibility: hidden;
            }
            #invoice-print, #invoice-print * {
                visibility: visible;
            }
            #invoice-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
        /* Member search dropdown */
        .member-search-container {
            position: relative;
        }
        .member-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
            display: none;
        }
        .member-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
        }
        .member-item:hover {
            background-color: #f9fafb;
        }
        .member-item.active {
            background-color: #F97316;
            color: white;
        }
    </style>
</head>
<body class="bg-white font-sans overflow-x-hidden">
    <div class="container-fluid p-0">
        <!-- Enhanced Navbar -->
        <nav class="navbar bg-white shadow-sm border-b py-4 px-5">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-3">
                <a href="#" class="text-orange-500 font-bold text-xl md:text-2xl">
                    <span id="outletName">Loading ...</span>
                </a>
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
                            placeholder="Cari produk atau scan barcode..."
                            autofocus
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
                <div id="productsContainer" class="products-list-container p-4">
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
                        <div class="col-span-2 text-center">Qty</div>
                        <div class="col-span-3 text-center">Diskon</div>
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

                <!-- Payment Section - Now sticks to bottom -->
                <div class="payment-section p-5 border-t border-orange-200">
                    <div class="flex justify-between mb-1">
                        <div class="summary-item text-base text-gray-700">Subtotal</div>
                        <div id="subtotal" class="summary-item text-base text-gray-700">Rp 0</div>
                    </div>
                    <div class="flex justify-between mb-1">
                        <div class="summary-item text-base text-gray-700">Diskon</div>
                        <div id="totalDiscount" class="summary-item text-base text-gray-700">Rp 0</div>
                    </div>
                    <div class="flex justify-between mb-3">
                        <div class="summary-item text-base text-gray-500">Pajak (0%)</div>
                        <div id="taxAmount" class="summary-item text-base text-gray-500">Rp 0</div>
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

    <!-- Include other modals -->
    @include('partials.pos.payment-modal')
    @include('partials.pos.invoice-modal')
    @include('partials.pos.cashier-modal')
    @include('partials.pos.history-modal')
    @include('partials.pos.income-modal')
    @include('partials.pos.stock')

<script> 
    let processPaymentHandler;
    // let cart = [];
    // let products = [];
    // let categories = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Initialize cart and product data
        let cart = [];
        let products = [];
        let categories = [];
        let outletInfo = {
            id: parseInt(localStorage.getItem('outlet_id')) || 1,
            tax: 0,
            qris: null,
            bank_account: null,
            shift_id: parseInt(localStorage.getItem('shift_id')) || null
        };
        let selectedMember = null;
        // Variabel untuk deteksi scan
        let scanTimeout;
        let lastScanTime = 0;
        const SCAN_THRESHOLD = 100; // waktu maksimal antara karakter scan (ms)
        const MIN_BARCODE_LENGTH = 8; // panjang minimal barcode

        const outletName = localStorage.getItem('outlet_name') || 'Kifa Bakery Pusat';
    
        // Set nilai ke elemen
        document.getElementById('outletName').textContent = outletName;
        
        // DOM elements
        const searchInput = document.getElementById('searchInput');
        const categoryTabs = document.getElementById('categoryTabs');
        const productsContainer = document.getElementById('productsContainer');
        const cartItemsContainer = document.getElementById('cartItems');
        const emptyCartElement = document.getElementById('emptyCart');
        const subtotalElement = document.getElementById('subtotal');
        const totalDiscountElement = document.getElementById('totalDiscount');
        const taxAmountElement = document.getElementById('taxAmount');
        const totalElement = document.getElementById('total');
        
        // Member search elements
        const memberSearchInput = document.getElementById('memberSearch');
        const memberDropdownList = document.getElementById('memberDropdownList');
        const memberResultsContainer = document.getElementById('memberResults');
        const selectedMemberContainer = document.getElementById('selectedMember');
        const memberNameElement = document.getElementById('memberName');
        const removeMemberButton = document.getElementById('removeMember');
        
        // Payment modal elements
        const paymentSubtotalElement = document.getElementById('paymentSubtotal');
        const paymentDiscountElement = document.getElementById('paymentDiscount');
        const paymentTaxElement = document.getElementById('paymentTax');
        const paymentGrandTotalElement = document.getElementById('paymentGrandTotal');
        const amountReceivedInput = document.getElementById('amountReceived');
        const changeAmountInput = document.getElementById('changeAmount');
        const paymentMethodsContainer = document.getElementById('paymentMethods');
        const cashPaymentSection = document.getElementById('cashPaymentSection');
        const notesInput = document.getElementById('notes');
        
        // Invoice elements
        const invoiceNumberElement = document.getElementById('invoiceNumber');
        const invoiceDateElement = document.getElementById('invoiceDate');
        const invoiceMemberElement = document.getElementById('invoiceMember');
        const memberNameDisplayElement = document.getElementById('memberNameDisplay');
        const memberCodeDisplayElement = document.getElementById('memberCodeDisplay');
        const invoiceItemsContainer = document.getElementById('invoiceItems');
        const invoiceSubtotalElement = document.getElementById('invoiceSubtotal');
        const invoiceDiscountElement = document.getElementById('invoiceDiscount');
        const invoiceTaxElement = document.getElementById('invoiceTax');
        const invoiceGrandTotalElement = document.getElementById('invoiceGrandTotal');
        const invoicePaymentMethodElement = document.getElementById('invoicePaymentMethod');
        const invoiceCashElement = document.getElementById('invoiceCash');
        const invoiceChangeElement = document.getElementById('invoiceChange');
        const invoiceCashRow = document.getElementById('invoiceCashRow');
        const invoiceChangeRow = document.getElementById('invoiceChangeRow');
        
        // API Configuration
        const API_BASE_URL = 'http://127.0.0.1:8000/api';
        const API_TOKEN = localStorage.getItem('token') || '';
        
        // Format currency input
        function formatCurrencyInput(value) {
            let num = value.replace(/[^0-9]/g, '');
            num = parseInt(num) || 0;
            return num.toLocaleString('id-ID');
        }

        // Parse currency input to number
        function parseCurrencyInput(value) {
            return parseInt(value.replace(/[^0-9]/g, '')) || 0;
        }

        // Format currency display
        function formatCurrency(num) {
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        // Kontrol tampilan dropdown
        function showMemberDropdown() {
            memberDropdownList.classList.remove('hidden');
        }

        function hideMemberDropdown() {
            memberDropdownList.classList.add('hidden');
        }

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
            let background = '#F97316';
            
            if (type === 'error') {
                icon = 'x-circle';
                background = '#EF4444';
            } else if (type === 'warning') {
                icon = 'alert-circle';
                background = '#F59E0B';
            } else if (type === 'info') {
                icon = 'info';
                background = '#3B82F6';
            }
            
            Toast.fire({
                iconHtml: `<i data-lucide="${icon}" class="text-white"></i>`,
                title: message,
                background: background,
                color: 'white',
                iconColor: 'white'
            });
            
            lucide.createIcons();
        }
        
        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Fungsi untuk menangani scan barcode
        async function handleBarcodeScan(barcode) {
            try {
                // Cari produk berdasarkan barcode
                const response = await fetch(`${API_BASE_URL}/products/barcode/${barcode}`, {
                    headers: getAuthHeaders()
                });
                
                if (!response.ok) throw new Error('Produk tidak ditemukan');
                
                const product = await response.json();
                
                // Cek stok produk
                if (product.quantity <= 0) {
                    showNotification('Stok produk habis', 'error');
                    return;
                }
                
                // Tambahkan ke keranjang
                const existingItem = cart.find(item => item.id === product.id);
                
                if (existingItem) {
                    if (existingItem.quantity + 1 > product.quantity) {
                        showNotification('Stok tidak mencukupi', 'error');
                        return;
                    }
                    existingItem.quantity += 1;
                    existingItem.subtotal = calculateItemSubtotal(existingItem);
                } else {
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        quantity: 1,
                        stock: product.quantity,
                        discount: 0,
                        subtotal: product.price
                    });
                }
                
                // Update tampilan keranjang
                updateCart();
                
                // Kosongkan input dan fokuskan kembali
                searchInput.value = '';
                searchInput.focus();
                
                // Beri feedback suara (opsional)
                playBeepSound();
                
                showNotification(`${product.name} ditambahkan ke keranjang`, 'success');
                
            } catch (error) {
                console.error('Error handling barcode scan:', error);
                showNotification('Produk tidak ditemukan', 'error');
                searchInput.focus();
            }
        }

        // Modifikasi event listener searchInput yang sudah ada
        searchInput.addEventListener('input', function(e) {
            const value = e.target.value.trim();
            const now = Date.now();
            const timeSinceLastChar = now - lastScanTime;
            
            // Clear timeout sebelumnya
            clearTimeout(scanTimeout);
            
            if (!value) return;
            
            // Deteksi apakah ini scan (input sangat cepat dan panjang)
            const isScan = value.length >= MIN_BARCODE_LENGTH && timeSinceLastChar < SCAN_THRESHOLD;
            
            if (isScan) {
                // Jika scan, langsung proses barcode
                handleBarcodeScan(value);
            } else {
                // Jika bukan scan, lakukan pencarian biasa dengan debounce
                scanTimeout = setTimeout(() => {
                    const activeCategory = document.querySelector('#categoryTabs .nav-link.active')?.getAttribute('data-category') || 'all';
                    renderProducts(activeCategory, value);
                }, 300);
            }
            
            lastScanTime = now;
        });

        // Tambahkan juga handler untuk keypress Enter (untuk scanner yang mengirim Enter)
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const value = e.target.value.trim();
                if (value.length >= MIN_BARCODE_LENGTH) {
                    e.preventDefault();
                    handleBarcodeScan(value);
                }
            }
        });
        // Fetch current shift
        async function fetchCurrentShift() {
            try {
                const response = await fetch(`${API_BASE_URL}/shifts/${outletInfo.shift_id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${API_TOKEN}`,
                        'Accept': 'application/json'
                    },
                    credentials: 'include'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success && data.data) {
                    outletInfo.shift_id = data.data.id;
                }
            } catch (error) {
                console.error('Error fetching current shift:', error);
            }
        }
        
        // Fetch outlet information
        async function fetchOutletInfo() {
            try {
                const response = await fetch(`${API_BASE_URL}/outlets/${outletInfo.id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${API_TOKEN}`,
                        'Accept': 'application/json'
                    },
                    credentials: 'include'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    outletInfo.tax = data.data.tax || 0;
                    outletInfo.qris = data.data.qris_url;
                    outletInfo.bank_account = {
                        atas_nama: data.data.atas_nama_bank,
                        bank: data.data.nama_bank,
                        nomor: data.data.nomor_transaksi_bank
                    };
                    
                    // Update tax display
                    taxAmountElement.textContent = `Pajak (${outletInfo.tax}%)`;
                    
                    // Get current shift
                    await fetchCurrentShift();
                }
            } catch (error) {
                console.error('Error fetching outlet info:', error);
            }
        }
    
        // Fetch products from API
        async function fetchProducts() {
            try {
                if (!API_TOKEN) {
                    throw new Error('Token tidak ditemukan');
                }
                
                const response = await fetch(`${API_BASE_URL}/products/outlet/${outletInfo.id}`, {
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
                    products = data.data.map(product => ({
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price),
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
                } else {
                    throw new Error(data.message || 'Failed to load products');
                }
            } catch (error) {
                console.error('Error fetching products:', error);
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
                // Di event listener tombol tambah ke keranjang
                button.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const productName = productCard.querySelector('.product-name').textContent.split(' (')[0];
                    const product = products.find(p => p.name === productName);
                    
                    if (!product) return;
                    
                    // Validasi stok
                    if (product.quantity <= 0) {
                        showNotification('Stok produk habis', 'error');
                        return;
                    }

                    const existingItem = cart.find(item => item.id === product.id);
                    
                    if (existingItem) {
                        if (existingItem.quantity + 1 > product.quantity) {
                            showNotification('Stok tidak mencukupi', 'error');
                            return;
                        }
                        existingItem.quantity += 1;
                        existingItem.subtotal = calculateItemSubtotal(existingItem);
                    } else {
                        cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            quantity: 1,
                            stock: product.quantity, // Simpan stok saat ini
                            discount: 0,
                            subtotal: product.price
                        });
                    }
                    
                    updateCart();
                });
            });
        }
        
        // Update cart display
        function updateCart() {
            cartItemsContainer.innerHTML = '';
            
            let rawSubtotal = 0;
            let totalDiscount = 0;
            let orderSubtotal = 0;
            let tax = 0;
            let grandTotal = 0;
            
            if (cart.length === 0) {
                emptyCartElement.classList.remove('hidden');
                cartItemsContainer.appendChild(emptyCartElement);
                subtotalElement.textContent = 'Rp 0';
                totalDiscountElement.textContent = 'Rp 0';
                taxAmountElement.textContent = 'Rp 0';
                totalElement.textContent = 'Rp 0';
                return;
            } else {
                emptyCartElement.classList.add('hidden');
            }
            
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                const itemDiscount = item.discount || 0;
                const itemSubtotal = itemTotal - itemDiscount;
                
                rawSubtotal += itemTotal;
                totalDiscount += itemDiscount;
                orderSubtotal += itemSubtotal;
                
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
                            <input type="text" class="discount-input" value="Rp ${item.discount.toLocaleString('id-ID')}" data-index="${index}" placeholder="Rp 0">
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
            
            // Calculate tax and grand total
            tax = orderSubtotal * (outletInfo.tax / 100);
            grandTotal = orderSubtotal + tax;
            
            subtotalElement.textContent = `Rp ${rawSubtotal.toLocaleString('id-ID')}`;
            totalDiscountElement.textContent = `Rp ${totalDiscount.toLocaleString('id-ID')}`;
            taxAmountElement.textContent = `Rp ${tax.toLocaleString('id-ID')}`;
            totalElement.textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
            
            lucide.createIcons();
            
            // Add event listeners to quantity controls
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
            
            // Di bagian event listener tombol tambah quantity
            document.querySelectorAll('.btn-increase').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const item = cart[index];
                    
                    if (item.quantity + 1 > item.stock) {
                        showNotification('Stok tidak mencukupi', 'error');
                        return;
                    }
                    
                    item.quantity += 1;
                    item.subtotal = calculateItemSubtotal(item);
                    updateCart();
                });
            });
            
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const newQty = parseInt(this.value) || 1;
                    const item = cart[index];

                            if (newQty > item.stock) {
            showNotification(`Stok hanya tersedia ${item.stock}`, 'error');
            this.value = item.quantity;
            return;
        }
                    cart[index].subtotal = calculateItemSubtotal(cart[index]);
                    updateCart();
                });
            });
            
            // Add event listeners to discount inputs
            document.querySelectorAll('.discount-input').forEach(input => {
                // Format on blur
                input.addEventListener('blur', function() {
                    const formattedValue = formatCurrencyInput(this.value);
                    this.value = formattedValue ? `Rp ${formattedValue}` : 'Rp 0';
                    
                    const index = parseInt(this.getAttribute('data-index'));
                    const discount = parseCurrencyInput(this.value);
                    cart[index].discount = discount;
                    cart[index].subtotal = calculateItemSubtotal(cart[index]);
                    updateCart();
                });
                
                // Remove formatting on focus for easier editing
                input.addEventListener('focus', function() {
                    const numValue = parseCurrencyInput(this.value);
                    this.value = numValue.toString();
                });
                
                // Handle change event
                input.addEventListener('change', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    const discount = parseCurrencyInput(this.value);
                    cart[index].discount = discount;
                    cart[index].subtotal = calculateItemSubtotal(cart[index]);
                    updateCart();
                });
            });
            
            document.querySelectorAll('.btn-remove').forEach(button => {
                button.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cart.splice(index, 1);
                    updateCart();
                });
            });
        }
        
        function calculateItemSubtotal(item) {
            const basePrice = item.price * item.quantity;
            const discountAmount = item.discount || 0;
            return Math.max(0, basePrice - discountAmount);
        }

        // Search members
        memberSearchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length < 2) {
                memberResultsContainer.innerHTML = '';
                hideMemberDropdown();
                return;
            }
            
            // Fetch from the main members endpoint
            fetch(`${API_BASE_URL}/members`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${API_TOKEN}`,
                    'Accept': 'application/json'
                },
                credentials: 'include'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    // Filter members based on the search query
                    const filteredMembers = data.data.filter(member => 
                        member.name.toLowerCase().includes(query.toLowerCase()) || 
                        (member.member_code && member.member_code.toLowerCase().includes(query.toLowerCase()))
                    );
                    
                    memberResultsContainer.innerHTML = '';
                    
                    if (filteredMembers.length > 0) {
                        filteredMembers.forEach(member => {
                            const memberItem = document.createElement('div');
                            memberItem.className = 'member-item';
                            memberItem.innerHTML = `
                                <div class="font-medium">${member.name}</div>
                                <div class="text-sm text-gray-500">${member.member_code || 'No Code'}</div>
                            `;
                            
                            memberItem.addEventListener('click', function() {
                                selectMember(member);
                                hideMemberDropdown();
                            });
                            
                            memberResultsContainer.appendChild(memberItem);
                        });
                        
                        showMemberDropdown();
                    } else {
                        memberResultsContainer.innerHTML = '<div class="member-item text-gray-500">Tidak ditemukan</div>';
                        showMemberDropdown();
                    }
                } else {
                    memberResultsContainer.innerHTML = '<div class="member-item text-gray-500">Tidak ditemukan</div>';
                    showMemberDropdown();
                }
            })
            .catch(error => {
                console.error('Error fetching members:', error);
                memberResultsContainer.innerHTML = '<div class="member-item text-gray-500">Terjadi kesalahan</div>';
                showMemberDropdown();
            });
        });
                
                // Select member
        function selectMember(member) {
            selectedMember = member;
            memberNameElement.textContent = `${member.name} (${member.member_code})`;
            selectedMemberContainer.classList.remove('hidden');
            memberSearchInput.value = '';
            hideMemberDropdown();
        }
                
                // Remove member
        removeMemberButton.addEventListener('click', function() {
            selectedMember = null;
            selectedMemberContainer.classList.add('hidden');
        });

        memberSearchInput.addEventListener('click', function() {
            if (this.value.trim().length >= 2) {
                showMemberDropdown();
            }
        });

        // Tampilkan dropdown ketika input mendapatkan fokus
        memberSearchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                showMemberDropdown();
            }
        });

        // Tutup dropdown ketika klik di luar dropdown
        document.addEventListener('click', function(event) {
            if (!memberSearchInput.contains(event.target) && !memberDropdownList.contains(event.target)) {
                hideMemberDropdown();
            }
        });

        // Navigasi dropdown dengan keyboard
        memberSearchInput.addEventListener('keydown', function(event) {
            const items = memberResultsContainer.querySelectorAll('.member-item');
            const activeItem = memberResultsContainer.querySelector('.member-item.active');
            
            if (items.length === 0) return;
            
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                
                if (!activeItem) {
                    items[0].classList.add('active');
                } else {
                    const nextItem = activeItem.nextElementSibling;
                    if (nextItem) {
                        activeItem.classList.remove('active');
                        nextItem.classList.add('active');
                    }
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                
                if (!activeItem) {
                    items[items.length - 1].classList.add('active');
                } else {
                    const prevItem = activeItem.previousElementSibling;
                    if (prevItem) {
                        activeItem.classList.remove('active');
                        prevItem.classList.add('active');
                    }
                }
            } else if (event.key === 'Enter') {
                if (activeItem) {
                    event.preventDefault();
                    
                    // Simulate click on the active item
                    activeItem.click();
                }
            } else if (event.key === 'Escape') {
                hideMemberDropdown();
            }
        });
        
        // Render payment methods
        function renderPaymentMethods() {
            paymentMethodsContainer.innerHTML = '';
            
            const methods = [
                { id: 'cash', name: 'Tunai', icon: 'wallet' },
                { id: 'qris', name: 'QRIS', icon: 'qr-code' },
                { id: 'transfer', name: 'Transfer Bank', icon: 'banknote' }
            ];
            
            methods.forEach(method => {
                const methodElement = document.createElement('div');
                methodElement.className = 'payment-method';
                methodElement.innerHTML = `
                    <div class="flex items-center">
                        <i data-lucide="${method.icon}" class="w-5 h-5 mr-3 text-gray-600"></i>
                        <span class="font-medium">${method.name}</span>
                    </div>
                `;
                
                methodElement.addEventListener('click', function() {
                    document.querySelectorAll('.payment-method').forEach(m => {
                        m.classList.remove('selected');
                    });
                    this.classList.add('selected');
                    document.getElementById('paymentMethod').value = method.id;
                    
                    // Handle cash section
                    if (method.id === 'cash') {
                        cashPaymentSection.style.display = 'block';
                        document.getElementById('transferDetails').classList.add('hidden');
                        document.getElementById('qrisDetails').classList.add('hidden');
                    } else {
                        cashPaymentSection.style.display = 'none';
                        amountReceivedInput.value = '';
                        changeAmountInput.value = '';
                    }
                    
                    // Handle transfer details
                    if (method.id === 'transfer') {
                        document.getElementById('transferDetails').classList.remove('hidden');
                        document.getElementById('qrisDetails').classList.add('hidden');
                        
                        document.getElementById('bankAccountName').textContent = 
                            outletInfo.bank_account?.atas_nama || '-';
                        document.getElementById('bankName').textContent = 
                            outletInfo.bank_account?.bank || '-';
                        document.getElementById('bankAccountNumber').textContent = 
                            outletInfo.bank_account?.nomor || '-';
                    } 
                    // Handle QRIS details
                    else if (method.id === 'qris') {
                        document.getElementById('transferDetails').classList.add('hidden');
                        document.getElementById('qrisDetails').classList.remove('hidden');
                        
                        const qrisContainer = document.getElementById('qrisImageContainer');
                        qrisContainer.innerHTML = '';
                        
                        if (outletInfo.qris) {
                            const img = document.createElement('img');
                            img.src = outletInfo.qris;
                            img.alt = 'QRIS Payment';
                            img.className = 'w-48 h-48 object-contain';
                            qrisContainer.appendChild(img);
                        } else {
                            qrisContainer.innerHTML = `
                                <div class="text-center py-8 text-gray-400">
                                    <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-2"></i>
                                    <p>QR Code tidak tersedia</p>
                                </div>
                            `;
                            lucide.createIcons();
                        }
                    } 
                    else {
                        document.getElementById('transferDetails').classList.add('hidden');
                        document.getElementById('qrisDetails').classList.add('hidden');
                    }
                });
                
                paymentMethodsContainer.appendChild(methodElement);
            });
            
            // Add hidden input for selected payment method
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.id = 'paymentMethod';
            methodInput.value = '';
            paymentMethodsContainer.appendChild(methodInput);
            
            lucide.createIcons();
        }

        function setupPaymentButton() {
            // Remove old event listener if it exists
            const btn = document.getElementById('btnProcessPayment');
            btn.removeEventListener('click', processPaymentHandler);
            
            // Add new event listener
            btn.addEventListener('click', processPaymentHandler);
        }
        
        // Show payment modal
        function showPaymentModal() {
            if (cart.length === 0) {
                showNotification('Keranjang belanja kosong', 'warning');
                return;
            }
            
            // Calculate totals
            const rawSubtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const totalDiscount = cart.reduce((sum, item) => sum + (item.discount || 0), 0);
            const orderSubtotal = rawSubtotal - totalDiscount;
            const tax = orderSubtotal * (outletInfo.tax / 100);
            const grandTotal = orderSubtotal + tax;
            
            // Update payment modal values
            // paymentSubtotalElement.textContent = formatCurrency(rawSubtotal);
            // paymentDiscountElement.textContent = formatCurrency(totalDiscount);
            // paymentTaxElement.textContent = formatCurrency(tax);
            paymentGrandTotalElement.textContent = formatCurrency(grandTotal);
            
            // Reset payment inputs
            amountReceivedInput.value = '';
            changeAmountInput.value = '';
            notesInput.value = '';
            
            // Render payment methods
            renderPaymentMethods();
            
            // Add event listener for amount received input
            amountReceivedInput.addEventListener('input', function() {
                const received = parseCurrencyInput(this.value);
                const change = received - grandTotal;
                
                if (change >= 0) {
                    changeAmountInput.value = formatCurrency(change);
                } else {
                    changeAmountInput.value = 'Rp 0';
                }
            });
            
            // CRITICAL FIX: Clone and replace the payment button to remove all event listeners
            const oldButton = document.getElementById('btnProcessPayment');
            const newButton = oldButton.cloneNode(true);
            oldButton.parentNode.replaceChild(newButton, oldButton);
            
            // Add the event listener to the fresh button
            document.getElementById('btnProcessPayment').addEventListener('click', function() {
                processPayment(grandTotal);
            });
            
            openModal('paymentModal');
        }
        
        async function processPayment(grandTotal) {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const amountReceived = parseCurrencyInput(amountReceivedInput.value);
            const notes = notesInput.value;
            
            if (!paymentMethod) {
                showNotification('Pilih metode pembayaran terlebih dahulu', 'warning');
                return;
            }
            
            if (paymentMethod === 'cash' && amountReceived < grandTotal) {
                showNotification('Jumlah uang tidak mencukupi', 'warning');
                return;
            }
            
            try {
                // Prepare transaction data
                const transactionData = {
                    outlet_id: outletInfo.id,
                    shift_id: outletInfo.shift_id,
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity,
                        discount: item.discount,
                        price: item.price
                    })),
                    payment_method: paymentMethod,
                    notes: notes,
                    tax: outletInfo.tax,
                    discount: cart.reduce((sum, item) => sum + (item.discount || 0), 0),
                    member_id: selectedMember ? selectedMember.id : null
                };
                
                // For cash payments, include amount received
                if (paymentMethod === 'cash') {
                    transactionData.total_paid = amountReceived;
                }
                
                // Send transaction to server
                const response = await fetch(`${API_BASE_URL}/orders`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${API_TOKEN}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(transactionData),
                    credentials: 'include'
                });
                
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('Payment response:', data); // Debugging
                
                if (data.success) {
                    // Simpan data transaksi ke variabel global
                    currentOrder = {
                        id: data.data.id, // Pastikan ini sesuai dengan struktur response API
                        items: cart,
                        payment_method: paymentMethod,
                        total: grandTotal,
                        data: data.data,
                        outlet: outletInfo  // Simpan seluruh data response
                    };
                    
                    // Debugging
                    console.log('Current order stored:', currentOrder);
                    
                    // Show invoice
                    showInvoice(data.data, amountReceived, paymentMethod);
                    
                    // Clear cart
                    cart = [];
                    updateCart();
                    
                    // Clear member
                    selectedMember = null;
                    selectedMemberContainer.classList.add('hidden');
                    
                    // Close payment modal
                    closeModal('paymentModal');
                } else {
                    throw new Error(data.message || 'Failed to process payment');
                }
            } catch (error) {
                console.error('Error processing payment:', error);
                showNotification(error.message || 'Gagal memproses pembayaran', 'error');
            }
        }
        
        // Show invoice
        function showInvoice(order, amountReceived, paymentMethod) {
            // Set invoice number and date
            // invoiceNumberElement.textContent = order.order_number;
            // invoiceDateElement.textContent = new Date(order.created_at).toLocaleString('id-ID');
            
            // // Show member if exists
            // if (order.member) {
            //     invoiceMemberElement.classList.remove('hidden');
            //     memberNameDisplayElement.textContent = order.member.name;
            //     memberCodeDisplayElement.textContent = order.member.member_code;
            // } else {
            //     invoiceMemberElement.classList.add('hidden');
            // }
            
            // // Clear previous items
            // invoiceItemsContainer.innerHTML = '';
            
            // // Add items to invoice
            // order.items.forEach(item => {
            //     const itemElement = document.createElement('tr');
            //     itemElement.className = 'border-b border-gray-200';
            //     itemElement.innerHTML = `
            //         <td class="py-2">${item.product}</td>
            //         <td class="py-2 text-right">${formatCurrency(item.price)}</td>
            //         <td class="py-2 text-right">${item.quantity}</td>
            //         <td class="py-2 text-right">${formatCurrency(item.discount)}</td>
            //         <td class="py-2 text-right">${formatCurrency(item.quantity * item.price - item.discount)}</td>
            //     `;
            //     invoiceItemsContainer.appendChild(itemElement);
            // });
            
            // // Set invoice totals
            // invoiceSubtotalElement.textContent = formatCurrency(order.subtotal);
            // invoiceDiscountElement.textContent = formatCurrency(order.discount);
            // invoiceTaxElement.textContent = formatCurrency(order.tax);
            // invoiceGrandTotalElement.textContent = formatCurrency(order.total);
            // invoicePaymentMethodElement.textContent = paymentMethod === 'cash' ? 'Tunai' : 
            //                                       paymentMethod === 'qris' ? 'QRIS' : 'Transfer Bank';
            
            // // Show/hide cash and change rows based on payment method
            // if (paymentMethod === 'cash') {
            //     invoiceCashRow.style.display = '';
            //     invoiceChangeRow.style.display = '';
            //     invoiceCashElement.textContent = formatCurrency(amountReceived);
            //     invoiceChangeElement.textContent = formatCurrency(order.change);
            // } else {
            //     invoiceCashRow.style.display = 'none';
            //     invoiceChangeRow.style.display = 'none';
            // }
            
            // Open invoice modal
            openModal('successPaymentModal');
        }
        
        // Print invoice
        function printInvoice() {
            window.print();
        }
        
        // Event listeners
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value;
            const activeCategory = document.querySelector('#categoryTabs .nav-link.active')?.getAttribute('data-category') || 'all';
            renderProducts(activeCategory, searchTerm);
        });
        
        document.getElementById('btnPaymentModal').addEventListener('click', showPaymentModal);
        
        // Initialize
        window.clearCart = function() {
            cart = [];
            updateCart();
            showNotification('Keranjang telah dikosongkan', 'info');
        };
        
        window.refreshProducts = function() {
            fetchProducts();
        };
        
        // Load data
        fetchOutletInfo();
        updateCart();
        loadProductsFromLocalStorage();
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

    //history-modal
    document.getElementById('btnHistoryModal').addEventListener('click', function() {
        openModal('historyModal');
        
    });

    document.getElementById('btnStockModal').addEventListener('click', function() {
        openModal('stockModal');
        
    });

    document.getElementById('btnIncomeModal').addEventListener('click', function() {
        openModal('incomeModal');
        
    });

    document.getElementById('btnCashierModal').addEventListener('click', function() {
        openModal('cashierModal');
        
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