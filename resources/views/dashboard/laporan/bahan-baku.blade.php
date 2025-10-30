@extends('layouts.app')

@section('title', 'Laporan Bahan Baku')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-4xl font-bold text-gray-800">Laporan Bahan Baku</h1>
        <div class="flex gap-2">
            <button onclick="printReport()" class="px-4 py-2 bg-white text-orange-500 border border-orange-500 rounded-lg hover:bg-orange-50 flex items-center gap-2">
                <i data-lucide="printer" class="w-5 h-5"></i>
                Cetak
            </button>
            <button onclick="exportReport()" class="px-4 py-2 bg-white text-green-600 border border-green-600 rounded-lg hover:bg-green-50 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Ekspor
            </button>
        </div>
    </div>
</div>

<!-- Card: Info Outlet -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: <span id="outletName">Outlet 1</span></h4>
            <p class="text-sm text-gray-600">Periode: <span id="dateRangeDisplay">01 Mei 2025 - 14 Mei 2025</span></p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Laporan Bahan Baku</h1>
    <p class="text-sm text-gray-600">Penggunaan bahan baku berdasarkan order di <span id="outletName2">Outlet 1</span></p>
    
    <!-- Filter + Search -->
    <div class="flex flex-col md:flex-row md:items-end gap-4 mt-4 w-full">
        <!-- Filter Tanggal -->
        <div class="flex-1">
            <h2 class="text-sm font-medium text-gray-800 mb-1">Rentang Tanggal</h2>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
                    </span>
                    <input type="text" id="dateRange" placeholder="Pilih rentang tanggal"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6b0d]" />
                </div>
            </div>
        </div>
        <!-- Cari Order/Produk -->
        <div class="flex-1">
            <h2 class="text-sm font-medium text-gray-800 mb-1">Cari Order/Produk</h2>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                </span>
                <input type="text" id="searchInput" placeholder="Cari nomor order atau produk..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6b0d]" />
            </div>
        </div>
    </div>

    <!-- Loading state -->
    <div id="loadingState" class="py-12 flex flex-col items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" 
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
             class="animate-spin text-[#3b6b0d]">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        <span class="text-gray-500">Memuat data...</span>
    </div>

    <!-- No data state -->
    <div id="noDataState" class="py-12 flex flex-col items-center justify-center hidden">
        <i data-lucide="package-x" class="w-16 h-16 text-gray-400"></i>
        <p class="mt-4 text-gray-600">Tidak ada data untuk periode yang dipilih</p>
    </div>

    <!-- Content area (tables will be inserted here) -->
    <div id="tablesContainer" class="mt-5 space-y-8 hidden">
        <!-- Table: Bahan Baku Pembelian -->
        <div id="purchaseContainer" class="hidden">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="shopping-cart" class="w-5 h-5 text-purple-500"></i>
                Bahan Baku - Pembelian
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-700 bg-gray-50">
                        <tr>
                            <th class="py-3 font-bold px-4">No. Order</th>
                            <th class="py-3 font-bold px-4">Produk</th>
                            <th class="py-3 font-bold px-4">Tanggal</th>
                            <th class="py-3 font-bold px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y" id="purchaseTable">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table: Bahan Baku Produksi -->
        <div id="productionContainer" class="hidden">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i data-lucide="factory" class="w-5 h-5 text-blue-500"></i>
                Bahan Baku - Produksi
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-700 bg-gray-50">
                        <tr>
                            <th class="py-3 font-bold px-4">No. Order</th>
                            <th class="py-3 font-bold px-4">Produk</th>
                            <th class="py-3 font-bold px-4">Tanggal</th>
                            <th class="py-3 font-bold px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y" id="productionTable">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Bahan Baku -->
