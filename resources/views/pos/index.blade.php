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
                        <i class="fas fa-user mr-2 text-orange-500 text-base"></i> <span class="font-medium">Kasir (kasir)</span>
                    </button>

                    <button class="px-3 py-1.5 text-sm text-black font-bold border border-orange-300 rounded-md hover:bg-orange-100 transition-colors">
                        <i class="fas fa-sign-out-alt mr-1.5 text-orange-500 text-lg"></i>
                    </button>

                </div>
            </div>
        </nav>



        <div class="main-container flex h-[calc(100vh-68px)] overflow-hidden">
            <!-- Products Section (made slightly narrower) -->
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
                            <li class="inline-flex">
                                <a href="#" data-category="all" class="nav-link active px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-orange-500 text-white border border-orange-400 shadow-sm transition-all duration-200">Semua</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="cake" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">CAKE</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="roti" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">ROTI</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="tart" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">TART</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="umum" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">UMUM</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="kemasan" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">KEMASAN</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="perlengkapan" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">PERLENGKAPAN</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="minuman" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">MINUMAN</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="kns" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">KNS</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="paket" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">PAKET</a>
                            </li>
                            <li class="inline-flex">
                                <a href="#" data-category="spesial" class="nav-link px-3 py-1.5 text-xs font-medium rounded-full mr-2 bg-white text-gray-700 border border-gray-200 hover:bg-gray-100 hover:shadow transition-all duration-200">SPESIAL</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <hr class="border-t border-orange-500 opacity-30 my-0">

                <!-- Products List -->
                <div id="productsContainer" class="flex-1 overflow-y-auto p-4">
                    <!-- Produk Bolu Pisang -->
                    <div class="product-item mb-3" data-category="cake" data-name="bolu pisang">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Bolu Pisang (20)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 17.500</div>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">CAKE</span>
                                <button class="btn-add-to-cart bg-orange-500 text-white border-none rounded px-4 py-2 text-sm flex items-center justify-center w-24 hover:bg-orange-600 transition-colors">
                                    <i class="fas fa-plus text-sm mr-2"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Meses -->
                    <div class="product-item mb-3" data-category="cake" data-name="bolu meses">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Bolu Meses (1)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 16.500</div>
                                <span class="low-stock bg-yellow-100 px-2 py-1 rounded text-sm text-yellow-800 font-medium mt-1 inline-block">Produk menipis</span>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">CAKE</span>
                                <button class="btn-add-to-cart bg-orange-500 text-white border-none rounded px-4 py-2 text-sm flex items-center justify-center w-24 hover:bg-orange-600 transition-colors">
                                    <i class="fas fa-plus text-sm mr-2"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Kismis -->
                    <div class="product-item mb-3" data-category="cake" data-name="bolu kismis">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Bolu Kismis (0)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 20.000</div>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">CAKE</span>
                                <button class="bg-gray-100 text-gray-500 border border-gray-300 rounded px-4 py-2 text-sm w-24">Habis</button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Keju Meses -->
                    <div class="product-item mb-3" data-category="cake" data-name="bolu keju meses">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Bolu Keju Meses (0)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 25.000</div>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">CAKE</span>
                                <button class="bg-gray-100 text-gray-500 border border-gray-300 rounded px-4 py-2 text-sm w-24">Habis</button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Lapis Talas -->
                    <div class="product-item mb-3" data-category="cake" data-name="bolu lapis talas">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Bolu Lapis Talas (0)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 30.000</div>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">CAKE</span>
                                <button class="bg-gray-100 text-gray-500 border border-gray-300 rounded px-4 py-2 text-sm w-24">Habis</button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Cake Harmoni -->
                    <div class="product-item mb-3" data-category="cake" data-name="cake harmoni">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Cake Harmoni (0)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 23.500</div>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">CAKE</span>
                                <button class="bg-gray-100 text-gray-500 border border-gray-300 rounded px-4 py-2 text-sm w-24">Habis</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional products -->
                    <div class="product-item mb-3" data-category="roti" data-name="roti tawar">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Roti Tawar (15)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 12.000</div>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">ROTI</span>
                                <button class="btn-add-to-cart bg-orange-500 text-white border-none rounded px-4 py-2 text-sm flex items-center justify-center w-24 hover:bg-orange-600 transition-colors">
                                    <i class="fas fa-plus text-sm mr-2"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="product-item mb-3" data-category="roti" data-name="roti coklat">
                        <div class="product-card flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition-all">
                            <div>
                                <div class="product-name text-base font-medium">Roti Coklat (8)</div>
                                <div class="product-price text-orange-500 font-semibold text-base">Rp 15.000</div>
                                <span class="low-stock bg-yellow-100 px-2 py-1 rounded text-sm text-yellow-800 font-medium mt-1 inline-block">Produk menipis</span>
                            </div>
                            <div class="flex items-center">
                                <span class="product-category text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full mr-3">ROTI</span>
                                <button class="btn-add-to-cart bg-orange-500 text-white border-none rounded px-4 py-2 text-sm flex items-center justify-center w-24 hover:bg-orange-600 transition-colors">
                                    <i class="fas fa-plus text-sm mr-2"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Section (made slightly wider) -->
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

                <div id="cartItems" class="flex-1 overflow-y-auto">
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
            
            // Initialize cart
            let cart = [];
            
            // DOM elements
            const searchInput = document.getElementById('searchInput');
            const categoryTabs = document.querySelectorAll('#categoryTabs .nav-link');
            const productsContainer = document.getElementById('productsContainer');
            const productItems = document.querySelectorAll('.product-item');
            const cartItemsContainer = document.getElementById('cartItems');
            const emptyCartElement = document.getElementById('emptyCart');
            const subtotalElement = document.getElementById('subtotal');
            const totalElement = document.getElementById('total');
            const btnAddToCart = document.querySelectorAll('.btn-add-to-cart');
            
            // Modal buttons
            const btnCashierModal = document.getElementById('btnCashierModal');
            const btnHistoryModal = document.getElementById('btnHistoryModal');
            const btnIncomeModal = document.getElementById('btnIncomeModal');
            const btnPaymentModal = document.getElementById('btnPaymentModal');
            const btnStockModal = document.getElementById('btnStockModal');
            
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
            
            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                productItems.forEach(item => {
                    const productName = item.getAttribute('data-name').toLowerCase();
                    if (productName.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
            
            // Category filter functionality
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active tab
                    categoryTabs.forEach(t => t.classList.remove('active', 'bg-orange-500', 'text-white', 'border-orange-500'));
                    this.classList.add('active', 'bg-orange-500', 'text-white', 'border-orange-500');
                    
                    const category = this.getAttribute('data-category');
                    
                    // Filter products
                    productItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');
                        
                        if (category === 'all' || itemCategory === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
            
            // Add to cart functionality
            btnAddToCart.forEach(button => {
                button.addEventListener('click', function() {
                    const productCard = this.closest('.product-card');
                    const productName = productCard.querySelector('.product-name').textContent.split(' (')[0];
                    const productPriceText = productCard.querySelector('.product-price').textContent;
                    const productPrice = parseInt(productPriceText.replace('Rp ', '').replace('.', ''));
                    
                    // Check if product already in cart
                    const existingItem = cart.find(item => item.name === productName);
                    
                    if (existingItem) {
                        existingItem.quantity += 1;
                        existingItem.subtotal = existingItem.quantity * existingItem.price;
                    } else {
                        cart.push({
                            name: productName,
                            price: productPrice,
                            quantity: 1,
                            discount: 0,
                            subtotal: productPrice
                        });
                    }
                    
                    updateCart();
                    showNotification(`${productName} telah ditambahkan ke keranjang`);
                });
            });
            
            // Update cart display
            function updateCart() {
                // Clear cart items
                cartItemsContainer.innerHTML = '';
                
                let subtotal = 0;
                
                // Show empty cart if no items
                if (cart.length === 0) {
                    cartItemsContainer.appendChild(emptyCartElement);
                    subtotalElement.textContent = 'Rp 0';
                    totalElement.textContent = 'Rp 0';
                    return;
                }
                
                // Add each item to cart
                cart.forEach((item, index) => {
                    subtotal += item.subtotal;
                    
                    const cartItemElement = document.createElement('div');
                    cartItemElement.className = 'cart-item p-4 border-b border-gray-100 hover:bg-gray-50';
                    cartItemElement.innerHTML = `
                        <div class="grid grid-cols-12 items-center">
                            <div class="col-span-5">
                                <div class="cart-item-name text-base font-medium">${item.name}</div>
                                <div class="cart-item-price text-sm text-gray-600 mt-1">Rp ${item.price.toLocaleString('id-ID')}</div>
                            </div>
                            <div class="col-span-3">
                                <div class="qty-control flex items-center justify-center">
                                    <button class="btn-decrease px-2 py-1 border border-gray-300 bg-gray-100 rounded flex items-center justify-center w-8 h-8 hover:bg-gray-200" data-index="${index}">
                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                    </button>
                                    <input type="text" class="qty-input w-12 text-center border border-gray-300 h-8 mx-1.5 rounded" value="${item.quantity}" data-index="${index}">
                                    <button class="btn-increase px-2 py-1 border border-gray-300 bg-gray-100 rounded flex items-center justify-center w-8 h-8 hover:bg-gray-200" data-index="${index}">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-2 text-center">
                                <input type="text" class="discount-input w-14 text-center border border-gray-300 h-8 rounded" value="${item.discount}" data-index="${index}">
                            </div>
                            <div class="col-span-1 text-right pr-3">
                                <div class="subtotal-price text-base font-semibold whitespace-nowrap">Rp ${item.subtotal.toLocaleString('id-ID')}</div>
                            </div>
                            <div class="col-span-1 text-right">
                                <button class="delete-btn btn-remove text-gray-500 bg-transparent border-none w-8 h-8 rounded flex items-center justify-center hover:bg-gray-100 hover:text-red-500" data-index="${index}">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    
                    cartItemsContainer.appendChild(cartItemElement);
                });
                
                // Update subtotal and total
                subtotalElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
                totalElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
                
                // Refresh Lucide icons
                lucide.createIcons();
                
                // Add event listeners to quantity controls
                document.querySelectorAll('.btn-decrease').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        if (cart[index].quantity > 1) {
                            cart[index].quantity -= 1;
                            cart[index].subtotal = cart[index].quantity * cart[index].price;
                            updateCart();
                        }
                    });
                });
                
                document.querySelectorAll('.btn-increase').forEach(button => {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        cart[index].quantity += 1;
                        cart[index].subtotal = cart[index].quantity * cart[index].price;
                        updateCart();
                    });
                });
                
                document.querySelectorAll('.qty-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const newQty = parseInt(this.value) || 1;
                        cart[index].quantity = newQty;
                        cart[index].subtotal = cart[index].quantity * cart[index].price;
                        updateCart();
                    });
                });
                
                document.querySelectorAll('.discount-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const discount = parseInt(this.value) || 0;
                        cart[index].discount = discount;
                        // Here you would need to adjust the subtotal calculation to include discount
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
            
            // Initialize with empty cart
            updateCart();
        });
    </script>
</body>
</html>