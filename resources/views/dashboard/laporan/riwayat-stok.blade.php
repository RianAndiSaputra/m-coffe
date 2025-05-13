@extends('layouts.app')

@section('title', 'Riwayat Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Riwayat Stok</h1>
        <div class="flex gap-2">
            <button onclick="printReport()" class="px-4 py-2 bg-white text-orange-500 border border-orange-500 rounded-lg hover:bg-orange-50 flex items-center gap-2">
                <i data-lucide="printer" class="w-5 h-5"></i>
                Cetak
            </button>
            <button onclick="exportReport()" class="px-4 py-2 bg-white text-green-500 border border-green-500 rounded-lg hover:bg-green-50 flex items-center gap-2">
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
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: Kifa Bakery Pusat</h4>
            <p class="text-sm text-gray-600">Periode: <span id="dateRangeDisplay">s/d {{ date('d M Y') }}</span></p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
     <h1 class="text-3xl font-bold text-gray-800">Laporan Stok</h1>
        <p class="text-sm text-gray-600">Perubahan stok produk di Kifa Bakery Pusat</p>
        
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
                        class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                </div>
            </div>
        </div>
        <!-- Cari Produk -->
        <div class="flex-1">
            <h2 class="text-sm font-medium text-gray-800 mb-1">Cari Produk</h2>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                </span>
                <input type="text" id="searchInput" placeholder="Cari produk..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
            </div>
        </div>
    </div>

    <!-- Tabel Penyesuaian Stok -->
    <div class="mt-5">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="package-plus" class="w-5 h-5 text-blue-500"></i>
            Penyesuaian Stok
        </h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-gray-700 bg-gray-50">
                    <tr>
                        <th class="py-3 font-bold px-4">Produk</th>
                        <th class="py-3 font-bold px-4">SKU</th>
                        <th class="py-3 font-bold px-4 text-right">Stok Akhir</th>
                        <th class="py-3 font-bold px-4 text-right">Total Perubahan</th>
                        <th class="py-3 font-bold px-4 text-right">Total Entri</th>
                        <th class="py-3 font-bold px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y" id="adjustmentTable">
                    <tr>
                        <td class="py-4 px-4">Roti Tawar Gandum</td>
                        <td class="py-4 px-4">SKU-001</td>
                        <td class="py-4 px-4 text-right">120 pcs</td>
                        <td class="py-4 px-4 text-right">+20 pcs</td>
                        <td class="py-4 px-4 text-right">2</td>
                        <td class="py-4 px-4 text-right">
                            <button onclick="showStockHistory('adjustment', 'Roti Tawar Gandum', 'SKU-001')" class="text-orange-500 hover:text-orange-700 flex items-center gap-1 justify-end w-full">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 px-4">Brownies Coklat</td>
                        <td class="py-4 px-4">SKU-002</td>
                        <td class="py-4 px-4 text-right">95 pcs</td>
                        <td class="py-4 px-4 text-right">-5 pcs</td>
                        <td class="py-4 px-4 text-right">1</td>
                        <td class="py-4 px-4 text-right">
                            <button onclick="showStockHistory('adjustment', 'Brownies Coklat', 'SKU-002')" class="text-orange-500 hover:text-orange-700 flex items-center gap-1 justify-end w-full">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Kiriman Pabrik -->
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="truck" class="w-5 h-5 text-green-500"></i>
            Kiriman Pabrik
        </h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-gray-700 bg-gray-50">
                    <tr>
                        <th class="py-3 font-bold px-4">Produk</th>
                        <th class="py-3 font-bold px-4">SKU</th>
                        <th class="py-3 font-bold px-4 text-right">Stok Akhir</th>
                        <th class="py-3 font-bold px-4 text-right">Total Perubahan</th>
                        <th class="py-3 font-bold px-4 text-right">Total Entri</th>
                        <th class="py-3 font-bold px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y" id="shipmentTable">
                    <tr>
                        <td class="py-4 px-4">Donat Glaze</td>
                        <td class="py-4 px-4">SKU-003</td>
                        <td class="py-4 px-4 text-right">80 pcs</td>
                        <td class="py-4 px-4 text-right">+30 pcs</td>
                        <td class="py-4 px-4 text-right">1</td>
                        <td class="py-4 px-4 text-right">
                            <button onclick="showStockHistory('shipment', 'Donat Glaze', 'SKU-003')" class="text-orange-500 hover:text-orange-700 flex items-center gap-1 justify-end w-full">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 px-4">Pastel Sayur</td>
                        <td class="py-4 px-4">SKU-004</td>
                        <td class="py-4 px-4 text-right">75 pcs</td>
                        <td class="py-4 px-4 text-right">+25 pcs</td>
                        <td class="py-4 px-4 text-right">1</td>
                        <td class="py-4 px-4 text-right">
                            <button onclick="showStockHistory('shipment', 'Pastel Sayur', 'SKU-004')" class="text-orange-500 hover:text-orange-700 flex items-center gap-1 justify-end w-full">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
@include('partials.laporan.modal-riwayat-stok')

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

<script>
    // Initialize date range picker
    const dateRangePicker = flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["today", "today"],
        locale: "id",
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length === 2) {
                const startDate = formatDate(selectedDates[0]);
                const endDate = formatDate(selectedDates[1]);
                document.getElementById('dateRangeDisplay').textContent = `${startDate} - ${endDate}`;
                filterData();
                showAlert('success', `Menampilkan data dari ${startDate} sampai ${endDate}`);
            }
        }
    });

    // Format date to Indonesian format
    function formatDate(date) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    // Search input handler
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        filterData();
    });

    // Filter data function
    function filterData() {
        const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
        
        // In a real app, this would be an API call with the search term and date range
        // For demo, we'll just filter the existing data
        const rows = document.querySelectorAll('#adjustmentTable tr, #shipmentTable tr');
        rows.forEach(row => {
            const productName = row.querySelector('td:first-child').textContent.toLowerCase();
            if (productName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Show stock history modal
    function showStockHistory(type, productName, sku) {
        // Set modal content based on type and product
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalSKU').textContent = sku;
        
        // These values would come from API in real app
        document.getElementById('modalEndStock').textContent = type === 'adjustment' ? 
            (productName.includes('Roti') ? '120 pcs' : '95 pcs') : 
            (productName.includes('Donat') ? '80 pcs' : '75 pcs');
            
        document.getElementById('modalTotalChange').textContent = type === 'adjustment' ? 
            (productName.includes('Roti') ? '+20' : '-5') : 
            (productName.includes('Donat') ? '+30' : '+25');
            
        document.getElementById('modalTotalEntries').textContent = type === 'adjustment' ? 
            (productName.includes('Roti') ? '2' : '1') : '1';
        
        // Populate history table - in real app this would come from API
        const historyTable = document.getElementById('historyEntries');
        historyTable.innerHTML = '';
        
        if (type === 'adjustment') {
            if (productName.includes('Roti')) {
                historyTable.innerHTML = `
                    <tr>
                        <td class="py-3 px-4">09 Mei 2025 14:50</td>
                        <td class="py-3 px-4 text-right">100 pcs</td>
                        <td class="py-3 px-4 text-right">110 pcs</td>
                        <td class="py-3 px-4 text-right">+10 pcs</td>
                        <td class="py-3 px-4">Penyesuaian stok manual</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4">08 Mei 2025 10:20</td>
                        <td class="py-3 px-4 text-right">110 pcs</td>
                        <td class="py-3 px-4 text-right">120 pcs</td>
                        <td class="py-3 px-4 text-right">+10 pcs</td>
                        <td class="py-3 px-4">Penerimaan dari gudang</td>
                    </tr>
                `;
            } else {
                historyTable.innerHTML = `
                    <tr>
                        <td class="py-3 px-4">07 Mei 2025 16:30</td>
                        <td class="py-3 px-4 text-right">100 pcs</td>
                        <td class="py-3 px-4 text-right">95 pcs</td>
                        <td class="py-3 px-4 text-right">-5 pcs</td>
                        <td class="py-3 px-4">Koreksi stok rusak</td>
                    </tr>
                `;
            }
        } else {
            if (productName.includes('Donat')) {
                historyTable.innerHTML = `
                    <tr>
                        <td class="py-3 px-4">06 Mei 2025 11:15</td>
                        <td class="py-3 px-4 text-right">50 pcs</td>
                        <td class="py-3 px-4 text-right">80 pcs</td>
                        <td class="py-3 px-4 text-right">+30 pcs</td>
                        <td class="py-3 px-4">Kiriman dari pabrik utama</td>
                    </tr>
                `;
            } else {
                historyTable.innerHTML = `
                    <tr>
                        <td class="py-3 px-4">05 Mei 2025 09:45</td>
                        <td class="py-3 px-4 text-right">50 pcs</td>
                        <td class="py-3 px-4 text-right">75 pcs</td>
                        <td class="py-3 px-4 text-right">+25 pcs</td>
                        <td class="py-3 px-4">Kiriman dari pabrik cabang</td>
                    </tr>
                `;
            }
        }
        
        // Show modal
        const modal = new Modal(document.getElementById('stockHistoryModal'));
        modal.show();
    }

    // Print report function
    function printReport() {
        showAlert('info', 'Mempersiapkan laporan untuk dicetak...');
        setTimeout(() => {
            window.print();
        }, 1000);
    }
    
    // Export report function
    function exportReport() {
        showAlert('info', 'Mempersiapkan laporan untuk diekspor...');
        setTimeout(() => {
            const a = document.createElement('a');
            a.href = 'data:text/csv;charset=utf-8,';
            a.download = `riwayat-stok-${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            showAlert('success', 'Laporan berhasil diekspor');
        }, 1000);
    }
    
    // Show alert function
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md ${type === 'error' ? 'bg-red-100 text-red-700' : 
                         type === 'success' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'}`;
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
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
</script>

@endsection