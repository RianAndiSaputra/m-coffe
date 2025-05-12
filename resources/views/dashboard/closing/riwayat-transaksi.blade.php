@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')

<!-- Alert Container -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80"></div>

<!-- title Page -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi</h1>
    </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">Outlet Aktif: Kifa Bakery Pusat</h2>
            <p class="text-sm text-gray-600">Data riwayat transaksi kas untuk outlet Kifa Bakery Pusat.</p>
        </div>
    </div>
</div>

<!-- Table Riwayat Transaksi -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header & Filter Row -->
    <div class="flex flex-col mb-4">
        <!-- Title and Date Filter Row -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
            <h3 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h3>
            
            <div class="relative mt-2 sm:mt-0">
                <input id="transDateInput" type="text"
                    class="w-full sm:w-56 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                    placeholder="Pilih Tanggal" />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-500"></i>
                </span>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="w-full sm:w-72 relative">
            <input type="text" id="searchInvoice"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Cari Invoice..." />
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </span>
        </div>
    </div>
    
    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Invoice</th>
                    <th class="py-3 font-bold">Waktu</th>
                    <th class="py-3 font-bold">Kasir</th>
                    <th class="py-3 font-bold">Pembayaran</th>
                    <th class="py-3 font-bold">Status</th>
                    <th class="py-3 font-bold">Total</th>
                    <th class="py-3 font-bold text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">INV-1746777071-5RTRZ8</td>
                    <td class="py-4">09/05/2025 14:51</td>
                    <td class="py-4">Admin</td>
                    <td class="py-4"><span class="px-2 py-1 bg-green-200 text-green-800 font-semibold rounded-full text-xs">Tunai</span></td>
                    <td class="py-4"><span class="px-2 py-1 text-green-600 font-bold text-xs">Selesai</span></td>
                    <td class="py-4 font-semibold">Rp 4.000,00</td>
                    <td class="flex py-4 text-center space-x-2">
                        <!-- Detail -->
                        <a href="#" onclick="openDetailModal()" class="text-gray-600 hover:text-orange-600">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </a>
                        <!-- Refund -->
                        <a href="#" onclick="openRefundModal('INV-1746777071-5RTRZ8')" class="text-gray-600 hover:text-red-600">
                            <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
        <button onclick="closeDetailModal()" class="absolute top-3 right-3 text-orange-600 hover:text-orange-800">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        <h2 class="text-lg font-bold mb-2">Detail Transaksi</h2>
        <p class="text-sm text-gray-600 mb-1">Invoice: <span class="font-semibold">INV-1746777071-5RTRZ8</span></p>
        <div class="flex justify-between text-sm text-gray-700 mb-4">
            <span>09/05/2025 14:51</span>
            <span><span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded text-xs">Selesai</span></span>
        </div>

        <!-- Tabel Produk -->
        <div class="border rounded overflow-hidden mb-4">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left border-b">
                    <tr>
                        <th class="p-2">Produk</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">Harga</th>
                        <th class="p-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2">Roti Semir Eco</td>
                        <td class="p-2">x2</td>
                        <td class="p-2">Rp 2.000,00</td>
                        <td class="p-2 font-semibold">Rp 4.000,00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Ringkasan -->
        <div class="text-sm text-gray-700 space-y-1 mb-4">
            <div class="flex justify-between">
                <span>Subtotal</span><span>Rp 4.000,00</span>
            </div>
            <div class="flex justify-between">
                <span>Pajak:</span><span>Rp 0,00</span>
            </div>
            <div class="flex justify-between">
                <span>Diskon:</span><span>Rp 0,00</span>
            </div>
            <div class="flex justify-between font-semibold">
                <span>Total</span><span>Rp 4.000,00</span>
            </div>
            <div class="flex justify-between text-orange-600 font-semibold">
                <span>Total Bayar</span><span>Rp 4.000,00</span>
            </div>
            <div class="flex justify-between text-green-600">
                <span>Kembalian</span><span>Rp 0,00</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Refund -->
<div id="modalRefund" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Refund</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Anda yakin ingin melakukan refund untuk transaksi ini?</p>
                    <p id="refundInvoiceText" class="text-sm font-medium mt-1"></p>
                    <div class="mt-3 p-3 bg-yellow-50 rounded-md">
                        <p class="text-xs text-yellow-700">Transaksi yang direfund tidak dapat dikembalikan. Pastikan produk telah dikembalikan sebelum melakukan refund.</p>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-3">
                    <button onclick="closeRefundModal()" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button onclick="processRefund()" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none">
                        Konfirmasi Refund
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi date picker
    flatpickr("#transDateInput", {
        dateFormat: "d M Y",
        defaultDate: "today"
    });

    // Fungsi untuk modal detail
    function openDetailModal() {
        document.getElementById('modalDetail').classList.remove('hidden');
        document.getElementById('modalDetail').classList.add('flex');
    }

    function closeDetailModal() {
        document.getElementById('modalDetail').classList.add('hidden');
        document.getElementById('modalDetail').classList.remove('flex');
    }

    // Fungsi untuk modal refund
    let currentInvoiceId = '';
    
    function openRefundModal(invoiceId) {
        currentInvoiceId = invoiceId;
        document.getElementById('refundInvoiceText').textContent = `Invoice: ${invoiceId}`;
        document.getElementById('modalRefund').classList.remove('hidden');
    }

    function closeRefundModal() {
        document.getElementById('modalRefund').classList.add('hidden');
    }

    function processRefund() {
        // Implementasi AJAX untuk refund
        console.log(`Memproses refund untuk invoice: ${currentInvoiceId}`);
        
        // Contoh AJAX (gunakan sesuai framework Anda)
        /*
        fetch('/transactions/refund', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ invoice_id: currentInvoiceId })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                showAlert('success', 'Refund berhasil diproses!');
                // Refresh halaman atau update UI
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showAlert('error', 'Gagal memproses refund: ' + data.message);
            }
        });
        */
        
        // Untuk contoh, kita tampilkan notifikasi success
        closeRefundModal();
        showAlert('success', `Refund untuk invoice ${currentInvoiceId} berhasil diproses!`);
        
        // Simulasi refresh data setelah 2 detik
        setTimeout(() => {
            // window.location.reload(); // Uncomment ini di implementasi nyata
        }, 2000);
    }

    // Fungsi untuk menampilkan notifikasi
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