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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
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
    // Global variables
    let bahanBakuData = [];
    let modalCloseHandlersInitialized = false;

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        createAuthInterceptor();
        setupModals();
        initializePage();
        setupModalCloseButtons();
    });

    // Setup all modals
    function setupModals() {
        setupModal('modalTambahBahanBaku');
        setupModal('modalKonfirmasiHapus');
        setupModal('modalTambahStok');
        setupModal('modalRiwayatStok');
    }

    // Setup individual modal
    function setupModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;

        if (!modal.hasAttribute('data-modal-initialized')) {
            modal.setAttribute('data-modal-initialized', 'true');
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modalId);
                }
            });

            const modalContent = modal.querySelector('.bg-white, [class*="rounded"]');
            if (modalContent) {
                modalContent.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        }
    }

    // Setup modal close buttons
    function setupModalCloseButtons() {
        if (modalCloseHandlersInitialized) {
            return;
        }
        
        modalCloseHandlersInitialized = true;

        console.log('Setting up modal close buttons...');

        // 1. Handle close buttons dengan SVG (X button)
        document.querySelectorAll('[id^="modal"] button:has(svg)').forEach(button => {
            if (button.hasAttribute('onclick')) {
                return;
            }
            
            const header = button.closest('.flex.items-center.justify-between');
            if (header) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const modal = this.closest('[id^="modal"]');
                    if (modal) {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // 2. Handle "Batal" buttons yang menggunakan onclick
        document.querySelectorAll('button[onclick*="closeModal"]').forEach(button => {
            const originalOnclick = button.getAttribute('onclick');
            
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (originalOnclick) {
                    try {
                        if (originalOnclick.includes("closeModal('modalTambahStok')")) {
                            closeModal('modalTambahStok');
                        } else if (originalOnclick.includes("closeModal('modalTambahBahanBaku')")) {
                            closeModal('modalTambahBahanBaku');
                        } else if (originalOnclick.includes("closeModal('modalKonfirmasiHapus')")) {
                            closeModal('modalKonfirmasiHapus');
                        } else {
                            eval(originalOnclick);
                        }
                    } catch (error) {
                        console.warn('Error executing onclick:', error);
                        const modal = this.closest('[id^="modal"]');
                        if (modal) {
                            closeModal(modal.id);
                        }
                    }
                }
            });
        });

        console.log('Modal close buttons setup completed');
    }

    // Create fetch interceptor for authentication
    function createAuthInterceptor() {
        const originalFetch = window.fetch;
        
        window.fetch = async function(resource, options = {}) {
            const token = localStorage.getItem('token');
            if (token) {
                options.headers = options.headers || {};
                options.headers.Authorization = `Bearer ${token}`;
                options.headers.Accept = 'application/json';
                options.headers['Content-Type'] = 'application/json';
                options.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
            }
            
            const response = await originalFetch(resource, options);
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const textResponse = await response.text();
                throw new Error(`Invalid response format: ${textResponse.substring(0, 100)}`);
            }
            
            return response;
        };
    }

    // Show alert notification
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const alertConfig = {
            success: {
                bgColor: 'bg-green-50',
                borderColor: 'border-green-200',
                textColor: 'text-green-800',
                icon: 'check-circle',
                iconColor: 'text-green-500'
            },
            error: {
                bgColor: 'bg-red-50',
                borderColor: 'border-red-200',
                textColor: 'text-red-800',
                icon: 'alert-circle',
                iconColor: 'text-red-500'
            },
            info: {
                bgColor: 'bg-blue-50',
                borderColor: 'border-blue-200',
                textColor: 'text-blue-800',
                icon: 'info',
                iconColor: 'text-blue-500'
            }
        };
        
        const config = alertConfig[type] || alertConfig.info;
        
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
        
        if (window.lucide) {
            window.lucide.createIcons();
        }
        
        setTimeout(() => {
            closeAlert(alertId);
        }, 5000);
    }

    // Close alert
    function closeAlert(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.classList.add('animate-fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }

    // Modal functions
    function openModal(modalId) {
        try {
            console.log('Opening modal:', modalId);
            
            document.querySelectorAll('[id^="modal"]').forEach(modal => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
            
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                
                modal.dispatchEvent(new Event('modal-opened'));
            } else {
                console.error(`Modal dengan ID ${modalId} tidak ditemukan`);
            }
        } catch (error) {
            console.error('Error opening modal:', error);
        }
    }

    function closeModal(modalId) {
        try {
            console.log('Closing modal:', modalId);
            
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
                
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
                
                modal.dispatchEvent(new Event('modal-closed'));
            }
        } catch (error) {
            console.error('Error closing modal:', error);
        }
    }

    // Fungsi khusus untuk modal tambah stok
    window.closeTambahStokModal = function() {
        closeModal('modalTambahStok');
        const form = document.getElementById('tambahStokForm');
        if (form) {
            form.reset();
        }
    };

    // Fungsi global untuk close modal
    window.closeModal = closeModal;

    async function initializePage() {
        await updateOutletInfo();
        await loadBahanBakuData();
        setupEventListeners();
    }

    // ============================
    // OUTLET MANAGEMENT FUNCTIONS
    // ============================

    function getSelectedOutletId() {
        const urlParams = new URLSearchParams(window.location.search);
        const outletIdFromUrl = urlParams.get('outlet_id');
        
        if (outletIdFromUrl) {
            return outletIdFromUrl;
        }
        
        const savedOutletId = localStorage.getItem('selectedOutletId');
        
        if (savedOutletId) {
            return savedOutletId;
        }
        
        return 1;
    }

    async function updateOutletInfo() {
        try {
            const outletId = getSelectedOutletId();
            const token = localStorage.getItem('token');
            
            if (!token) {
                throw new Error('Token tidak ditemukan');
            }
            
            const response = await fetch(`/api/outlets/${outletId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success && result.data) {
                const outletElements = document.querySelectorAll('.outlet-name');
                outletElements.forEach(el => {
                    el.textContent = `Outlet Aktif: ${result.data.name}`;
                });
                
                const addressElements = document.querySelectorAll('.outlet-address');
                addressElements.forEach(el => {
                    el.textContent = result.data.address || 'Alamat tidak tersedia';
                });
            } else {
                throw new Error('Data outlet tidak ditemukan');
            }
        } catch (error) {
            console.error('Failed to fetch outlet details:', error);
            
            const outletElements = document.querySelectorAll('.outlet-name');
            outletElements.forEach(el => {
                el.textContent = `Outlet Aktif: Outlet ${getSelectedOutletId()}`;
            });
            
            const addressElements = document.querySelectorAll('.outlet-address');
            addressElements.forEach(el => {
                el.textContent = 'Gagal memuat data outlet';
            });

            if (error.message.includes('401') || error.message.includes('403')) {
                window.location.href = '/login';
            }
        }
    }

    function connectOutletSelection() {
        window.addEventListener('storage', function(event) {
            if (event.key === 'selectedOutletId') {
                updateOutletInfo();
                showAlert('success', 'Outlet berhasil diubah');
            }
        });
        
        const outletListContainer = document.getElementById('outletListContainer');
        if (outletListContainer) {
            outletListContainer.addEventListener('click', function(event) {
                let targetElement = event.target;
                while (targetElement && targetElement !== outletListContainer && targetElement.tagName !== 'LI') {
                    targetElement = targetElement.parentElement;
                }
                
                if (targetElement && targetElement.tagName === 'LI') {
                    setTimeout(() => {
                        updateOutletInfo();
                        showAlert('success', 'Outlet berhasil diubah');
                    }, 100);
                }
            });
        }
        
        window.addEventListener('outletChanged', function(event) {
            updateOutletInfo();
            showAlert('success', `Outlet berhasil diubah ke ${event.detail.outletName}`);
        });
    }

    // ============================
    // API FUNCTIONS
    // ============================

    async function loadBahanBakuData() {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            const tbody = document.getElementById('bahanBakuTableBody');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="animate-spin text-green-500">
                                    <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                                </svg>
                                <span class="text-gray-500">Memuat data bahan baku...</span>
                            </div>
                        </td>
                    </tr>
                `;
            }

            const response = await fetch('/api/raw-material', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                const error = await response.json().catch(() => null);
                throw new Error(error?.message || `HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            
            if (!result.success) {
                throw new Error(result.message || 'Invalid response format');
            }

            bahanBakuData = result.data;
            updateStats();
            renderTable();
            
        } catch (error) {
            console.error('Load Bahan Baku Error:', error);
            showAlert('error', `Gagal memuat bahan baku: ${error.message}`);
            
            if (error.message.includes('401') || error.message.includes('403')) {
                window.location.href = '/login';
            }
            
            renderTable([]);
        }
    }

    async function createBahanBaku(formData) {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Token tidak ditemukan');
            }

            const response = await fetch('/api/raw-material', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Gagal menambahkan bahan baku');
            }
            
            const result = await response.json();
            
            if (result.success) {
                await loadBahanBakuData();
                return { success: true, data: result.data };
            } else {
                return { 
                    success: false, 
                    message: result.message,
                    errors: result.errors 
                };
            }
        } catch (error) {
            console.error('Error creating bahan baku:', error);
            return { 
                success: false, 
                message: error.message || 'Terjadi kesalahan saat menyimpan data' 
            };
        }
    }

    async function deleteBahanBaku(id) {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Token tidak ditemukan');
            }

            const response = await fetch(`/api/material-delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Gagal menghapus bahan baku');
            }
            
            const result = await response.json();
            
            if (result.success) {
                await loadBahanBakuData();
                return { success: true };
            } else {
                return { 
                    success: false, 
                    message: result.message || 'Gagal menghapus bahan baku' 
                };
            }
        } catch (error) {
            console.error('Error deleting bahan baku:', error);
            return { 
                success: false, 
                message: error.message || 'Terjadi kesalahan saat menghapus data' 
            };
        }
    }

    async function tambahStok(formData) {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('Token tidak ditemukan');
            }

            const purchaseData = {
                outlet_id: parseInt(getSelectedOutletId()),
                purchase_date: formData.tanggal_masuk,
                notes: `Tambah stok untuk ${formData.bahan_baku_name}`,
                created_by: 1,
                items: [
                    {
                        raw_material_id: parseInt(formData.bahan_baku_id),
                        quantity: parseFloat(formData.jumlah),
                        unit_cost: parseFloat(formData.harga_beli)
                    }
                ]
            };

            const response = await fetch('/api/material-purchase', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(purchaseData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Gagal menambah stok');
            }
            
            const result = await response.json();
            
            if (result.success) {
                await loadBahanBakuData();
                return { success: true, data: result.data };
            } else {
                return { 
                    success: false, 
                    message: result.message,
                    errors: result.errors 
                };
            }
        } catch (error) {
            console.error('Error adding stock:', error);
            return { 
                success: false, 
                message: error.message || 'Terjadi kesalahan saat menambah stok' 
            };
        }
    }

    // ============================
    // INVENTORY MANAGEMENT FUNCTIONS
    // ============================

    function hitungHargaRataRata(bahan) {
        return parseFloat(bahan.cost_per_unit) || 0;
    }

    function hitungTotalNilai(bahan) {
        const hargaRata = hitungHargaRataRata(bahan);
        
        let stok = 0;
        if (bahan.stocks && bahan.stocks.length > 0) {
            const outletId = getSelectedOutletId();
            const stockData = bahan.stocks.find(stock => stock.outlet_id == outletId);
            stok = stockData ? parseFloat(stockData.current_stock) : 0;
        }
        
        return stok * hargaRata;
    }

    function getStokBahan(bahan) {
        if (bahan.stocks && bahan.stocks.length > 0) {
            const outletId = getSelectedOutletId();
            const stockData = bahan.stocks.find(stock => stock.outlet_id == outletId);
            return stockData ? parseFloat(stockData.current_stock) : 0;
        }
        return 0;
    }

    function updateStats() {
        const totalBahanBaku = bahanBakuData.length;
        const totalInvestasi = bahanBakuData.reduce((sum, item) => sum + hitungTotalNilai(item), 0);
        const stokMenipis = bahanBakuData.filter(item => getStokBahan(item) <= parseFloat(item.min_stock)).length;
        
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
            const stok = getStokBahan(item);
            const statusClass = item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            const statusText = item.is_active ? 'Aktif' : 'Nonaktif';
            const stokWarning = stok <= parseFloat(item.min_stock) ? 'text-red-600 font-semibold' : 'text-gray-600';
            
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
                                <div class="text-sm text-gray-500">${item.description || 'Tidak ada deskripsi'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${item.code}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm ${stokWarning}">${stok} ${item.unit}</div>
                        <div class="text-xs text-gray-500">Min: ${item.min_stock} ${item.unit}</div>
                        ${stok <= parseFloat(item.min_stock) ? '<div class="text-xs text-red-500">Stok menipis!</div>' : ''}
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
                            <button class="text-green-600 hover:text-green-900 add-stock-btn" data-id="${item.id}" title="Tambah Stok">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                            <button class="text-blue-600 hover:text-blue-900 history-btn" data-id="${item.id}" title="Riwayat Stok">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-900 delete-btn" data-id="${item.id}" title="Hapus Bahan Baku">
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

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    function setupEventListeners() {
        document.getElementById('btnTambahBahanBaku').addEventListener('click', showTambahModal);
        document.getElementById('searchBahanBaku').addEventListener('input', handleSearch);
        document.getElementById('filterStatus').addEventListener('change', handleFilter);
        connectOutletSelection();
    }

    function attachTableEventListeners() {
        document.querySelectorAll('.add-stock-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                showTambahStokModal(id);
            });
        });

        document.querySelectorAll('.history-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                showRiwayatStok(id);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                showDeleteModal(id);
            });
        });
    }

    function showTambahModal() {
        openModal('modalTambahBahanBaku');
        document.getElementById('tambahBahanBakuForm').reset();
    }

    function showTambahStokModal(id) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            document.getElementById('modalBahanNama').textContent = item.name;
            document.getElementById('currentStock').textContent = `${getStokBahan(item)} ${item.unit}`;
            document.getElementById('currentAvgPrice').textContent = formatRupiah(hitungHargaRataRata(item));
            document.getElementById('tambahStokBahanId').value = item.id;
            
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="tanggal_masuk"]').value = today;
            
            openModal('modalTambahStok');
        }
    }

    function showDeleteModal(id) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            document.getElementById('hapusItemId').value = id;
            document.getElementById('hapusItemName').textContent = item.name;
            openModal('modalKonfirmasiHapus');
        }
    }

    // ============================
    // GLOBAL FUNCTIONS UNTUK MODAL
    // ============================

    window.showRiwayatStok = function(id) {
        const item = bahanBakuData.find(b => b.id == id);
        if (item) {
            document.getElementById('riwayatBahanNama').textContent = item.name;
            
            const tbody = document.getElementById('riwayatStokTableBody');
            let html = '';
            
            if (item.stocks && item.stocks.length > 0) {
                item.stocks.forEach((stock, index) => {
                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">Batch #${stock.id}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${new Date(stock.created_at).toLocaleDateString('id-ID')}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${stock.current_stock} ${item.unit}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${formatRupiah(stock.total_value / stock.current_stock)}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${stock.current_stock} ${item.unit}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">${formatRupiah(stock.total_value)}</td>
                        </tr>
                    `;
                });
            } else {
                html = `<tr><td colspan="6" class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada riwayat stok</td></tr>`;
            }
            
            tbody.innerHTML = html;
            
            const totalNilai = hitungTotalNilai(item);
            const hargaRata = hitungHargaRataRata(item);
            document.getElementById('totalNilaiStok').textContent = formatRupiah(totalNilai);
            document.getElementById('hargaRataSummary').textContent = formatRupiah(hargaRata);
            
            openModal('modalRiwayatStok');
        }
    };

    window.hapusBahanBaku = async function() {
        const id = document.getElementById('hapusItemId').value;
        
        const result = await deleteBahanBaku(id);
        
        if (result.success) {
            showAlert('success', 'Bahan baku berhasil dihapus');
        } else {
            showAlert('error', result.message);
        }
        
        closeModal('modalKonfirmasiHapus');
    };

    window.simpanBahanBakuBaru = async function() {
        const form = document.getElementById('tambahBahanBakuForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        if (!data.name || !data.code || !data.unit || !data.min_stock) {
            showAlert('error', 'Harap lengkapi semua field yang wajib!');
            return;
        }

        const postData = {
            name: data.name,
            code: data.code,
            unit: data.unit,
            cost_per_unit: data.cost_per_unit ? parseFloat(data.cost_per_unit) : 0,
            min_stock: parseFloat(data.min_stock),
            description: data.description || '',
            is_active: data.is_active === '1'
        };

        const result = await createBahanBaku(postData);
        
        if (result.success) {
            showAlert('success', 'Bahan baku berhasil ditambahkan');
            closeModal('modalTambahBahanBaku');
        } else {
            if (result.errors) {
                const errorMessages = Object.values(result.errors).flat().join(', ');
                showAlert('error', `Gagal menambah bahan baku: ${errorMessages}`);
            } else {
                showAlert('error', result.message);
            }
        }
    };

    window.simpanTambahStok = async function() {
        const form = document.getElementById('tambahStokForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        if (!data.jumlah || !data.harga_beli || !data.tanggal_masuk) {
            showAlert('error', 'Harap lengkapi semua field!');
            return;
        }

        const bahanBakuId = data.bahan_baku_id;
        const bahanBaku = bahanBakuData.find(b => b.id == bahanBakuId);
        data.bahan_baku_name = bahanBaku ? bahanBaku.name : '';

        const result = await tambahStok(data);
        
        if (result.success) {
            showAlert('success', 'Stok berhasil ditambahkan');
            closeModal('modalTambahStok');
        } else {
            if (result.errors) {
                const errorMessages = Object.values(result.errors).flat().join(', ');
                showAlert('error', `Gagal menambah stok: ${errorMessages}`);
            } else {
                showAlert('error', result.message);
            }
        }
    };

    function handleSearch() {
        const searchTerm = document.getElementById('searchBahanBaku').value.toLowerCase();
        const filteredData = bahanBakuData.filter(item => 
            item.name.toLowerCase().includes(searchTerm) ||
            item.code.toLowerCase().includes(searchTerm) ||
            (item.description && item.description.toLowerCase().includes(searchTerm))
        );
        renderTable(filteredData);
    }

    function handleFilter() {
        const statusFilter = document.getElementById('filterStatus').value;
        
        let filteredData = bahanBakuData;

        if (statusFilter) {
            const isActive = statusFilter === 'active';
            filteredData = filteredData.filter(item => item.is_active === isActive);
        }

        renderTable(filteredData);
    }
</script>

<style>
    /* Animations for alerts */
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

    /* Style untuk button aksi yang lebih rapi */
    .flex.items-center.space-x-2 button {
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .flex.items-center.space-x-2 button:hover {
        background-color: #f3f4f6;
        transform: scale(1.05);
    }

    /* Smooth transitions untuk modal */
    [id^="modal"] {
        transition: opacity 0.3s ease;
    }

    /* Style untuk close button */
    button:has(svg) {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    button:has(svg):hover {
        background-color: #f3f4f6;
    }
</style>

@endsection