<div id="materialDetailModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-overlay absolute inset-0 bg-gray-900 opacity-50"></div>
    
    <div class="modal-container bg-white w-11/12 md:max-w-4xl mx-auto rounded-xl shadow-lg z-50 overflow-y-auto max-h-[90vh]">
        <!-- Modal Header -->
        <div class="modal-header px-6 py-4 border-b flex justify-between items-center bg-gray-50 rounded-t-xl">
            <div>
                <h3 class="text-xl font-bold text-gray-800" id="modalOrderNumber">Detail Bahan Baku</h3>
                <p class="text-sm text-gray-600" id="modalProductName"></p>
            </div>
            <button onclick="closeMaterialModal()" class="text-gray-400 hover:text-gray-600 close-modal">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="modal-content px-6 py-4">
            <!-- Info Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Jenis</p>
                    <p class="text-lg font-semibold text-gray-800" id="modalType">Produksi</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Tanggal</p>
                    <p class="text-lg font-semibold text-gray-800" id="modalDate">15 Mei 2025</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Total Bahan</p>
                    <p class="text-lg font-semibold text-gray-800" id="modalTotalMaterials">5 items</p>
                </div>
            </div>

            <!-- Detail Bahan Baku -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    <i data-lucide="package" class="w-5 h-5 text-[#3b6b0d]"></i>
                    Detail Penggunaan Bahan Baku
                </h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-700 bg-gray-50">
                            <tr>
                                <th class="py-3 font-bold px-4">Bahan Baku</th>
                                <th class="py-3 font-bold px-4 text-right">Stok Sebelum</th>
                                <th class="py-3 font-bold px-4 text-right">Bahan Digunakan</th>
                                <th class="py-3 font-bold px-4 text-right">Stok Sesudah</th>
                                <th class="py-3 font-bold px-4">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y" id="materialDetailTable">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Catatan -->
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <h5 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-yellow-600"></i>
                    Catatan
                </h5>
                <p class="text-sm text-gray-600" id="modalNotes">- Tidak ada catatan khusus -</p>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="modal-footer px-6 py-4 border-t bg-gray-50 rounded-b-xl flex justify-end gap-2">
            <button onclick="closeMaterialModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
    // Data storage
    let materialData = [];
    let groupedData = {};
    let currentStartDate;
    let currentEndDate;

    document.addEventListener('DOMContentLoaded', function() {
        initializePage();
    });

    function initializePage() {
        // Set default dates
        const defaultDates = getDefaultDateRange();
        currentStartDate = formatDateForAPI(defaultDates[0]);
        currentEndDate = formatDateForAPI(defaultDates[1]);
        
        // Set display
        document.getElementById('dateRangeDisplay').textContent = 
            `${formatDateForDisplay(defaultDates[0])} - ${formatDateForDisplay(defaultDates[1])}`;
        
        // Initialize date picker
        initializeDatePicker();
        
        // Load initial data
        fetchMaterialData(currentStartDate, currentEndDate);
        
        // Initialize Lucide icons
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function getDefaultDateRange() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        return [firstDay, today];
    }

    function formatDateForAPI(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function formatDateForDisplay(date) {
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }

    function initializeDatePicker() {
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "d M Y",
            defaultDate: getDefaultDateRange(),
            locale: "id",
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length === 2) {
                    currentStartDate = formatDateForAPI(selectedDates[0]);
                    currentEndDate = formatDateForAPI(selectedDates[1]);
                    
                    const displayStartDate = formatDateForDisplay(selectedDates[0]);
                    const displayEndDate = formatDateForDisplay(selectedDates[1]);
                    
                    document.getElementById('dateRangeDisplay').textContent = `${displayStartDate} - ${displayEndDate}`;
                    
                    // Fetch data dengan tanggal baru
                    fetchMaterialData(currentStartDate, currentEndDate);
                    
                    showAlert('info', `Memuat data dari ${displayStartDate} sampai ${displayEndDate}`);
                }
            }
        });
    }

    // Fetch data dari API
    function fetchMaterialData(startDate, endDate) {
        showLoading(true);
        
        // Build URL dengan parameter tanggal
        let url = '/api/get-stock-history';
        if (startDate && endDate) {
            url += `?start_date=${startDate}&end_date=${endDate}`;
        }
        
        fetch(url, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            materialData = data.data || [];
            processMaterialData(materialData);
            showLoading(false);
            showAlert('success', 'Data laporan berhasil dimuat');
        })
        .catch(error => {
            console.error('Error fetching material data:', error);
            showAlert('error', 'Gagal memuat data. Silakan coba lagi nanti.');
            showLoading(false);
            showNoData(true);
        });
    }

    // Process data dari API response
    function processMaterialData(data) {
        // Reset grouped data
        groupedData = {
            purchase: {},
            production: {}
        };

        // Group data berdasarkan order_id dan type
        data.forEach(item => {
            const type = item.type; // 'purchase' atau 'production'
            const orderKey = item.order_id ? `order-${item.order_id}` : `product-${item.product_id}-${item.created_at}`;
            
            if (!groupedData[type][orderKey]) {
                groupedData[type][orderKey] = {
                    order_number: item.order ? item.order.order_number : 'Stok Awal',
                    product_name: item.product ? item.product.name : 'Produksi Stok Awal',
                    date: item.created_at,
                    notes: item.notes,
                    materials: []
                };
            }
            
            // Add material to the group
            groupedData[type][orderKey].materials.push({
                name: item.raw_material.name,
                stock_before: parseFloat(item.stock_before),
                material_used: parseFloat(item.quantity_change),
                stock_after: parseFloat(item.stock_after),
                unit: item.raw_material.unit
            });
        });

        // Display the processed data
        displayMaterialData();
    }

    // Display data ke dalam tabel
    function displayMaterialData() {
        // Reset tables
        document.getElementById('purchaseTable').innerHTML = '';
        document.getElementById('productionTable').innerHTML = '';
        
        // Check if we have data
        const hasPurchaseData = Object.keys(groupedData.purchase).length > 0;
        const hasProductionData = Object.keys(groupedData.production).length > 0;
        
        if (!hasPurchaseData && !hasProductionData) {
            showNoData(true);
            document.getElementById('tablesContainer').classList.add('hidden');
            return;
        }
        
        // Display purchase data
        if (hasPurchaseData) {
            Object.keys(groupedData.purchase).forEach(key => {
                const group = groupedData.purchase[key];
                addTableRow('purchaseTable', group, key, 'purchase');
            });
            document.getElementById('purchaseContainer').classList.remove('hidden');
        } else {
            document.getElementById('purchaseContainer').classList.add('hidden');
        }
        
        // Display production data
        if (hasProductionData) {
            Object.keys(groupedData.production).forEach(key => {
                const group = groupedData.production[key];
                addTableRow('productionTable', group, key, 'production');
            });
            document.getElementById('productionContainer').classList.remove('hidden');
        } else {
            document.getElementById('productionContainer').classList.add('hidden');
        }
        
        // Show tables container
        document.getElementById('tablesContainer').classList.remove('hidden');
        showNoData(false);
    }

    // Add row to table
    function addTableRow(tableId, group, key, type) {
        const table = document.getElementById(tableId);
        const row = document.createElement('tr');
        
        const date = new Date(group.date);
        const formattedDate = date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        
        row.innerHTML = `
            <td class="py-4 px-4">${group.order_number}</td>
            <td class="py-4 px-4">${group.product_name}</td>
            <td class="py-4 px-4">${formattedDate}</td>
            <td class="py-4 px-4 text-right">
                <button onclick="showMaterialDetail('${type}', '${key}', '${group.order_number}', '${group.product_name}')" 
                        class="text-[#3b6b0d] hover:text-[#335e0c] flex items-center gap-1 justify-end w-full">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    Detail
                </button>
            </td>
        `;
        table.appendChild(row);
    }

    function showMaterialDetail(type, key, orderNumber, productName) {
        const group = groupedData[type][key];
        if (!group) return;
        
        // Set modal content
        document.getElementById('modalOrderNumber').textContent = orderNumber;
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalType').textContent = type === 'purchase' ? 'Pembelian' : 'Produksi';
        
        const date = new Date(group.date);
        document.getElementById('modalDate').textContent = date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        
        document.getElementById('modalTotalMaterials').textContent = `${group.materials.length} bahan`;
        document.getElementById('modalNotes').textContent = group.notes || '- Tidak ada catatan -';
        
        // Populate materials table
        const table = document.getElementById('materialDetailTable');
        table.innerHTML = '';
        
        group.materials.forEach(material => {
            const row = document.createElement('tr');
            const changeClass = material.material_used >= 0 ? 'text-green-600' : 'text-red-600';
            const changePrefix = material.material_used >= 0 ? '+' : '';
            
            row.innerHTML = `
                <td class="py-3 px-4">${material.name}</td>
                <td class="py-3 px-4 text-right">${material.stock_before}</td>
                <td class="py-3 px-4 text-right ${changeClass}">${changePrefix}${material.material_used}</td>
                <td class="py-3 px-4 text-right">${material.stock_after}</td>
                <td class="py-3 px-4">${material.unit}</td>
            `;
            table.appendChild(row);
        });
        
        // Show modal
        document.getElementById('materialDetailModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Re-initialize Lucide icons in modal
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function closeMaterialModal() {
        document.getElementById('materialDetailModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = this.value.trim().toLowerCase();
        
        // Filter purchase table
        filterTable('purchaseTable', searchTerm);
        
        // Filter production table
        filterTable('productionTable', searchTerm);
        
        // Show/hide containers based on results
        document.getElementById('purchaseContainer').classList.toggle('hidden', 
            !hasVisibleRows('purchaseTable'));
        document.getElementById('productionContainer').classList.toggle('hidden', 
            !hasVisibleRows('productionTable'));
    });

    function filterTable(tableId, searchTerm) {
        const rows = document.querySelectorAll(`#${tableId} tr`);
        
        rows.forEach(row => {
            const orderCell = row.querySelector('td:first-child');
            const productCell = row.querySelector('td:nth-child(2)');
            
            if (orderCell && productCell) {
                const orderText = orderCell.textContent.toLowerCase();
                const productText = productCell.textContent.toLowerCase();
                
                if (orderText.includes(searchTerm) || productText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    function hasVisibleRows(tableId) {
        const rows = document.querySelectorAll(`#${tableId} tr`);
        return Array.from(rows).some(row => row.style.display !== 'none');
    }

    function showLoading(show) {
        document.getElementById('loadingState').style.display = show ? 'flex' : 'none';
        document.getElementById('tablesContainer').classList.toggle('hidden', show);
    }

    function showNoData(show) {
        document.getElementById('noDataState').style.display = show ? 'flex' : 'none';
    }

    function printReport() {
        if (materialData.length === 0) {
            showAlert('error', 'Tidak ada data untuk dicetak');
            return;
        }

        showAlert('info', 'Mempersiapkan laporan untuk dicetak...');
        // Implement print functionality here
        setTimeout(() => {
            showAlert('success', 'Laporan siap untuk dicetak');
        }, 1000);
    }

    function exportReport() {
        if (materialData.length === 0) {
            showAlert('error', 'Tidak ada data untuk diekspor');
            return;
        }

        showAlert('info', 'Mempersiapkan laporan untuk diekspor...');
        // Implement export functionality here
        setTimeout(() => {
            showAlert('success', 'Laporan berhasil diekspor');
        }, 1000);
    }

    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md ${type === 'error' ? 'bg-red-100 text-red-700' : 
                        type === 'success' ? 'bg-green-100 text-[#3b6b0d]' : 'bg-orange-100 text-orange-700'}`;
        alert.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : 
                                    type === 'success' ? 'check-circle' : 'info'}" 
                    class="w-5 h-5"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        `;
        alertContainer.appendChild(alert);
        
        if (window.lucide) {
            lucide.createIcons();
        }
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
</script>

<style>
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background-color: #3b6b0d;
        color: white;
        border-color: #3b6b0d;
    }

    .flatpickr-day.selected:hover,
    .flatpickr-day.startRange:hover,
    .flatpickr-day.endRange:hover {
        background-color: #335e0c;
        color: white;
        border-color: #335e0c;
    }

    .flatpickr-day.inRange {
        background-color: #dcfce7;
        color: #166534;
    }

    .flatpickr-day:hover {
        background-color: #bbf7d0;
        color: black;
    }

    .flatpickr-day:focus {
        outline: none;
        box-shadow: 0 0 0 2px #86efac;
    }

    .flatpickr-day.today:not(.selected):not(.inRange) {
        border: 1px solid #3b6b0d;
        background-color: #f0fdf4;
    }
</style>

@endsection