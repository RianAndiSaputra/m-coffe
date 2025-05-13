@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Laporan Stok</h1>
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

<!-- Produk Dengan Stock Masuk Terbanyak -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Stok</h1>
        <p class="text-sm text-gray-600">Perubahan stok produk di Kifa Bakery Pusat</p>
        
        <!-- Filter + Search -->
        <div class="flex flex-col md:flex-row md:items-end gap-4 mt-3 w-full">
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
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        <!-- Total Saldo Awal -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Saldo Awal</p>
                    <h3 class="text-2xl font-bold text-gray-800">0 pcs</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <i data-lucide="box" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Stock Masuk -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Stock Masuk</p>
                    <h3 class="text-2xl font-bold text-gray-800">0 pcs</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-full">
                    <i data-lucide="arrow-down-circle" class="w-6 h-6 text-green-500"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Stock Keluar -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Stock Keluar</p>
                    <h3 class="text-2xl font-bold text-gray-800">0 pcs</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-full">
                    <i data-lucide="arrow-up-circle" class="w-6 h-6 text-red-500"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Stock Akhir -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Stock Akhir</p>
                    <h3 class="text-2xl font-bold text-gray-800">0 pcs</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-full">
                    <i data-lucide="package-check" class="w-6 h-6 text-purple-500"></i>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-xl font-bold text-gray-800 mt-8 flex items-center gap-2">
        <i data-lucide="package-plus" class="w-5 h-5 text-green-500"></i>
        Produk Dengan Stock Masuk Terbanyak
    </h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 bg-gray-50">
                <tr>
                    <th class="py-3 font-bold px-4">Produk</th>
                    <th class="py-3 font-bold px-4 text-right">Qty</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="stockInTable">
                <tr>
                    <td class="py-4 px-4">Roti Tawar Gandum</td>
                    <td class="py-4 px-4 text-right">120 pcs</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">Brownies Coklat</td>
                    <td class="py-4 px-4 text-right">95 pcs</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">Donat Glaze</td>
                    <td class="py-4 px-4 text-right">80 pcs</td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="text-xl font-bold text-gray-800 mb-4 mt-6 flex items-center gap-2">
        <i data-lucide="package-minus" class="w-5 h-5 text-red-500"></i>
        Produk Dengan Stock Keluar Terbanyak
    </h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 bg-gray-50">
                <tr>
                    <th class="py-3 font-bold px-4">Produk</th>
                    <th class="py-3 font-bold px-4 text-right">Qty</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="stockOutTable">
                <tr>
                    <td class="py-4 px-4">Roti Tawar Gandum</td>
                    <td class="py-4 px-4 text-right">150 pcs</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">Brownies Coklat</td>
                    <td class="py-4 px-4 text-right">110 pcs</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">Donat Glaze</td>
                    <td class="py-4 px-4 text-right">90 pcs</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    // Data contoh untuk simulasi
    const stockData = {
        stockIn: [
            { product: 'Roti Tawar Gandum', qty: 120 },
            { product: 'Brownies Coklat', qty: 95 },
            { product: 'Donat Glaze', qty: 80 },
            { product: 'Pastel Sayur', qty: 75 },
            { product: 'Roti Sobek Keju', qty: 60 }
        ],
        stockOut: [
            { product: 'Roti Tawar Gandum', qty: 150 },
            { product: 'Brownies Coklat', qty: 110 },
            { product: 'Donat Glaze', qty: 90 },
            { product: 'Pastel Sayur', qty: 85 },
            { product: 'Roti Sobek Keju', qty: 70 }
        ]
    };

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
        const selectedDates = dateRangePicker.selectedDates;
        
        // Filter data berdasarkan pencarian
        const filteredStockIn = stockData.stockIn.filter(item => 
            item.product.toLowerCase().includes(searchTerm)
        );
        
        const filteredStockOut = stockData.stockOut.filter(item => 
            item.product.toLowerCase().includes(searchTerm)
        );
        
        // Update tabel stock masuk
        const stockInTable = document.getElementById('stockInTable');
        stockInTable.innerHTML = '';
        filteredStockIn.forEach(item => {
            stockInTable.innerHTML += `
                <tr>
                    <td class="py-4 px-4">${item.product}</td>
                    <td class="py-4 px-4 text-right">${item.qty} pcs</td>
                </tr>
            `;
        });
        
        // Update tabel stock keluar
        const stockOutTable = document.getElementById('stockOutTable');
        stockOutTable.innerHTML = '';
        filteredStockOut.forEach(item => {
            stockOutTable.innerHTML += `
                <tr>
                    <td class="py-4 px-4">${item.product}</td>
                    <td class="py-4 px-4 text-right">${item.qty} pcs</td>
                </tr>
            `;
        });
        
        // Update summary cards jika ada filter tanggal
        if (selectedDates.length === 2) {
            // Di aplikasi nyata, ini akan diisi dengan data dari API
            // Contoh simulasi:
            const totalIn = filteredStockIn.reduce((sum, item) => sum + item.qty, 0);
            const totalOut = filteredStockOut.reduce((sum, item) => sum + item.qty, 0);
            
            document.querySelectorAll('.bg-white.rounded-lg.shadow.p-4')[1].querySelector('h3').textContent = `${totalIn} pcs`;
            document.querySelectorAll('.bg-white.rounded-lg.shadow.p-4')[2].querySelector('h3').textContent = `${totalOut} pcs`;
        }
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
            a.download = `laporan-stok-${new Date().toISOString().slice(0,10)}.csv`;
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