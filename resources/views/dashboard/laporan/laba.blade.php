@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')

@section('content')
<!-- Notification container -->
<div id="alertContainer" class="fixed top-4 right-4 z-[1000] space-y-3 w-80">
    <!-- Alerts will appear here dynamically -->
</div>

<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Laba Rugi</h1>
            <p class="text-gray-600 mt-1">Analisis pendapatan dan biaya bahan baku</p>
        </div>
        <div class="flex gap-3 mt-4 md:mt-0">
            <button id="btnExportCSV" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
            <button id="btnRefresh" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Card: Outlet Info -->
    <div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="mb-3 md:mb-0 flex items-start gap-2">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <div>
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 outlet-name">Outlet Aktif: Loading...</h2>
                <p class="text-sm text-gray-600 outlet-address">Memuat data outlet...</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode Tanggal</label>
                <select id="filterPeriod" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                    <option value="today">Hari Ini</option>
                    <option value="yesterday">Kemarin</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                    <option value="last_month">Bulan Lalu</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" id="startDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" id="endDate" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
            </div>
            <div class="flex items-end">
                <button id="btnFilter" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalPendapatan">Rp 0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Biaya Bahan Baku</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalBiayaBahan">Rp 0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Laba Kotor</p>
                    <p class="text-2xl font-bold text-gray-800" id="labaKotor">Rp 0</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Margin Laba</p>
                    <p class="text-2xl font-bold text-gray-800" id="marginLaba">0%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Laba Rugi Detail -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Pendapatan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                Pendapatan
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Penjualan Minuman</span>
                    <span class="font-medium text-gray-800" id="pendapatanMinuman">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Penjualan Makanan</span>
                    <span class="font-medium text-gray-800" id="pendapatanMakanan">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Penjualan Lainnya</span>
                    <span class="font-medium text-gray-800" id="pendapatanLainnya">Rp 0</span>
                </div>
                <div class="border-t pt-2 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Total Pendapatan</span>
                        <span class="font-bold text-green-600" id="totalPendapatanDetail">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biaya Bahan Baku -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Biaya Bahan Baku
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Biji Kopi</span>
                    <span class="font-medium text-gray-800" id="biayaKopi">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Produk Susu</span>
                    <span class="font-medium text-gray-800" id="biayaSusu">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Pemanis & Sirup</span>
                    <span class="font-medium text-gray-800" id="biayaPemanis">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Topping & Lainnya</span>
                    <span class="font-medium text-gray-800" id="biayaTopping">Rp 0</span>
                </div>
                <div class="border-t pt-2 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800">Total Biaya Bahan</span>
                        <span class="font-bold text-red-600" id="totalBiayaBahanDetail">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Laba Rugi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Ringkasan Laba Rugi
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Pendapatan</span>
                    <span class="font-medium text-gray-800" id="summaryPendapatan">Rp 0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Biaya Bahan Baku</span>
                    <span class="font-medium text-gray-800" id="summaryBiaya">Rp 0</span>
                </div>
                <div class="border-t pt-2">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">Laba Kotor</span>
                        <span class="font-bold text-green-600" id="summaryLabaKotor">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Margin Laba</span>
                        <span class="font-medium text-green-600" id="summaryMargin">0%</span>
                    </div>
                </div>
                
                <!-- Progress Bar Margin -->
                <div class="mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Margin Laba</span>
                        <span id="progressMarginText">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressMarginBar" class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>0%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Chart Pendapatan vs Biaya -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan vs Biaya Bahan Baku</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="revenueCostChart"></canvas>
            </div>
        </div>

        <!-- Chart Persentase Biaya -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Persentase Biaya Bahan Baku</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="costDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Detail Transaksi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Detail Transaksi Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pendapatan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Biaya Bahan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Laba Kotor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Margin Laba</th>
                    </tr>
                </thead>
                <tbody id="transactionTableBody" class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                                </svg>
                                <p class="text-lg font-medium mb-2">Belum ada data transaksi</p>
                                <p class="text-sm">Pilih periode tanggal untuk melihat laporan</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Global variable to store current report data
