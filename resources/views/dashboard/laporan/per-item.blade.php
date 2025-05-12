@extends('layouts.app')

@section('title', 'Laporan Per Item')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Laporan Per Item</h1>
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

<!-- Card: Stok Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="package" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: Kifa Bakery Pusat</h4>
            <p class="text-sm text-gray-600">Data yang ditampilkan adalah khusus untuk outlet Kifa Bakery Pusat.</p>
        </div>
    </div>
</div>

<!-- Analisis Produk -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header + Filter -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Produk</h1>
            <p class="text-sm text-gray-600">Daftar produk berdasarkan rentang tanggal untuk Kifa Bakery Pusat</p>
            
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
                <!-- Cari Produk/Kategori -->
                <div class="flex-1">
                    <h2 class="text-sm font-medium text-gray-800 mb-1">Cari Produk/Kategori</h2>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Cari..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card Template -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Penjualan</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp 12.450.000</h3>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+15% dari periode sebelumnya</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Kuantitas</p>
                    <h3 class="text-2xl font-bold text-gray-800">543 item</h3>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+8% dari periode sebelumnya</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800">125</h3>
                </div>
                <div class="p-3 rounded-full bg-orange-100 text-orange-500">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+12% dari periode sebelumnya</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rata-rata/Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp 87.840</h3>
                </div>
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <i data-lucide="bar-chart-2" class="w-6 h-6"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+3% dari periode sebelumnya</p>
        </div>
    </div>
    
    <!-- Tabel Produk -->
    <div class="overflow-x-auto mt-6">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">SKU</th>
                    <th class="py-3 font-bold">Nama Produk</th>
                    <th class="py-3 font-bold">Kategori</th>
                    <th class="py-3 font-bold text-right">Jumlah Order</th>
                    <th class="py-3 font-bold text-right">Total Kuantitas</th>
                    <th class="py-3 font-bold text-right">Total Penjualan</th>
                    <th class="py-3 font-bold text-right">Kontribusi (%)</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="productTableBody">
                <!-- Produk 1 -->
                <tr>
                    <td class="py-4 font-medium">KB-ROT-001</td>
                    <td class="py-4">Roti Tawar Gandum</td>
                    <td class="py-4">Roti</td>
                    <td class="py-4 text-right">78</td>
                    <td class="py-4 text-right">156</td>
                    <td class="py-4 text-right font-bold">Rp 2.340.000</td>
                    <td class="py-4 text-right">18.8%</td>
                </tr>
                
                <!-- Produk 2 -->
                <tr>
                    <td class="py-4 font-medium">KB-KUE-005</td>
                    <td class="py-4">Brownies Coklat</td>
                    <td class="py-4">Kue</td>
                    <td class="py-4 text-right">65</td>
                    <td class="py-4 text-right">130</td>
                    <td class="py-4 text-right font-bold">Rp 1.950.000</td>
                    <td class="py-4 text-right">15.7%</td>
                </tr>
                
                <!-- Produk 3 -->
                <tr>
                    <td class="py-4 font-medium">KB-PAS-012</td>
                    <td class="py-4">Pastel Sayur</td>
                    <td class="py-4">Pastry</td>
                    <td class="py-4 text-right">58</td>
                    <td class="py-4 text-right">116</td>
                    <td class="py-4 text-right font-bold">Rp 1.740.000</td>
                    <td class="py-4 text-right">14.0%</td>
                </tr>
                
                <!-- Produk 4 -->
                <tr>
                    <td class="py-4 font-medium">KB-KUE-008</td>
                    <td class="py-4">Donat Glaze</td>
                    <td class="py-4">Kue</td>
                    <td class="py-4 text-right">42</td>
                    <td class="py-4 text-right">84</td>
                    <td class="py-4 text-right font-bold">Rp 1.260.000</td>
                    <td class="py-4 text-right">10.1%</td>
                </tr>
                
                <!-- Produk 5 -->
                <tr>
                    <td class="py-4 font-medium">KB-ROT-003</td>
                    <td class="py-4">Roti Sobek Keju</td>
                    <td class="py-4">Roti</td>
                    <td class="py-4 text-right">35</td>
                    <td class="py-4 text-right">70</td>
                    <td class="py-4 text-right font-bold">Rp 1.050.000</td>
                    <td class="py-4 text-right">8.4%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    // Initialize date range picker
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["today", "today"],
        locale: "id",
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length === 2) {
                // Automatically filter data when both dates are selected
                filterData(selectedDates[0], selectedDates[1]);
            }
        }
    });
    
    // Search input handler
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#productTableBody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        if (searchTerm) {
            showAlert('info', `Menampilkan hasil pencarian: ${searchTerm}`);
        }
    });
    
    // Filter data function
    function filterData(startDate, endDate) {
        // In a real app, you would make an AJAX request here
        console.log(`Filter data dari ${startDate} sampai ${endDate}`);
        showAlert('success', `Menampilkan data dari ${formatDate(startDate)} sampai ${formatDate(endDate)}`);
        
        // Simulate loading
        const rows = document.querySelectorAll('#productTableBody tr');
        rows.forEach(row => row.style.display = 'none');
        
        setTimeout(() => {
            rows.forEach(row => row.style.display = '');
        }, 500);
    }
    
    // Format date to Indonesian format
    function formatDate(date) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }
    
    // Print report function
    function printReport() {
        showAlert('info', 'Mempersiapkan laporan untuk dicetak...');
        // In a real app, this would open print dialog or redirect to print page
        setTimeout(() => {
            window.print();
        }, 1000);
    }
    
    // Export report function
    function exportReport() {
        showAlert('info', 'Mempersiapkan laporan untuk diekspor...');
        // In a real app, this would generate and download a file
        setTimeout(() => {
            const a = document.createElement('a');
            a.href = 'data:text/csv;charset=utf-8,';
            a.download = `laporan-peritem-${new Date().toISOString().slice(0,10)}.csv`;
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
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
</script>

@endsection