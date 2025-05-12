@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Modal Transfer Stok -->
@include('partials.stok.modal-transfer-stock')

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok</h1>
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
        <i data-lucide="package" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Daftar Stok Produk</h2>
            <p class="text-sm text-gray-600">Kelola stok produk di semua outlet Kifa Bakery.</p>
        </div>
    </div>
</div>

<!-- Card: Tabel Stok -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-semibold">SKU</th>
                    <th class="py-3 font-semibold">Produk</th>
                    <th class="py-3 font-semibold">Kategori</th>
                    <th class="py-3 font-semibold">Stok</th>
                    <th class="py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <!-- Produk 1 -->
                <tr>
                    <td class="py-4 font-medium">KFB-001</td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="croissant" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <span>Roti Coklat Keju</span>
                        </div>
                    </td>
                    <td class="py-4">Roti Manis</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-orange-100 text-orange-700 rounded-full">25</span>
                    </td>
                    <td class="py-4">
                        <button onclick="openModalTransfer('KFB-001', 'Roti Coklat Keju', 'Kifa Bakery Pusat', 25)" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4"></i> Transfer
                        </button>
                    </td>
                </tr>

                <!-- Produk 2 -->
                <tr>
                    <td class="py-4 font-medium">KFB-002</td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cake" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <span>Black Forest</span>
                        </div>
                    </td>
                    <td class="py-4">Kue Ulang Tahun</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-orange-100 text-orange-700 rounded-full">12</span>
                    </td>
                    <td class="py-4">
                        <button onclick="openModalTransfer('KFB-002', 'Black Forest', 'Kifa Bakery Cabang 1', 12)" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4"></i> Transfer
                        </button>
                    </td>
                </tr>

                <!-- Produk 3 -->
                <tr>
                    <td class="py-4 font-medium">KFB-003</td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cookie" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <span>Kastengel</span>
                        </div>
                    </td>
                    <td class="py-4">Kue Kering</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-red-100 text-red-700 rounded-full">3</span>
                    </td>
                    <td class="py-4">
                        <button onclick="openModalTransfer('KFB-003', 'Kastengel', 'Kifa Bakery Cabang 2', 3)" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4"></i> Transfer
                        </button>
                    </td>
                </tr>

                <!-- Produk 4 -->
                <tr>
                    <td class="py-4 font-medium">KFB-004</td>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cupcake" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <span>Donat Coklat</span>
                        </div>
                    </td>
                    <td class="py-4">Donat</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-green-100 text-green-700 rounded-full">48</span>
                    </td>
                    <td class="py-4">
                        <button onclick="openModalTransfer('KFB-004', 'Donat Coklat', 'Kifa Bakery Pusat', 48)" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 flex items-center gap-2">
                            <i data-lucide="truck" class="w-4 h-4"></i> Transfer
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan alert
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alertId = 'alert-' + Date.now();
        
        // Warna dan ikon berdasarkan jenis alert
        const alertConfig = {
            success: {
                bgColor: 'bg-orange-50',
                borderColor: 'border-orange-200',
                textColor: 'text-orange-800',
                icon: 'check-circle',
                iconColor: 'text-orange-500'
            },
            error: {
                bgColor: 'bg-red-50',
                borderColor: 'border-red-200',
                textColor: 'text-red-800',
                icon: 'alert-circle',
                iconColor: 'text-red-500'
            }
        };
        
        const config = alertConfig[type] || alertConfig.success;
        
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
        
        // Inisialisasi ikon Lucide
        if (window.lucide) {
            window.lucide.createIcons();
        }
        
        // Auto close setelah 5 detik
        setTimeout(() => {
            closeAlert(alertId);
        }, 5000);
    }

    // Fungsi untuk menutup alert
    function closeAlert(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.classList.add('animate-fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    }

    // Fungsi untuk membuka modal transfer
    function openModalTransfer(sku, produk, outlet, stok) {
        const modal = document.getElementById('modalTransferStock');
        
        // Set data ke form
        document.getElementById('transferSku').textContent = sku;
        document.getElementById('transferProduk').textContent = produk;
        document.getElementById('stokTersedia').textContent = stok;
        document.getElementById('jumlahTransfer').max = stok;
        document.getElementById('jumlahTransfer').value = '';
        
        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Fungsi untuk menutup modal transfer
    function closeModalTransfer() {
        const modal = document.getElementById('modalTransferStock');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Fungsi untuk submit transfer
    function submitTransfer() {
        const jumlah = document.getElementById('jumlahTransfer').value;
        const tujuan = document.getElementById('tujuanTransfer').value;
        
        if (!jumlah || jumlah <= 0) {
            showAlert('error', 'Jumlah transfer harus lebih dari 0');
            return;
        }
        
        if (!tujuan) {
            showAlert('error', 'Silakan pilih tujuan transfer');
            return;
        }
        
        // Simulasi proses transfer
        setTimeout(() => {
            closeModalTransfer();
            showAlert('success', `Berhasil transfer ${jumlah} stok ke ${tujuan}`);
        }, 1000);
    }

    // Event listener untuk tombol di modal
    document.getElementById('btnBatalTransfer')?.addEventListener('click', closeModalTransfer);
    document.getElementById('btnSubmitTransfer')?.addEventListener('click', submitTransfer);
</script>

<style>
    /* Animasi untuk alert */
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
</style>

@endsection