@extends('layouts.app')

@section('title', 'Laporan Per Kategori')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Laporan Per Kategori</h1>
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
            <p class="text-sm text-gray-600">Data yang ditampilkan adalah khusus untuk outlet Kifa Bakery Pusat.</p>
        </div>
    </div>
</div>

<!-- Analisis Kategori -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header + Filter -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Analisis Per Kategori</h1>
            <p class="text-sm text-gray-600">Grafik dan analisis penjualan berdasarkan kategori produk</p>
            
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
                <!-- Cari Kategori -->
                <div class="flex-1">
                    <h2 class="text-sm font-medium text-gray-800 mb-1">Cari Kategori</h2>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Cari kategori..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Grafik Batang -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Total Pendapatan per Kategori</h2>
                <div class="h-80">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="bg-gray-100 rounded-lg shadow p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                        <h3 class="text-2xl font-bold text-gray-800">5</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <h3 class="text-2xl font-bold text-gray-800">28</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-600">Total Kuantitas</p>
                        <h3 class="text-2xl font-bold text-gray-800">543</h3>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-600">Total Penjualan</p>
                        <h3 class="text-2xl font-bold text-gray-800">Rp 12.450.000</h3>
                    </div>
                </div>
            </div>

            <!-- Kategori: Cake -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="cake" class="w-5 h-5 text-pink-500"></i>
                    Cake
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-700 bg-gray-50">
                            <tr>
                                <th class="py-3 font-bold px-4">SKU</th>
                                <th class="py-3 font-bold px-4">Nama Produk</th>
                                <th class="py-3 font-bold px-4 text-right">Kuantitas</th>
                                <th class="py-3 font-bold px-4 text-right">Penjualan</th>
                                <th class="py-3 font-bold px-4 text-right">Kontribusi (%)</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y">
                            <tr>
                                <td class="py-4 font-medium px-4">KB-CAK-001</td>
                                <td class="py-4 px-4">Black Forest</td>
                                <td class="py-4 px-4 text-right">45</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 1.350.000</td>
                                <td class="py-4 px-4 text-right">10.8%</td>
                            </tr>
                            <tr>
                                <td class="py-4 font-medium px-4">KB-CAK-002</td>
                                <td class="py-4 px-4">Red Velvet</td>
                                <td class="py-4 px-4 text-right">38</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 1.140.000</td>
                                <td class="py-4 px-4 text-right">9.2%</td>
                            </tr>
                            <tr>
                                <td class="py-4 font-medium px-4">KB-CAK-003</td>
                                <td class="py-4 px-4">Cheesecake</td>
                                <td class="py-4 px-4 text-right">32</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 960.000</td>
                                <td class="py-4 px-4 text-right">7.7%</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">
                            <tr>
                                <td class="py-3 px-4" colspan="2">Total Cake</td>
                                <td class="py-3 px-4 text-right">115</td>
                                <td class="py-3 px-4 text-right">Rp 3.450.000</td>
                                <td class="py-3 px-4 text-right">27.7%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Kategori: Roti -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="croissant" class="w-5 h-5 text-amber-500"></i>
                    Roti
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-700 bg-gray-50">
                            <tr>
                                <th class="py-3 font-bold px-4">SKU</th>
                                <th class="py-3 font-bold px-4">Nama Produk</th>
                                <th class="py-3 font-bold px-4 text-right">Kuantitas</th>
                                <th class="py-3 font-bold px-4 text-right">Penjualan</th>
                                <th class="py-3 font-bold px-4 text-right">Kontribusi (%)</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y">
                            <tr>
                                <td class="py-4 font-medium px-4">KB-ROT-001</td>
                                <td class="py-4 px-4">Roti Tawar Gandum</td>
                                <td class="py-4 px-4 text-right">78</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 1.170.000</td>
                                <td class="py-4 px-4 text-right">9.4%</td>
                            </tr>
                            <tr>
                                <td class="py-4 font-medium px-4">KB-ROT-002</td>
                                <td class="py-4 px-4">Roti Sobek Coklat</td>
                                <td class="py-4 px-4 text-right">65</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 975.000</td>
                                <td class="py-4 px-4 text-right">7.8%</td>
                            </tr>
                            <tr>
                                <td class="py-4 font-medium px-4">KB-ROT-003</td>
                                <td class="py-4 px-4">Roti Keju</td>
                                <td class="py-4 px-4 text-right">42</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 630.000</td>
                                <td class="py-4 px-4 text-right">5.1%</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">
                            <tr>
                                <td class="py-3 px-4" colspan="2">Total Roti</td>
                                <td class="py-3 px-4 text-right">185</td>
                                <td class="py-3 px-4 text-right">Rp 2.775.000</td>
                                <td class="py-3 px-4 text-right">22.3%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        <!-- Kategori: Pastry -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-emerald-500"></i>
                    Pastry
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-700 bg-gray-50">
                            <tr>
                                <th class="py-3 font-bold px-4">SKU</th>
                                <th class="py-3 font-bold px-4">Nama Produk</th>
                                <th class="py-3 font-bold px-4 text-right">Kuantitas</th>
                                <th class="py-3 font-bold px-4 text-right">Penjualan</th>
                                <th class="py-3 font-bold px-4 text-right">Kontribusi (%)</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 divide-y">
                            <tr>
                                <td class="py-4 font-medium px-4">KB-PAS-001</td>
                                <td class="py-4 px-4">Croissant</td>
                                <td class="py-4 px-4 text-right">56</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 1.120.000</td>
                                <td class="py-4 px-4 text-right">9.0%</td>
                            </tr>
                            <tr>
                                <td class="py-4 font-medium px-4">KB-PAS-002</td>
                                <td class="py-4 px-4">Danish Pastry</td>
                                <td class="py-4 px-4 text-right">48</td>
                                <td class="py-4 px-4 text-right font-bold">Rp 960.000</td>
                                <td class="py-4 px-4 text-right">7.7%</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">
                            <tr>
                                <td class="py-3 px-4" colspan="2">Total Pastry</td>
                                <td class="py-3 px-4 text-right">104</td>
                                <td class="py-3 px-4 text-right">Rp 2.080.000</td>
                                <td class="py-3 px-4 text-right">16.7%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
    </div>




    <!-- Tabel Per Kategori -->
   
   
  
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                filterData(selectedDates[0], selectedDates[1]);
            }
        }
    });

    // Initialize chart
    const ctx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Cake', 'Roti', 'Pastry', 'Minuman', 'Lainnya'],
            datasets: [{
                label: 'Total Pendapatan (Rp)',
                data: [3450000, 2775000, 2080000, 1560000, 2600000],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 159, 64, 1)'
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
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Search input handler
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = this.value.trim().toLowerCase();
        const categorySections = document.querySelectorAll('[class*="mb-8"]');
        
        categorySections.forEach(section => {
            const heading = section.querySelector('h2').textContent.toLowerCase();
            if (heading.includes(searchTerm)) {
                section.style.display = '';
            } else {
                section.style.display = 'none';
            }
        });
        
        if (searchTerm) {
            showAlert('info', `Menampilkan hasil pencarian: ${searchTerm}`);
        }
    });
    
    // Filter data function
    function filterData(startDate, endDate) {
        console.log(`Filter data dari ${startDate} sampai ${endDate}`);
        showAlert('success', `Menampilkan data dari ${formatDate(startDate)} sampai ${formatDate(endDate)}`);
        
        // In a real app, you would update chart and tables here via AJAX
    }
    
    // Format date to Indonesian format
    function formatDate(date) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
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
            a.download = `laporan-kategori-${new Date().toISOString().slice(0,10)}.csv`;
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