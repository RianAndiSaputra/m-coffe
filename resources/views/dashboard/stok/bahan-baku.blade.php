@extends('layouts.app')

@section('title', 'Manajemen Bahan Baku')

@section('content')
<!-- Notification container -->
<div id="alertContainer" class="fixed top-4 right-4 z-[1000] space-y-3 w-80">
    <!-- Alerts will appear here dynamically -->
</div>

<!-- Include Modals -->
@include('partials.stok.modal-konfirmasi-hapus')
@include('partials.stok.modal-tambah-bahan-baku')
@include('partials.stok.modal-tambah-stok')
@include('partials.stok.modal-riwayat-stok')

<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Bahan Baku</h1>
            <p class="text-gray-600 mt-1">Kelola semua bahan baku dengan sistem average cost</p>
        </div>
        <button id="btnTambahBahanBaku" class="mt-4 md:mt-0 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Bahan Baku
        </button>
    </div>

    <!-- Card: Outlet Info -->
    <div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="mb-3 md:mb-0 flex items-start gap-2">
            <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
            <div>
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 outlet-name">Outlet Aktif: Loading...</h2>
                <p class="text-sm text-gray-600 outlet-address">Memuat data outlet...</p>
            </div>
        </div>
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
                    <p class="text-sm text-gray-600">Harga Rata-rata</p>
                    <p class="text-2xl font-bold text-gray-800" id="hargaRataRata">Rp 0</p>
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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga Rata-rata</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Nilai</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="bahanBakuTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample data dengan sistem average cost
    let bahanBakuData = [
        {
            id: 1,
            name: 'Biji Kopi Arabica',
            category: 'kopi',
            stock: 8.5,
            unit: 'kg',
            min_stock: 2,
            is_active: true,
            supplier: 'Supplier A',
            code: 'BBK001',
            batches: [
                { id: 1, jumlah: 5, harga_beli: 120000, tanggal_masuk: '2024-01-10', sisa_stok: 3.5 },
                { id: 2, jumlah: 3, harga_beli: 125000, tanggal_masuk: '2024-01-15', sisa_stok: 3 },
                { id: 3, jumlah: 2, harga_beli: 130000, tanggal_masuk: '2024-01-20', sisa_stok: 2 }
            ]
        },
        {
            id: 2,
            name: 'Susu Segar',
            category: 'susu',
            stock: 15,
            unit: 'l',
            min_stock: 5,
            is_active: true,
            supplier: 'Supplier B',
            code: 'BBS002',
            batches: [
                { id: 1, jumlah: 10, harga_beli: 25000, tanggal_masuk: '2024-01-12', sisa_stok: 5 },
                { id: 2, jumlah: 8, harga_beli: 26000, tanggal_masuk: '2024-01-18', sisa_stok: 8 },
                { id: 3, jumlah: 2, harga_beli: 25500, tanggal_masuk: '2024-01-22', sisa_stok: 2 }
            ]
        },
        {
            id: 3,
            name: 'Gula Pasir',
            category: 'gula',
            stock: 12.2,
            unit: 'kg',
            min_stock: 3,
            is_active: true,
            supplier: 'Supplier C',
            code: 'BBG003',
            batches: [
                { id: 1, jumlah: 8, harga_beli: 15000, tanggal_masuk: '2024-01-08', sisa_stok: 4.2 },
                { id: 2, jumlah: 5, harga_beli: 15500, tanggal_masuk: '2024-01-16', sisa_stok: 5 },
                { id: 3, jumlah: 3, harga_beli: 15200, tanggal_masuk: '2024-01-25', sisa_stok: 3 }
            ]
        }
    ];

    // Initialize the page
    initializePage();

    function initializePage() {
        updateOutletInfo();
        updateStats();
        renderTable();
        setupEventListeners();
    }

    // ============================
    // OUTLET MANAGEMENT FUNCTIONS
    // ============================

    // Function to get currently selected outlet ID
    function getSelectedOutletId() {
        // First check URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const outletIdFromUrl = urlParams.get('outlet_id');
        
        if (outletIdFromUrl) {
            return outletIdFromUrl;
        }
        
        // Then check localStorage
        const savedOutletId = localStorage.getItem('selectedOutletId');
        
        if (savedOutletId) {
            return savedOutletId;
        }
        
        // Default to outlet ID 1 if nothing is found
        return 1;
    }

    // Update outlet information
    async function updateOutletInfo() {
        try {
            const outletId = getSelectedOutletId();
            
            // Fetch outlet details from API
            const response = await fetch(`/api/outlets/${outletId}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });
            
            const { data, success } = await response.json();
            
            if (success && data) {
                const outletElements = document.querySelectorAll('.outlet-name');
                outletElements.forEach(el => {
                    el.textContent = `Outlet Aktif: ${data.name}`;
                });
                
                const addressElements = document.querySelectorAll('.outlet-address');
                addressElements.forEach(el => {
                    el.textContent = data.address || 'Alamat tidak tersedia';
                });
            } else {
                throw new Error('Data outlet tidak ditemukan');
            }
        } catch (error) {
            console.error('Failed to fetch outlet details:', error);
            
            // Fallback: show basic outlet info
            const outletElements = document.querySelectorAll('.outlet-name');
            outletElements.forEach(el => {
                el.textContent = `Outlet Aktif: Outlet ${getSelectedOutletId()}`;
            });
            
            const addressElements = document.querySelectorAll('.outlet-address');
            addressElements.forEach(el => {
                el.textContent = 'Gagal memuat data outlet';
            });
        }
    }

    // Connect to outlet selection dropdown for real-time updates
    function connectOutletSelection() {
        // Listen for outlet changes in localStorage
        window.addEventListener('storage', function(event) {
            if (event.key === 'selectedOutletId') {
                // Update outlet info when outlet changes
                updateOutletInfo();
                
                // Show notification about outlet change
                showNotification(`Outlet berhasil diubah`, 'success');
                
                // You can also reload the data if needed
                // updateStats();
                // renderTable();
            }
        });
        
        // Also watch for clicks on outlet items in dropdown (if exists)
        const outletListContainer = document.getElementById('outletListContainer');
        if (outletListContainer) {
            outletListContainer.addEventListener('click', function(event) {
                // Find the clicked li element
                let targetElement = event.target;
                while (targetElement && targetElement !== outletListContainer && targetElement.tagName !== 'LI') {
                    targetElement = targetElement.parentElement;
                }
                
                // If we clicked on an outlet list item
                if (targetElement && targetElement.tagName === 'LI') {
                    // Update outlet info after a short delay
                    setTimeout(() => {
                        updateOutletInfo();
                        showNotification(`Outlet berhasil diubah`, 'success');
                    }, 100);
                }
            });
        }
        
        // Listen for custom outlet change event (if your app uses it)
        window.addEventListener('outletChanged', function(event) {
            updateOutletInfo();
            showNotification(`Outlet berhasil diubah ke ${event.detail.outletName}`, 'success');
        });
    }

    // ============================
    // INVENTORY MANAGEMENT FUNCTIONS
    // ============================

    // Fungsi untuk menghitung harga rata-rata
    function hitungHargaRataRata(bahan) {
        if (!bahan.batches || bahan.batches.length === 0) {
            return 0;
        }
        
        let totalNilai = 0;
        let totalStok = 0;
        
        bahan.batches.forEach(batch => {
            totalNilai += batch.sisa_stok * batch.harga_beli;
            totalStok += batch.sisa_stok;
        });
        
        return totalStok > 0 ? totalNilai / totalStok : 0;
    }

    // Fungsi untuk menghitung total nilai stok
    function hitungTotalNilai(bahan) {
        const hargaRata = hitungHargaRataRata(bahan);
        return bahan.stock * hargaRata;
    }

    function updateStats() {
        const totalBahanBaku = bahanBakuData.length;
        const totalInvestasi = bahanBakuData.reduce((sum, item) => sum + hitungTotalNilai(item), 0);
        const stokMenipis = bahanBakuData.filter(item => item.stock <= item.min_stock).length;
        
        // Hitung harga rata-rata semua bahan
        const totalHargaRata = bahanBakuData.reduce((sum, item) => sum + hitungHargaRataRata(item), 0);
        const avgHargaRata = totalBahanBaku > 0 ? totalHargaRata / totalBahanBaku : 0;

        document.getElementById('totalBahanBaku').textContent = totalBahanBaku;
        document.getElementById('totalInvestasi').textContent = formatRupiah(totalInvestasi);
        document.getElementById('stokMenipis').textContent = stokMenipis;
        document.getElementById('hargaRataRata').textContent = formatRupiah(avgHargaRata);
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
            const hargaRata = hitungHargaRataRata(item);
            const totalNilai = hitungTotalNilai(item);
            const statusClass = item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            const statusText = item.is_active ? 'Aktif' : 'Nonaktif';
            const stokWarning = item.stock <= item.min_stock ? 'text-red-600 font-semibold' : 'text-gray-600';
            const batchCount = item.batches ? item.batches.length : 0;
            
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
                                <div class="text-sm text-gray-500">${item.code}</div>
                                <div class="text-xs text-blue-600 cursor-pointer hover:underline" onclick="showRiwayatStok(${item.id})">
                                    ${batchCount} batch stok
                                </div>
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
                        <button onclick="showTambahStokModal(${item.id}, '${item.name}')" class="text-xs text-green-600 hover:text-green-700 mt-1">
                            + Tambah Stok
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${formatRupiah(hargaRata)}</div>
                        <div class="text-xs text-gray-500">/ ${item.unit}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${formatRupiah(totalNilai)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
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

        // Search and filter
        document.getElementById('searchBahanBaku').addEventListener('input', handleSearch);
        document.getElementById('filterKategori').addEventListener('change', handleFilter);
        document.getElementById('filterStatus').addEventListener('change', handleFilter);

        // Connect outlet selection
        connectOutletSelection();
    }

    function attachTableEventListeners() {
        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                showDeleteModal(id);
            });
        });
    }

    function showTambahModal() {
        const modal = document.getElementById('modalTambahBahanBaku');
        modal.classList.remove('hidden');
        document.getElementById('tambahBahanBakuForm').reset();
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

    // Global functions untuk modal
    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
    };

    window.closeTambahStokModal = function() {
        closeModal('modalTambahStok');
        document.getElementById('tambahStokForm').reset();
    };

    window.showTambahStokModal = function(id, nama) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            document.getElementById('tambahStokBahanId').value = id;
            document.getElementById('modalBahanNama').textContent = nama;
            document.getElementById('currentStock').textContent = `${item.stock} ${item.unit}`;
            document.getElementById('currentAvgPrice').textContent = formatRupiah(hitungHargaRataRata(item));
            
            // Set default date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('#tambahStokForm input[name="tanggal_masuk"]').value = today;
            
            const modal = document.getElementById('modalTambahStok');
            modal.classList.remove('hidden');
        }
    };

    window.showRiwayatStok = function(id) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            document.getElementById('riwayatBahanNama').textContent = item.name;
            
            const tbody = document.getElementById('riwayatStokTableBody');
            let html = '';
            
            if (item.batches && item.batches.length > 0) {
                item.batches.forEach((batch, index) => {
                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">Batch #${batch.id}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${batch.tanggal_masuk}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${batch.jumlah} ${item.unit}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${formatRupiah(batch.harga_beli)}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${batch.sisa_stok} ${item.unit}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${formatRupiah(batch.sisa_stok * batch.harga_beli)}</td>
                        </tr>
                    `;
                });
            } else {
                html = `<tr><td colspan="6" class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada riwayat stok</td></tr>`;
            }
            
            tbody.innerHTML = html;
            
            // Update summary
            const totalNilai = hitungTotalNilai(item);
            const hargaRata = hitungHargaRataRata(item);
            document.getElementById('totalNilaiStok').textContent = formatRupiah(totalNilai);
            document.getElementById('hargaRataSummary').textContent = formatRupiah(hargaRata);
            
            const modal = document.getElementById('modalRiwayatStok');
            modal.classList.remove('hidden');
        }
    };

    window.simpanTambahStok = function() {
        const form = document.getElementById('tambahStokForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        if (!data.jumlah || !data.harga_beli || !data.tanggal_masuk) {
            showNotification('Harap lengkapi semua field!', 'error');
            return;
        }
        
        const bahanId = parseInt(data.bahan_baku_id);
        const bahanIndex = bahanBakuData.findIndex(item => item.id === bahanId);
        
        if (bahanIndex !== -1) {
            const newBatch = {
                id: Date.now(), // Simple ID generation
                jumlah: parseFloat(data.jumlah),
                harga_beli: parseInt(data.harga_beli),
                tanggal_masuk: data.tanggal_masuk,
                sisa_stok: parseFloat(data.jumlah)
            };
            
            // Add new batch
            if (!bahanBakuData[bahanIndex].batches) {
                bahanBakuData[bahanIndex].batches = [];
            }
            bahanBakuData[bahanIndex].batches.push(newBatch);
            
            // Update total stock
            bahanBakuData[bahanIndex].stock += parseFloat(data.jumlah);
            
            updateStats();
            renderTable();
            showNotification('Stok berhasil ditambahkan!', 'success');
            closeTambahStokModal();
        }
    };

    window.hapusBahanBaku = function() {
        const id = document.getElementById('hapusItemId').value;
        bahanBakuData = bahanBakuData.filter(item => item.id != id);
        updateStats();
        renderTable();
        showNotification('Bahan baku berhasil dihapus', 'success');
        closeModal('modalKonfirmasiHapus');
    };

    window.simpanBahanBakuBaru = function() {
        const form = document.getElementById('tambahBahanBakuForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        if (!data.name || !data.code || !data.category || !data.unit || !data.min_stock || !data.supplier) {
            showNotification('Harap lengkapi semua field!', 'error');
            return;
        }
        
        const newId = bahanBakuData.length > 0 ? Math.max(...bahanBakuData.map(item => item.id)) + 1 : 1;
        const newItem = {
            id: newId,
            name: data.name,
            category: data.category,
            stock: 0, // Start with 0 stock
            unit: data.unit,
            min_stock: parseFloat(data.min_stock),
            is_active: data.is_active === '1',
            supplier: data.supplier,
            code: data.code,
            batches: [] // Empty batches array
        };
        
        bahanBakuData.push(newItem);
        updateStats();
        renderTable();
        showNotification('Bahan baku berhasil ditambahkan', 'success');
        closeModal('modalTambahBahanBaku');
    };

    function handleSearch() {
        const searchTerm = document.getElementById('searchBahanBaku').value.toLowerCase();
        const filteredData = bahanBakuData.filter(item => 
            item.name.toLowerCase().includes(searchTerm) ||
            item.code.toLowerCase().includes(searchTerm)
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
});
</script>
@endsection