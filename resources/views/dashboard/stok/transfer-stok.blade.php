@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Modal Transfer Stok -->
@include('partials.stok.modal-transfer-stock')

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok</h1>
       <div class="relative w-full md:w-64">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
        </span>
        <input type="text" id="searchInput" placeholder="Pencarian..."
            class="w-full pl-10 pr-4 py-3 border rounded-lg text-base font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
    </div>
    </div>
</div>

<!-- Card: Stok Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="package" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Daftar Stok Produk</h2>
            <p class="text-sm text-gray-600">Kelola stok produk di semua outlet Kifa Bakery.</p>
        </div>
    </div>
</div>

<!-- Card: Tabel Stok -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-semibold">SKU</th>
                    <th class="py-3 font-semibold">Produk</th>
                    <th class="py-3 font-semibold">Kategori</th>
                    <th class="py-3 font-semibold">Stok</th>
                    <th class="py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody id="productTableBody" class="text-gray-700 divide-y">
                <!-- Data will be loaded dynamically -->
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="loader" class="w-8 h-8 animate-spin"></i>
                            <span>Memuat data...</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan alert
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        // Warna dan ikon berdasarkan jenis alert
        const alertConfig = {
            success: {
                bgColor: 'bg-orange-50',
                borderColor: 'border-orange-200',
                textColor: 'text-orange-800',
                icon: 'check-circle',
                iconColor: 'text-orange-500'
            },
            error: {
                bgColor: 'bg-red-50',
                borderColor: 'border-red-200',
                textColor: 'text-red-800',
                icon: 'alert-circle',
                iconColor: 'text-red-500'
            }
        };
        
        const config = alertConfig[type] || alertConfig.success;
        
        const alertElement = document.createElement('div');
        alertElement.id = alertId;
        alertElement.className = `p-4 border rounded-lg shadow-sm ${config.bgColor} ${config.borderColor} ${config.textColor} flex items-start gap-3 animate-fade-in-up`;
        alertElement.innerHTML = `
            <i data-lucide="${config.icon}" class="w-5 h-5 mt-0.5 ${config.iconColor}"></i>
            <div class="flex-1">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <button onclick="closeAlert('${alertId}')" class="p-1 rounded-full hover:bg-gray-100">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;
        
        alertContainer.prepend(alertElement);
        
        // Inisialisasi ikon Lucide
        if (window.lucide) {
            window.lucide.createIcons();
        }
        
        // Auto close setelah 5 detik
        setTimeout(() => {
            closeAlert(alertId);
        }, 5000);
    }

    // Fungsi untuk menutup alert
    function closeAlert(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.classList.add('animate-fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }

    // Fungsi untuk memuat data outlet
    async function loadOutlets() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/outlets', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Gagal memuat data outlet');
            }
            
            return result.data;
        } catch (error) {
            console.error('Error loading outlets:', error);
            showAlert('error', 'Gagal memuat data outlet');
            return [];
        }
    }

    // Fungsi untuk membuka modal transfer
    async function openModalTransfer(productId, sku, produk, outletId, outletName, stok) {
        const modal = document.getElementById('modalTransferStock');
        
        // Set data ke form
        document.getElementById('productId').value = productId;
        document.getElementById('transferSku').textContent = sku;
        document.getElementById('transferProduk').textContent = produk;
        document.getElementById('stokTersedia').textContent = stok;
        document.getElementById('stokTersediaLabel').textContent = stok;
        document.getElementById('outletAsal').textContent = outletName;
        document.getElementById('sourceOutletId').value = outletId;
        document.getElementById('jumlahTransfer').max = stok;
        document.getElementById('jumlahTransfer').value = '';
        document.getElementById('catatanTransfer').value = '';
        
        // Load dan isi dropdown outlet tujuan
        const outlets = await loadOutlets();
        const outletSelect = document.getElementById('tujuanTransfer');
        
        // Kosongkan dropdown kecuali option pertama
        while (outletSelect.options.length > 1) {
            outletSelect.remove(1);
        }
        
        // Tambahkan outlet yang tersedia (kecuali outlet asal)
        outlets.forEach(outlet => {
            if (outlet.id != outletId) {
                const option = document.createElement('option');
                option.value = outlet.id;
                option.textContent = outlet.name;
                outletSelect.appendChild(option);
            }
        });
        
        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModalTransfer() {
        const modal = document.getElementById('modalTransferStock');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Fungsi untuk menutup modal transfer
    async function submitTransfer() {
        const productId = document.getElementById('productId').value;
        const sourceOutletId = document.getElementById('sourceOutletId').value;
        const targetOutletId = document.getElementById('tujuanTransfer').value;
        const quantity = document.getElementById('jumlahTransfer').value;
        const notes = document.getElementById('catatanTransfer').value;
        const userId = localStorage.getItem('user_id'); // Asumsikan user_id disimpan di localStorage saat login
        
        if (!quantity || quantity <= 0) {
            showAlert('error', 'Jumlah transfer harus lebih dari 0');
            return;
        }
        
        if (!targetOutletId) {
            showAlert('error', 'Silakan pilih tujuan transfer');
            return;
        }
        
        if (sourceOutletId === targetOutletId) {
            showAlert('error', 'Outlet tujuan harus berbeda dengan outlet asal');
            return;
        }
        
        try {
            const response = await fetch('http://127.0.0.1:8000/api/inventories/transfer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({
                    product_id: productId,
                    source_outlet_id: sourceOutletId,
                    target_outlet_id: targetOutletId,
                    quantity: quantity,
                    user_id: userId,
                    notes: notes
                })
            });
            
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Gagal melakukan transfer');
            }
            
            closeModalTransfer();
            showAlert('success', 'Transfer stok berhasil dilakukan');
            
            // Refresh data stok
            loadProductData();
        } catch (error) {
            console.error('Transfer error:', error);
            showAlert('error', error.message || 'Gagal melakukan transfer');
        }
    }

    function validateTransferAmount(input) {
        const max = parseInt(input.max);
        const value = parseInt(input.value);
        
        if (value > max) {
            input.value = max;
            showAlert('warning', `Jumlah transfer melebihi stok tersedia. Diubah menjadi ${max}`);
        }
    }

    // Mendapatkan ikon berdasarkan kategori produk
    function getCategoryIcon(categoryName) {
        const icons = {
            'Roti Manis': 'croissant',
            'Kue Basah': 'cake',
            'Kue Kering': 'cookie',
            'Pastry': 'pizza',
            'Minuman': 'coffee'
        };
        
        return icons[categoryName] || 'package';
    }

    // Fungsi untuk memuat data dari API
    async function loadProductData() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/products/outlet/1', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Gagal memuat data');
            }

            const outletId = result.outlet_id || 1; // Default ke 1 jika tidak ada
        const outletName = result.outlet_name || 'Outlet 1'; // Default jika tidak ada
            
            renderProductTable(result.data, outletId, outletName);
        } catch (error) {
            console.error('Error loading data:', error);
            document.getElementById('productTableBody').innerHTML = `
                <tr>
                    <td colspan="5" class="py-4 text-center text-red-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="alert-triangle" class="w-8 h-8"></i>
                            <span>Gagal memuat data. ${error.message}</span>
                        </div>
                    </td>
                </tr>
            `;
            
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
    }

    // Fungsi untuk menampilkan data produk ke tabel
    function renderProductTable(products, outletId, outletName) {
        const tableBody = document.getElementById('productTableBody');
        
        if (!products || products.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="package-x" class="w-8 h-8"></i>
                            <span>Tidak ada data produk</span>
                        </div>
                    </td>
                </tr>
            `;
            
            if (window.lucide) {
                window.lucide.createIcons();
            }
            return;
        }
        
        let tableContent = '';
        
        products.forEach(product => {
            // Cek apakah produk aktif
            if (!product.is_active) return; // Skip produk tidak aktif
            
            const categoryIcon = getCategoryIcon(product.category.name);
            const isLowStock = product.quantity <= product.min_stock;
            const stockClass = isLowStock ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700';
            
            tableContent += `
                <tr>
                    <td class="py-4 font-medium">${product.sku}</td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="${categoryIcon}" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <span>${product.name}</span>
                        </div>
                    </td>
                    <td class="py-4">${product.category.name}</td>
                    <td class="py-4">
                        <div class="flex flex-col">
                            <span class="px-3 py-1.5 text-sm font-medium ${stockClass} rounded-full w-fit">${product.quantity}</span>
                            <span class="text-xs text-gray-500 mt-1">Min: ${product.min_stock}</span>
                        </div>
                    </td>
                    <td class="py-4">
                        <button onclick="openModalTransfer('${product.id}', '${product.sku}', '${product.name}', ${outletId}, '${outletName}', ${product.quantity})" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4"></i> Transfer
                        </button>
                    </td>
                </tr>
            `;
        });
        
        tableBody.innerHTML = tableContent;
        
        // Inisialisasi ikon Lucide
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    // Fungsi pencarian produk
    function setupSearch() {
        const searchInput = document.getElementById('searchInput');
        
        searchInput.addEventListener('input', async function() {
            try {
                const searchTerm = this.value.toLowerCase().trim();
                const response = await fetch('http://127.0.0.1:8000/api/products/outlet/1');
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Gagal memuat data');
                }
                
                // Filter produk berdasarkan pencarian
                const filteredProducts = result.data.filter(product => 
                    product.name.toLowerCase().includes(searchTerm) || 
                    product.sku.toLowerCase().includes(searchTerm) ||
                    product.category.name.toLowerCase().includes(searchTerm)
                );
                
                renderProductTable(filteredProducts);
            } catch (error) {
                console.error('Error searching data:', error);
                showAlert('error', 'Gagal melakukan pencarian');
            }
        });
    }

    // Event listener untuk tombol di modal
    document.getElementById('btnBatalTransfer')?.addEventListener('click', closeModalTransfer);
    document.getElementById('btnSubmitTransfer')?.addEventListener('click', submitTransfer);
    
    // Load data saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        loadProductData();
        setupSearch();
    });
</script>

<style>
    /* Animasi untuk alert */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(10px);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
    
    .animate-fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
</style>

@endsection