let currentReportData = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    let revenueCostChart, costDistributionChart;
    
    // Initialize the page
    initializePage();

    function initializePage() {
        updateOutletInfo();
        setupEventListeners();
        setDefaultDates();
        loadReportData();
        initializeCharts();
        connectOutletSelection();
    }

    // ============================
    // AUTHENTICATION FUNCTIONS
    // ============================

    // Function to get token from localStorage
    function getAuthToken() {
        // Try different possible keys for token storage
        const possibleKeys = [
            'token',
            'auth_token',
            'access_token',
            'user_token',
            'laravel_token'
        ];
        
        for (const key of possibleKeys) {
            const token = localStorage.getItem(key);
            if (token) {
                return token;
            }
        }
        
        // Also check for token in sessionStorage
        for (const key of possibleKeys) {
            const token = sessionStorage.getItem(key);
            if (token) {
                return token;
            }
        }
        
        console.warn('No authentication token found in localStorage or sessionStorage');
        return null;
    }

    // Function to get CSRF token from meta tag
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // Function to check if user is authenticated
    function isAuthenticated() {
        const token = getAuthToken();
        return token !== null && token !== 'undefined' && token !== '';
    }

    // Function to handle authentication errors
    function handleAuthError() {
        showNotification('Sesi Anda telah habis. Silakan login kembali.', 'error');
        
        // Redirect to login page after 2 seconds
        setTimeout(() => {
            window.location.href = '/login';
        }, 2000);
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
            const token = getAuthToken();
            
            if (!token) {
                throw new Error('No authentication token available');
            }

            // Fetch outlet details from API
            const response = await fetch(`/api/outlets/${outletId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.status === 401) {
                handleAuthError();
                return;
            }
            
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
                
                // Reload report data with new outlet
                loadReportData();
                
                // Show notification about outlet change
                showNotification(`Outlet berhasil diubah`, 'success');
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
                        loadReportData();
                        showNotification(`Outlet berhasil diubah`, 'success');
                    }, 100);
                }
            });
        }
        
        // Listen for custom outlet change event (if your app uses it)
        window.addEventListener('outletChanged', function(event) {
            updateOutletInfo();
            loadReportData();
            showNotification(`Outlet berhasil diubah ke ${event.detail.outletName}`, 'success');
        });
    }

    // ============================
    // REPORT MANAGEMENT FUNCTIONS
    // ============================

    function setDefaultDates() {
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        
        document.getElementById('startDate').value = today.toISOString().split('T')[0];
        document.getElementById('endDate').value = today.toISOString().split('T')[0];
    }

    function setupEventListeners() {
        // Filter period change
        document.getElementById('filterPeriod').addEventListener('change', function() {
            handlePeriodChange(this.value);
        });

        // Filter button
        document.getElementById('btnFilter').addEventListener('click', function() {
            loadReportData();
        });

        // Refresh button
        document.getElementById('btnRefresh').addEventListener('click', function() {
            loadReportData();
        });

        // Export CSV button
        document.getElementById('btnExportCSV').addEventListener('click', function() {
            exportToCSV();
        });
    }

    function handlePeriodChange(period) {
        const today = new Date();
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        switch(period) {
            case 'today':
                startDate.value = today.toISOString().split('T')[0];
                endDate.value = today.toISOString().split('T')[0];
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                startDate.value = yesterday.toISOString().split('T')[0];
                endDate.value = yesterday.toISOString().split('T')[0];
                break;
            case 'week':
                const startOfWeek = new Date(today);
                startOfWeek.setDate(today.getDate() - today.getDay());
                startDate.value = startOfWeek.toISOString().split('T')[0];
                endDate.value = today.toISOString().split('T')[0];
                break;
            case 'month':
                const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                startDate.value = startOfMonth.toISOString().split('T')[0];
                endDate.value = today.toISOString().split('T')[0];
                break;
            case 'last_month':
                const startOfLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                const endOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                startDate.value = startOfLastMonth.toISOString().split('T')[0];
                endDate.value = endOfLastMonth.toISOString().split('T')[0];
                break;
            case 'custom':
                // Do nothing, let user select dates
                break;
        }

        if (period !== 'custom') {
            loadReportData();
        }
    }

    async function loadReportData() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const outletId = getSelectedOutletId();
        
        if (!startDate || !endDate) {
            showNotification('Harap pilih tanggal mulai dan tanggal akhir', 'error');
            return;
        }

        // Check authentication
        if (!isAuthenticated()) {
            handleAuthError();
            return;
        }

        // Show loading state
        showLoadingState();

        try {
            const token = getAuthToken();
            const csrfToken = getCsrfToken();
            
            // Fetch data from backend API with authentication
            const response = await fetch(`/api/laba-rugi?start_date=${startDate}&end_date=${endDate}&outlet_id=${outletId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'include' // Include cookies for session-based auth
            });

            if (response.status === 401) {
                handleAuthError();
                return;
            }

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            // Store current report data for export
            currentReportData = data;
            
            // Process and update UI with real data
            processReportData(data);
            
        } catch (error) {
            console.error('Failed to load report data:', error);
            
            if (error.message.includes('401')) {
                handleAuthError();
            } else {
                showNotification('Gagal memuat data laporan', 'error');
                
                // Fallback to mock data if API fails
                const mockData = generateMockReportData(startDate, endDate, outletId);
                currentReportData = mockData;
                processReportData(mockData);
            }
        }
    }

    function processReportData(apiData) {
        // Transform API data to match our UI structure
        const processedData = transformApiData(apiData);
        updateReportUI(processedData);
        updateCharts(processedData);
    }

    function transformApiData(apiData) {
        // Calculate additional metrics from API data
        const totalPendapatan = apiData.revenue.total_revenue;
        const totalBiayaBahan = apiData.raw_material_cost.total_cost;
        const labaKotor = apiData.profit_summary.gross_profit;
        const marginLaba = apiData.profit_summary.profit_margin_percentage;

        // Estimate breakdown based on total values (you might want to adjust this based on your actual data structure)
        const pendapatanMinuman = Math.floor(totalPendapatan * 0.6); // 60% from drinks
        const pendapatanMakanan = Math.floor(totalPendapatan * 0.3); // 30% from food
        const pendapatanLainnya = Math.floor(totalPendapatan * 0.1); // 10% from others

        // Estimate cost breakdown
        const biayaKopi = Math.floor(totalBiayaBahan * 0.4); // 40% coffee
        const biayaSusu = Math.floor(totalBiayaBahan * 0.25); // 25% milk
        const biayaPemanis = Math.floor(totalBiayaBahan * 0.15); // 15% sweeteners
        const biayaTopping = Math.floor(totalBiayaBahan * 0.2); // 20% toppings

        return {
            outletId: getSelectedOutletId(),
            periode: `${apiData.period.start_date} s/d ${apiData.period.end_date}`,
            pendapatan: {
                minuman: pendapatanMinuman,
                makanan: pendapatanMakanan,
                lainnya: pendapatanLainnya,
                total: totalPendapatan
            },
            biaya: {
                kopi: biayaKopi,
                susu: biayaSusu,
                pemanis: biayaPemanis,
                topping: biayaTopping,
                total: totalBiayaBahan
            },
            laba: {
                kotor: labaKotor,
                margin: marginLaba
            },
            dailyBreakdown: apiData.daily_breakdown,
            rawData: apiData // Store raw API data for export
        };
    }

    function generateMockReportData(startDate, endDate, outletId) {
        // Fallback mock data generator
        const baseMultiplier = parseInt(outletId) * 1000000;
        
        const pendapatanMinuman = Math.floor(Math.random() * 5000000) + 3000000 + baseMultiplier;
        const pendapatanMakanan = Math.floor(Math.random() * 2000000) + 1000000 + baseMultiplier;
        const pendapatanLainnya = Math.floor(Math.random() * 1000000) + 500000 + baseMultiplier;
        
        const totalPendapatan = pendapatanMinuman + pendapatanMakanan + pendapatanLainnya;
        
        const biayaKopi = Math.floor(totalPendapatan * 0.15);
        const biayaSusu = Math.floor(totalPendapatan * 0.10);
        const biayaPemanis = Math.floor(totalPendapatan * 0.05);
        const biayaTopping = Math.floor(totalPendapatan * 0.08);
        
        const totalBiayaBahan = biayaKopi + biayaSusu + biayaPemanis + biayaTopping;
        const labaKotor = totalPendapatan - totalBiayaBahan;
        const marginLaba = totalPendapatan > 0 ? ((labaKotor / totalPendapatan) * 100) : 0;

        const dailyBreakdown = generateMockDailyBreakdown(startDate, endDate, outletId);

        return {
            period: {
                start_date: startDate,
                end_date: endDate
            },
            revenue: {
                total_revenue: totalPendapatan
            },
            raw_material_cost: {
                total_cost: totalBiayaBahan
            },
            profit_summary: {
                gross_profit: labaKotor,
                profit_margin_percentage: marginLaba
            },
            daily_breakdown: dailyBreakdown
        };
    }

    function generateMockDailyBreakdown(startDate, endDate, outletId) {
        const breakdown = [];
        const start = new Date(startDate);
        const end = new Date(endDate);
        const daysDiff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
        
        for (let i = 0; i <= daysDiff; i++) {
            const currentDate = new Date(start);
            currentDate.setDate(start.getDate() + i);
            
            const revenue = Math.floor(Math.random() * 1000000) + 500000;
            const cost = Math.floor(revenue * (0.2 + Math.random() * 0.3));
            const profit = revenue - cost;
            const margin = revenue > 0 ? (profit / revenue) * 100 : 0;
            
            breakdown.push({
                date: currentDate.toISOString().split('T')[0],
                revenue: revenue,
                raw_material_cost: cost,
                gross_profit: profit,
                profit_margin: margin
            });
        }
        
        return breakdown;
    }

    function updateReportUI(data) {
        // Update summary cards
        document.getElementById('totalPendapatan').textContent = formatRupiah(data.pendapatan.total);
        document.getElementById('totalBiayaBahan').textContent = formatRupiah(data.biaya.total);
        document.getElementById('labaKotor').textContent = formatRupiah(data.laba.kotor);
        document.getElementById('marginLaba').textContent = `${data.laba.margin.toFixed(1)}%`;

        // Update pendapatan section
        document.getElementById('pendapatanMinuman').textContent = formatRupiah(data.pendapatan.minuman);
        document.getElementById('pendapatanMakanan').textContent = formatRupiah(data.pendapatan.makanan);
        document.getElementById('pendapatanLainnya').textContent = formatRupiah(data.pendapatan.lainnya);
        document.getElementById('totalPendapatanDetail').textContent = formatRupiah(data.pendapatan.total);

        // Update biaya section
        document.getElementById('biayaKopi').textContent = formatRupiah(data.biaya.kopi);
        document.getElementById('biayaSusu').textContent = formatRupiah(data.biaya.susu);
        document.getElementById('biayaPemanis').textContent = formatRupiah(data.biaya.pemanis);
        document.getElementById('biayaTopping').textContent = formatRupiah(data.biaya.topping);
        document.getElementById('totalBiayaBahanDetail').textContent = formatRupiah(data.biaya.total);

        // Update summary section
        document.getElementById('summaryPendapatan').textContent = formatRupiah(data.pendapatan.total);
        document.getElementById('summaryBiaya').textContent = formatRupiah(data.biaya.total);
        document.getElementById('summaryLabaKotor').textContent = formatRupiah(data.laba.kotor);
        document.getElementById('summaryMargin').textContent = `${data.laba.margin.toFixed(1)}%`;

        // Update progress bar
        const progressBar = document.getElementById('progressMarginBar');
        const progressText = document.getElementById('progressMarginText');
        const margin = Math.min(Math.max(data.laba.margin, 0), 100); // Ensure between 0-100
        
        progressBar.style.width = `${margin}%`;
        progressText.textContent = `${data.laba.margin.toFixed(1)}%`;

        // Update transaction table with daily breakdown
        updateTransactionTable(data.dailyBreakdown);
    }

    function updateTransactionTable(dailyBreakdown) {
        const tbody = document.getElementById('transactionTableBody');
        
        if (!dailyBreakdown || dailyBreakdown.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                            </svg>
                            <p class="text-lg font-medium mb-2">Tidak ada transaksi pada periode ini</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        dailyBreakdown.forEach(day => {
            const profitClass = day.gross_profit >= 0 ? 'text-green-600' : 'text-red-600';
            const marginClass = day.profit_margin >= 0 ? 'text-green-600' : 'text-red-600';
            const profitSign = day.gross_profit >= 0 ? '+' : '';
            const marginSign = day.profit_margin >= 0 ? '+' : '';
            
            html += `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatDate(day.date)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatRupiah(day.revenue)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatRupiah(day.raw_material_cost)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${profitClass}">
                        ${profitSign}${formatRupiah(day.gross_profit)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${marginClass}">
                        ${marginSign}${day.profit_margin.toFixed(1)}%
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    // ============================
    // CSV EXPORT FUNCTIONS
    // ============================

    function exportToCSV() {
        if (!currentReportData) {
            showNotification('Tidak ada data untuk diexport', 'error');
            return;
        }

        try {
            // Create CSV content
            const csvContent = generateCSVContent(currentReportData);
            
            // Create download link
            downloadCSV(csvContent, generateFileName());
            
            showNotification('Data berhasil diexport ke CSV', 'success');
        } catch (error) {
            console.error('Export CSV error:', error);
            showNotification('Gagal mengexport data ke CSV', 'error');
        }
    }

    function generateCSVContent(data) {
        const outletId = getSelectedOutletId();
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        let csv = '';
        
        // Header informasi laporan
        csv += 'LAPORAN LABA RUGI\n';
        csv += `Outlet: ${outletId}\n`;
        csv += `Periode: ${startDate} s/d ${endDate}\n`;
        csv += `Tanggal Export: ${new Date().toLocaleDateString('id-ID')}\n`;
        csv += '\n';
        
        // Ringkasan
        csv += 'RINGKASAN\n';
        csv += 'Kategori,Nilai\n';
        csv += `Total Pendapatan,${data.revenue.total_revenue}\n`;
        csv += `Total Biaya Bahan Baku,${data.raw_material_cost.total_cost}\n`;
        csv += `Laba Kotor,${data.profit_summary.gross_profit}\n`;
        csv += `Margin Laba (%),${data.profit_summary.profit_margin_percentage.toFixed(2)}\n`;
        csv += '\n';
        
        // Detail Harian
        csv += 'DETAIL HARIAN\n';
        csv += 'Tanggal,Pendapatan,Biaya Bahan Baku,Laba Kotor,Margin Laba (%)\n';
        
        if (data.daily_breakdown && data.daily_breakdown.length > 0) {
            data.daily_breakdown.forEach(day => {
                csv += `${day.date},${day.revenue},${day.raw_material_cost},${day.gross_profit},${day.profit_margin.toFixed(2)}\n`;
            });
        } else {
            csv += 'Tidak ada data transaksi harian\n';
        }
        
        // Statistik Tambahan
        csv += '\n';
        csv += 'STATISTIK TAMBAHAN\n';
        csv += 'Kategori,Nilai\n';
        csv += `Total Orders,${data.revenue.total_orders || 0}\n`;
        csv += `Rata-rata Order,${data.revenue.average_order_value || 0}\n`;
        csv += `Total Pembelian Bahan,${data.raw_material_cost.total_purchases || 0}\n`;
        csv += `Persentase Biaya vs Pendapatan (%),${data.raw_material_cost.percentage_of_revenue?.toFixed(2) || 0}\n`;
        
        return csv;
    }

    function generateFileName() {
        const outletId = getSelectedOutletId();
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        return `laba_rugi_outlet_${outletId}_${startDate}_to_${endDate}.csv`;
    }

    function downloadCSV(csvContent, fileName) {
        // Create blob
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        
        // Create download link
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        link.setAttribute('download', fileName);
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Clean up
        URL.revokeObjectURL(url);
    }

    // ============================
    // CHART FUNCTIONS
    // ============================

    function initializeCharts() {
        const revenueCostCtx = document.getElementById('revenueCostChart').getContext('2d');
        const costDistributionCtx = document.getElementById('costDistributionChart').getContext('2d');

        revenueCostChart = new Chart(revenueCostCtx, {
            type: 'bar',
            data: {
                labels: ['Pendapatan', 'Biaya Bahan', 'Laba Kotor'],
                datasets: [{
                    label: 'Amount (Rp)',
                    data: [0, 0, 0],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(34, 197, 94, 0.6)'
                    ],
                    borderColor: [
                        'rgb(34, 197, 94)',
                        'rgb(239, 68, 68)',
                        'rgb(34, 197, 94)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Rp ${context.raw.toLocaleString('id-ID')}`;
                            }
                        }
                    }
                }
            }
        });

        costDistributionChart = new Chart(costDistributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Biji Kopi', 'Produk Susu', 'Pemanis & Sirup', 'Topping & Lainnya'],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: [
                        'rgba(139, 69, 19, 0.8)',
                        'rgba(255, 255, 255, 0.8)',
                        'rgba(255, 215, 0, 0.8)',
                        'rgba(128, 0, 128, 0.8)'
                    ],
                    borderColor: [
                        'rgb(139, 69, 19)',
                        'rgb(200, 200, 200)',
                        'rgb(255, 215, 0)',
                        'rgb(128, 0, 128)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: Rp ${value.toLocaleString('id-ID')} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    function updateCharts(data) {
        // Update revenue vs cost chart
        revenueCostChart.data.datasets[0].data = [
            data.pendapatan.total,
            data.biaya.total,
            data.laba.kotor
        ];
        revenueCostChart.update();

        // Update cost distribution chart
        costDistributionChart.data.datasets[0].data = [
            data.biaya.kopi,
            data.biaya.susu,
            data.biaya.pemanis,
            data.biaya.topping
        ];
        costDistributionChart.update();
    }

    // ============================
    // UTILITY FUNCTIONS
    // ============================

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    function showLoadingState() {
        // You can add loading animation here
        console.log('Loading report data...');
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