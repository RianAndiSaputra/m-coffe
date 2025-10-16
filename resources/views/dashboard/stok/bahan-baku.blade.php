@extends('layouts.app')

@section('title', 'Manajemen Bahan Baku')

@section('content')
<!-- Notification container -->
<div id="alertContainer" class="fixed top-4 right-4 z-[1000] space-y-3 w-80">
    <!-- Alerts will appear here dynamically -->
</div>

<!-- Include Modals -->
@include('partials.stok.bahan-baku.modal-konfirmasi-hapus')
@include('partials.stok.bahan-baku.modal-tambah-bahan-baku')
@include('partials.stok.bahan-baku.modal-edit-bahan-baku')

<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Bahan Baku</h1>
            <p class="text-gray-600 mt-1">Kelola semua bahan baku untuk produksi minuman</p>
        </div>
        <button id="btnTambahBahanBaku" class="mt-4 md:mt-0 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Bahan Baku
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Bahan Baku</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalBahanBaku">0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Investasi</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalInvestasi">Rp 0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Stok Menipis</p>
                    <p class="text-2xl font-bold text-gray-800" id="stokMenipis">0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Bahan Aktif</p>
                    <p class="text-2xl font-bold text-gray-800" id="bahanAktif">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-col md:flex-row md:items-center gap-4 flex-1">
                <div class="relative flex-1 md:max-w-xs">
                    <input type="text" id="searchBahanBaku" placeholder="Cari bahan baku..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select id="filterKategori" class="border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                    <option value="">Semua Kategori</option>
                    <option value="kopi">Biji Kopi</option>
                    <option value="susu">Produk Susu</option>
                    <option value="gula">Pemanis</option>
                    <option value="sirup">Sirup & Flavor</option>
                    <option value="topping">Topping</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <select id="filterStatus" class="border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <button id="btnExport" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Bahan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Satuan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Beli</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bahanBakuTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <p class="text-lg font-medium mb-2">Belum ada bahan baku</p>
                                <p class="text-sm mb-4">Mulai dengan menambahkan bahan baku pertama Anda</p>
                                <button id="btnTambahPertama" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                                    + Tambah Bahan Baku Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-6 gap-4">
        <div class="text-sm text-gray-600">
            Menampilkan <span id="showingFrom">0</span> - <span id="showingTo">0</span> dari <span id="totalItems">0</span> bahan baku
        </div>
        <div class="flex gap-2" id="paginationContainer">
            <!-- Pagination buttons will be added here -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample data - replace with actual data from your backend
    let bahanBakuData = [
        {
            id: 1,
            name: 'Biji Kopi Arabica',
            category: 'kopi',
            stock: 5.5,
            unit: 'kg',
            buy_price: 120000,
            min_stock: 1,
            is_active: true,
            supplier: 'Supplier A',
            sku: 'BBK001'
        },
        {
            id: 2,
            name: 'Susu Segar',
            category: 'susu',
            stock: 12,
            unit: 'l',
            buy_price: 25000,
            min_stock: 5,
            is_active: true,
            supplier: 'Supplier B',
            sku: 'BBS002'
        },
        {
            id: 3,
            name: 'Gula Pasir',
            category: 'gula',
            stock: 8.2,
            unit: 'kg',
            buy_price: 15000,
            min_stock: 3,
            is_active: true,
            supplier: 'Supplier C',
            sku: 'BBG003'
        }
    ];

    // Initialize the page
    initializePage();

    function initializePage() {
        updateStats();
        renderTable();
        setupEventListeners();
    }

    function updateStats() {
        const totalBahanBaku = bahanBakuData.length;
        const totalInvestasi = bahanBakuData.reduce((sum, item) => sum + (item.buy_price * item.stock), 0);
        const stokMenipis = bahanBakuData.filter(item => item.stock <= item.min_stock).length;
        const bahanAktif = bahanBakuData.filter(item => item.is_active).length;

        document.getElementById('totalBahanBaku').textContent = totalBahanBaku;
        document.getElementById('totalInvestasi').textContent = formatRupiah(totalInvestasi);
        document.getElementById('stokMenipis').textContent = stokMenipis;
        document.getElementById('bahanAktif').textContent = bahanAktif;
    }

    function renderTable(data = bahanBakuData) {
        const tbody = document.getElementById('bahanBakuTableBody');
        
        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p class="text-lg font-medium mb-2">Tidak ada bahan baku ditemukan</p>
                            <p class="text-sm">Coba ubah filter pencarian Anda</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        data.forEach(item => {
            const statusClass = item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            const statusText = item.is_active ? 'Aktif' : 'Nonaktif';
            const stokWarning = item.stock <= item.min_stock ? 'text-red-600 font-semibold' : 'text-gray-600';
            
            html += `
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${item.name}</div>
                                <div class="text-sm text-gray-500">${item.sku}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${getCategoryName(item.category)}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm ${stokWarning}">${item.stock} ${item.unit}</div>
                        ${item.stock <= item.min_stock ? '<div class="text-xs text-red-500">Stok menipis!</div>' : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.unit}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${formatRupiah(item.buy_price)}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <button class="text-blue-600 hover:text-blue-900 edit-btn" data-id="${item.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-900 delete-btn" data-id="${item.id}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        attachTableEventListeners();
    }

    function getCategoryName(category) {
        const categories = {
            'kopi': 'Biji Kopi',
            'susu': 'Produk Susu',
            'gula': 'Pemanis',
            'sirup': 'Sirup & Flavor',
            'topping': 'Topping',
            'lainnya': 'Lainnya'
        };
        return categories[category] || category;
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    function setupEventListeners() {
        // Tambah bahan baku buttons
        document.getElementById('btnTambahBahanBaku').addEventListener('click', showTambahModal);
        document.getElementById('btnTambahPertama').addEventListener('click', showTambahModal);

        // Search and filter
        document.getElementById('searchBahanBaku').addEventListener('input', handleSearch);
        document.getElementById('filterKategori').addEventListener('change', handleFilter);
        document.getElementById('filterStatus').addEventListener('change', handleFilter);

        // Export button
        document.getElementById('btnExport').addEventListener('click', handleExport);
    }

    function attachTableEventListeners() {
        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                showEditModal(id);
            });
        });

        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                showDeleteModal(id);
            });
        });
    }

    function showTambahModal() {
        // This will be handled by the modal partial
        const modal = document.getElementById('modalTambahBahanBaku');
        modal.classList.remove('hidden');
    }

    function showEditModal(id) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            // This will be handled by the modal partial
            const modal = document.getElementById('modalEditBahanBaku');
            // Populate form with item data
            document.getElementById('editBahanBakuId').value = item.id;
            document.getElementById('editNama').value = item.name;
            document.getElementById('editSku').value = item.sku;
            document.getElementById('editKategori').value = item.category;
            document.getElementById('editStok').value = item.stock;
            document.getElementById('editSatuan').value = item.unit;
            document.getElementById('editHargaBeli').value = item.buy_price;
            document.getElementById('editStokMinimum').value = item.min_stock;
            document.getElementById('editSupplier').value = item.supplier;
            document.getElementById('editStatus').value = item.is_active ? '1' : '0';
            
            modal.classList.remove('hidden');
        }
    }

    function showDeleteModal(id) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            const modal = document.getElementById('modalKonfirmasiHapus');
            document.getElementById('hapusItemId').value = id;
            document.getElementById('hapusItemName').textContent = item.name;
            modal.classList.remove('hidden');
        }
    }

    function handleSearch() {
        const searchTerm = document.getElementById('searchBahanBaku').value.toLowerCase();
        const filteredData = bahanBakuData.filter(item => 
            item.name.toLowerCase().includes(searchTerm) ||
            item.sku.toLowerCase().includes(searchTerm)
        );
        renderTable(filteredData);
    }

    function handleFilter() {
        const categoryFilter = document.getElementById('filterKategori').value;
        const statusFilter = document.getElementById('filterStatus').value;
        
        let filteredData = bahanBakuData;

        if (categoryFilter) {
            filteredData = filteredData.filter(item => item.category === categoryFilter);
        }

        if (statusFilter) {
            const isActive = statusFilter === 'active';
            filteredData = filteredData.filter(item => item.is_active === isActive);
        }

        renderTable(filteredData);
    }

    function handleExport() {
        // Implement export functionality
        showNotification('Fitur export akan segera tersedia', 'info');
    }

    function showNotification(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const typeConfig = {
            success: { bg: 'bg-green-500', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
            error: { bg: 'bg-red-500', icon: 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
            warning: { bg: 'bg-yellow-500', icon: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' },
            info: { bg: 'bg-blue-500', icon: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }
        };

        const config = typeConfig[type] || typeConfig.info;

        const alertHTML = `
            <div id="${alertId}" class="${config.bg} text-white p-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${config.icon}"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            </div>
        `;

        alertContainer.insertAdjacentHTML('beforeend', alertHTML);

        // Remove alert after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    }

    // Global functions for modals to call
    window.hapusBahanBaku = function() {
        const id = document.getElementById('hapusItemId').value;
        bahanBakuData = bahanBakuData.filter(item => item.id != id);
        updateStats();
        renderTable();
        showNotification('Bahan baku berhasil dihapus', 'success');
    };

    window.simpanBahanBaku = function(formData) {
        const newId = Math.max(...bahanBakuData.map(item => item.id)) + 1;
        const newItem = {
            id: newId,
            name: formData.name,
            category: formData.category,
            stock: parseFloat(formData.stock),
            unit: formData.unit,
            buy_price: parseInt(formData.buy_price),
            min_stock: parseFloat(formData.min_stock),
            is_active: formData.is_active === '1',
            supplier: formData.supplier,
            sku: formData.sku
        };
        
        bahanBakuData.push(newItem);
        updateStats();
        renderTable();
        showNotification('Bahan baku berhasil ditambahkan', 'success');
    };

    window.updateBahanBaku = function(formData) {
        const id = parseInt(formData.id);
        const index = bahanBakuData.findIndex(item => item.id === id);
        
        if (index !== -1) {
            bahanBakuData[index] = {
                ...bahanBakuData[index],
                name: formData.name,
                category: formData.category,
                stock: parseFloat(formData.stock),
                unit: formData.unit,
                buy_price: parseInt(formData.buy_price),
                min_stock: parseFloat(formData.min_stock),
                is_active: formData.is_active === '1',
                supplier: formData.supplier,
                sku: formData.sku
            };
            
            updateStats();
            renderTable();
            showNotification('Bahan baku berhasil diperbarui', 'success');
        }
    };
});
</script>
@endsection