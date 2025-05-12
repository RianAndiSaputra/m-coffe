@extends('layouts.app')

@section('title', 'Laporan Persetujuan Penyesuaian Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Laporan Persetujuan Penyesuaian Stok</h1>
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
            <p class="text-sm text-gray-600">Periode: <span id="dateRangeDisplay">01 Mei 2025 - 11 Mei 2025</span></p>
        </div>
    </div>
</div>

<!-- Laporan Persetujuan Penyesuaian Stok -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Persetujuan Penyesuaian Stok</h1>
        <p class="text-sm text-gray-600">Laporan persetujuan dan penolakan penyesuaian stok</p>
        
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
            <!-- Filter Status -->
            <div class="flex-1">
                <h2 class="text-sm font-medium text-gray-800 mb-1">Status</h2>
                <select id="statusFilter" class="w-full pl-3 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="all">Semua Status</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
        <!-- Disetujui -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <h3 class="text-2xl font-bold text-gray-800">14 penyesuaian</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-full">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                </div>
            </div>
        </div>
        
        <!-- Ditolak -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <h3 class="text-2xl font-bold text-gray-800">0 penyesuaian</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-full">
                    <i data-lucide="x-circle" class="w-6 h-6 text-red-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="overflow-x-auto mt-8">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 bg-gray-50">
                <tr>
                    <th class="py-3 font-bold px-4">Tanggal</th>
                    <th class="py-3 font-bold px-4">SKU</th>
                    <th class="py-3 font-bold px-4">Nama Item</th>
                    <th class="py-3 font-bold px-4 text-center">Perubahan</th>
                    <th class="py-3 font-bold px-4">Keterangan</th>
                    <th class="py-3 font-bold px-4">Disetujui Oleh</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="adjustmentTable">
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">2025</td>
                    <td class="py-4 px-4">Roti Semir Eco</td>
                    <td class="py-4 px-4 text-center text-green-500">+2</td>
                    <td class="py-4 px-4">9/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">2015</td>
                    <td class="py-4 px-4">Flos Roll Abon</td>
                    <td class="py-4 px-4 text-center text-green-500">+1</td>
                    <td class="py-4 px-4">9/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">2029</td>
                    <td class="py-4 px-4">Roti Unyil</td>
                    <td class="py-4 px-4 text-center text-green-500">+5</td>
                    <td class="py-4 px-4">9/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">2032</td>
                    <td class="py-4 px-4">Roti Tawar Original</td>
                    <td class="py-4 px-4 text-center text-green-500">+2</td>
                    <td class="py-4 px-4">9/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">1113</td>
                    <td class="py-4 px-4">Bolu Gulung Tiramisu Ekonomis</td>
                    <td class="py-4 px-4 text-center text-green-500">+2</td>
                    <td class="py-4 px-4">9/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">1110</td>
                    <td class="py-4 px-4">Bolu Gulung Coklat Ekonomis</td>
                    <td class="py-4 px-4 text-center text-green-500">+2</td>
                    <td class="py-4 px-4">9/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">09 Mei 2025</td>
                    <td class="py-4 px-4">1109</td>
                    <td class="py-4 px-4">Bolu Gulung Pandan Ekonomis</td>
                    <td class="py-4 px-4 text-center text-green-500">+3</td>
                    <td class="py-4 px-4">9/5</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">2032</td>
                    <td class="py-4 px-4">Roti Tawar Original</td>
                    <td class="py-4 px-4 text-center text-green-500">+2</td>
                    <td class="py-4 px-4">4/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">1001</td>
                    <td class="py-4 px-4">Bolu Pisang</td>
                    <td class="py-4 px-4 text-center text-green-500">+2</td>
                    <td class="py-4 px-4">4/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">1204</td>
                    <td class="py-4 px-4">Chiffon Keju Reguler</td>
                    <td class="py-4 px-4 text-center text-green-500">+3</td>
                    <td class="py-4 px-4">4/5/25</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">1204</td>
                    <td class="py-4 px-4">Chiffon Keju Reguler</td>
                    <td class="py-4 px-4 text-center text-green-500">+3</td>
                    <td class="py-4 px-4">Kiriman pabrik (4 Mei 2025)</td>
                    <td class="py-4 px-4">Mona</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">KNS011</td>
                    <td class="py-4 px-4">Mie Lidi Pacipa</td>
                    <td class="py-4 px-4 text-center text-green-500">+20</td>
                    <td class="py-4 px-4">kns pacipa</td>
                    <td class="py-4 px-4">Kasir</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">M004</td>
                    <td class="py-4 px-4">Indomilk Coklat 115ml</td>
                    <td class="py-4 px-4 text-center text-green-500">+5</td>
                    <td class="py-4 px-4">tgl 3/5</td>
                    <td class="py-4 px-4">Kasir</td>
                </tr>
                <tr>
                    <td class="py-4 px-4">04 Mei 2025</td>
                    <td class="py-4 px-4">1002</td>
                    <td class="py-4 px-4">Bolu Meses</td>
                    <td class="py-4 px-4 text-center text-green-500">+5</td>
                    <td class="py-4 px-4">kiriman 4/5</td>
                    <td class="py-4 px-4">Kasir</td>
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
    const adjustmentData = [
        { date: '09 Mei 2025', sku: '2025', product: 'Roti Semir Eco', change: '+2', note: '9/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '09 Mei 2025', sku: '2015', product: 'Flos Roll Abon', change: '+1', note: '9/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '09 Mei 2025', sku: '2029', product: 'Roti Unyil', change: '+5', note: '9/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '09 Mei 2025', sku: '2032', product: 'Roti Tawar Original', change: '+2', note: '9/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '09 Mei 2025', sku: '1113', product: 'Bolu Gulung Tiramisu Ekonomis', change: '+2', note: '9/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '09 Mei 2025', sku: '1110', product: 'Bolu Gulung Coklat Ekonomis', change: '+2', note: '9/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '09 Mei 2025', sku: '1109', product: 'Bolu Gulung Pandan Ekonomis', change: '+3', note: '9/5', approvedBy: 'Mona', status: 'approved' },
        { date: '04 Mei 2025', sku: '2032', product: 'Roti Tawar Original', change: '+2', note: '4/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '04 Mei 2025', sku: '1001', product: 'Bolu Pisang', change: '+2', note: '4/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '04 Mei 2025', sku: '1204', product: 'Chiffon Keju Reguler', change: '+3', note: '4/5/25', approvedBy: 'Mona', status: 'approved' },
        { date: '04 Mei 2025', sku: '1204', product: 'Chiffon Keju Reguler', change: '+3', note: 'Kiriman pabrik (4 Mei 2025)', approvedBy: 'Mona', status: 'approved' },
        { date: '04 Mei 2025', sku: 'KNS011', product: 'Mie Lidi Pacipa', change: '+20', note: 'kns pacipa', approvedBy: 'Kasir', status: 'approved' },
        { date: '04 Mei 2025', sku: 'M004', product: 'Indomilk Coklat 115ml', change: '+5', note: 'tgl 3/5', approvedBy: 'Kasir', status: 'approved' },
        { date: '04 Mei 2025', sku: '1002', product: 'Bolu Meses', change: '+5', note: 'kiriman 4/5', approvedBy: 'Kasir', status: 'approved' }
    ];

    // Initialize date range picker
    const dateRangePicker = flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["2025-05-01", "2025-05-11"],
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

    // Status filter handler
    document.getElementById('statusFilter').addEventListener('change', function(e) {
        filterData();
    });

    // Filter data function
    function filterData() {
        const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        
        // Filter data berdasarkan pencarian dan status
        const filteredData = adjustmentData.filter(item => {
            const matchesSearch = 
                item.sku.toLowerCase().includes(searchTerm) ||
                item.product.toLowerCase().includes(searchTerm) ||
                item.note.toLowerCase().includes(searchTerm) ||
                item.approvedBy.toLowerCase().includes(searchTerm);
            
            const matchesStatus = 
                statusFilter === 'all' || 
                (statusFilter === 'approved' && item.status === 'approved') ||
                (statusFilter === 'rejected' && item.status === 'rejected');
            
            return matchesSearch && matchesStatus;
        });
        
        // Update tabel adjustment
        const adjustmentTable = document.getElementById('adjustmentTable');
        adjustmentTable.innerHTML = '';
        filteredData.forEach(item => {
            const changeColor = item.change.startsWith('+') ? 'text-green-500' : 'text-red-500';
            adjustmentTable.innerHTML += `
                <tr>
                    <td class="py-4 px-4">${item.date}</td>
                    <td class="py-4 px-4">${item.sku}</td>
                    <td class="py-4 px-4">${item.product}</td>
                    <td class="py-4 px-4 text-center ${changeColor}">${item.change}</td>
                    <td class="py-4 px-4">${item.note}</td>
                    <td class="py-4 px-4">${item.approvedBy}</td>
                </tr>
            `;
        });
        
        // Update summary cards
        const approvedCount = filteredData.filter(item => item.status === 'approved').length;
        const rejectedCount = filteredData.filter(item => item.status === 'rejected').length;
        
        document.querySelectorAll('.bg-white.rounded-lg.shadow.p-4')[0].querySelector('h3').textContent = `${approvedCount} penyesuaian`;
        document.querySelectorAll('.bg-white.rounded-lg.shadow.p-4')[1].querySelector('h3').textContent = `${rejectedCount} penyesuaian`;
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
            a.download = `laporan-persetujuan-stok-${new Date().toISOString().slice(0,10)}.csv`;
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

    // Initial load
    filterData();
</script>

@endsection