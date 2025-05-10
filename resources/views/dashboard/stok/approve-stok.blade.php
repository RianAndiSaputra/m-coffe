@extends('layouts.app')

@section('title', 'Approve Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-3xl font-bold text-gray-800">Manajemen Stok</h1>
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
            </span>
            <input type="text" placeholder="Pencarian..."
                class="w-full pl-10 pr-4 py-3 border rounded-lg text-base font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
        </div>
    </div>
</div>

<!-- Card: Stok Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="package-check" class="w-5 h-5 text-black mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Menampilkan permintaan perubahan stok untuk: Kifa Bakery Pusat</h2>
            <p id="reportDate" class="text-sm text-gray-600">Permintaan yang belum diproses <span class="font-medium">{{ date('d M Y') }}</span></p>
        </div>
    </div>
</div>
<!-- Card: Tabel Laporan Stok -->
<div class="bg-white rounded-lg shadow-lg p-6">
   <div class="mb-4">
    <h1 class="text-3xl font-bold text-gray-800">Penyesuaian Stok Menunggu Persetujuan</h1>
    <p class="text-sm text-gray-600 mb-2">Persetujuan penyesuaian stok dari kasir yang membutuhkan tindakan Anda</p>
     <!-- Filter Tanggal -->
    <div class="mt-8">
        <label for="reportDateInput" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
        <div class="relative">
            <input id="reportDateInput" type="text"
                class="w-full sm:w-56 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Tanggal" />
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i data-lucide="calendar" class="w-4 h-4 text-gray-500"></i>
            </span>
        </div>
    </div>
    <div class="overflow-x-auto mt-8">
        <table class="w-full text-base">
         <thead class="bg-white text-gray-800 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Produk</th>
                    <th class="py-3 font-bold text-center">Stok Sebelum</th>
                    <th class="py-3 font-bold text-center">Perubahan</th>
                    <th class="py-3 font-bold text-center">Tipe</th>
                    <th class="py-3 font-bold">Diajukan Oleh</th>
                    <th class="py-3 font-bold">Waktu</th>
                    <th class="py-3 font-bold">Catatan</th>
                    <th class="py-3 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="approvalTableBody">
                <!-- Permintaan 1 -->
                <tr id="request-1">
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="croissant" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Roti Coklat Keju</span>
                                <span class="text-xs text-gray-500">KFB-001</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-bold text-center">25</td>
                    <td class="py-4 font-bold text-center text-green-600">+5</td>
                    <td class="py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">Penambahan</span>
                    </td>
                    <td class="py-4">Budi Santoso</td>
                    <td class="py-4 text-sm">10:30, 12 Mei 2024</td>
                    <td class="py-4 text-sm">Stok masuk dari produksi pagi</td>
                    <td class="py-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <button onclick="handleApproval(1, true)" class="p-2 rounded-md bg-green-100 text-green-600 hover:bg-green-200 transition-colors">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </button>
                            <button onclick="handleApproval(1, false)" class="p-2 rounded-md bg-red-100 text-red-600 hover:bg-red-200 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Permintaan 2 -->
                <tr id="request-2">
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cake" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Black Forest</span>
                                <span class="text-xs text-gray-500">KFB-002</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-bold text-center">12</td>
                    <td class="py-4 font-bold text-center text-red-600">-2</td>
                    <td class="py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Pengurangan</span>
                    </td>
                    <td class="py-4">Ani Wijaya</td>
                    <td class="py-4 text-sm">09:15, 12 Mei 2024</td>
                    <td class="py-4 text-sm">Retur dari pelanggan, produk rusak</td>
                    <td class="py-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <button onclick="handleApproval(2, true)" class="p-2 rounded-md bg-green-100 text-green-600 hover:bg-green-200 transition-colors">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </button>
                            <button onclick="handleApproval(2, false)" class="p-2 rounded-md bg-red-100 text-red-600 hover:bg-red-200 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Permintaan 3 -->
                <tr id="request-3">
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cookie" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Kastengel</span>
                                <span class="text-xs text-gray-500">KFB-003</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-bold text-center">3</td>
                    <td class="py-4 font-bold text-center text-green-600">+10</td>
                    <td class="py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-full">Penambahan</span>
                    </td>
                    <td class="py-4">Rina Permata</td>
                    <td class="py-4 text-sm">14:45, 11 Mei 2024</td>
                    <td class="py-4 text-sm">Stok darurat untuk pesanan khusus</td>
                    <td class="py-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <button onclick="handleApproval(3, true)" class="p-2 rounded-md bg-green-100 text-green-600 hover:bg-green-200 transition-colors">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </button>
                            <button onclick="handleApproval(3, false)" class="p-2 rounded-md bg-red-100 text-red-600 hover:bg-red-200 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Permintaan 4 -->
                <tr id="request-4">
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cupcake" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Donat Coklat</span>
                                <span class="text-xs text-gray-500">KFB-004</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-bold text-center">48</td>
                    <td class="py-4 font-bold text-center text-red-600">-12</td>
                    <td class="py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Pengurangan</span>
                    </td>
                    <td class="py-4">Doni Pratama</td>
                    <td class="py-4 text-sm">16:20, 11 Mei 2024</td>
                    <td class="py-4 text-sm">Penjualan offline di toko cabang</td>
                    <td class="py-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <button onclick="handleApproval(4, true)" class="p-2 rounded-md bg-green-100 text-green-600 hover:bg-green-200 transition-colors">
                                <i data-lucide="check" class="w-5 h-5"></i>
                            </button>
                            <button onclick="handleApproval(4, false)" class="p-2 rounded-md bg-red-100 text-red-600 hover:bg-red-200 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    // Initialize flatpickr
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#reportDateInput", {
            dateFormat: "d M Y",
            defaultDate: "today",
            locale: "id",
            onChange: function(selectedDates, dateStr) {
                document.getElementById('reportDate').innerHTML = 
                    `Permintaan yang belum diproses <span class="font-medium">${dateStr}</span>`;
            }
        });

        // Initialize Lucide icons
        lucide.create();
    });

    // Handle approval/rejection
    function handleApproval(requestId, isApproved) {
        const row = document.getElementById(`request-${requestId}`);
        const buttons = row.querySelectorAll('button');
        
        // Disable both buttons and show loading
        buttons.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = `<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i>`;
            lucide.create();
        });

        // Simulate API call
        setTimeout(() => {
            // Remove the row with fade out effect
            row.style.opacity = '0';
            row.style.transition = 'opacity 0.3s ease';
            
            setTimeout(() => {
                row.remove();
                
                // Show status message
                const status = isApproved ? 'disetujui' : 'ditolak';
                const alertColor = isApproved ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                const icon = isApproved ? 'check-circle' : 'x-circle';
                
                const alert = document.createElement('div');
                alert.className = `${alertColor} p-4 rounded-md mb-2 flex items-center justify-between`;
                alert.innerHTML = `
                    <div class="flex items-center gap-2">
                        <i data-lucide="${icon}" class="w-5 h-5"></i>
                        <span>Permintaan #${requestId} ${status}</span>
                    </div>
                    <button onclick="this.parentElement.remove()">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                `;
                
                document.getElementById('alertContainer').prepend(alert);
                lucide.create();
                
                // Auto remove alert after 3 seconds
                setTimeout(() => {
                    alert.remove();
                }, 3000);
                
            }, 300);
        }, 800);
    }
</script>

<style>
    /* Animation for alerts */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Table styling */
    table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    th, td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    th {
        background-color: #f9fafb;
    }
    
    tr:hover {
        background-color: #f9fafb;
    }
    
    /* Loading spinner animation */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Transition effects */
    .transition-opacity {
        transition-property: opacity;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

@endsection