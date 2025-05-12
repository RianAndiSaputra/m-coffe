@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')

<!-- Notification container -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

@include('partials.produk.modal-konfirmasi-hapus')

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Produk</h1>
        <button onclick="openModal('modalTambahProduk')" class="px-5 py-3 text-base font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 shadow">
            + Tambah Produk
        </button>
    </div>
</div>

<!-- Card: Outlet Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Outlet Aktif: Kifa Bakery Pusat</h2>
            <p class="text-sm text-gray-600">Data yang ditampilkan adalah untuk outlet Kifa Bakery Pusat.</p>
        </div>
    </div>
    <div class="flex items-center space-x-2">
        <button class="flex items-center px-4 py-2 text-sm font-medium bg-white border rounded shadow hover:bg-gray-50">
            <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Cetak
        </button>
        <button class="flex items-center px-4 py-2 text-sm font-medium bg-white border rounded shadow hover:bg-gray-50">
            <i data-lucide="download" class="w-4 h-4 mr-2"></i> Ekspor
        </button>
    </div>
</div>

<!-- Card: Tabel Produk -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header Table: Pencarian dan Tambah -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <input type="text" placeholder="Pencarian...." class="w-full md:w-1/3 border rounded px-3 py-2 text-sm mb-2 md:mb-0" />
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-base text-gray-600 border-b">
                <tr>
                    <th class="py-2 font-semibold">No.</th>
                    <th class="py-2 font-semibold">Nama Produk</th>
                    <th class="py-2 font-semibold">SKU</th>
                    <th class="py-2 font-semibold">Kategori</th>
                    <th class="py-2 font-semibold">Harga</th>
                    <th class="py-2 font-semibold">Stok</th>
                    <th class="py-2 font-semibold">Status</th>
                    <th class="py-2 font-semibold">Aksi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <!-- Produk 1 -->
                <tr class="border-b">
                    <td class="py-3">1</td>
                    <td class="py-3 flex items-center space-x-2">
                        <img src="https://via.placeholder.com/40" alt="gambar" class="w-10 h-10 bg-gray-100 rounded object-cover" />
                        <div>
                            <p class="font-medium">Bolu Pisang</p>
                            <p class="text-xs text-gray-500">Kue bolu dengan rasa pisang</p>
                        </div>
                    </td>
                    <td>1001</td>
                    <td>CAKE</td>
                    <td>Rp 17.500,00</td>
                    <td>
                        20<br>
                        <span class="text-xs text-gray-500">Min. stok: 5</span>
                    </td>
                    <td>
                        <span class="px-3 py-1.5 text-sm font-medium bg-green-100 text-green-700 rounded-full">Aktif</span>
                    </td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 bottom-full mb-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="openEditModal(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusProduk(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@include('partials.produk.modal-tambah-produk')
@include('partials.produk.modal-edit-produk')

<style>
    /* Notification styles */
    .notification {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        transform: translateX(150%);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1000;
        max-width: 350px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification.success {
        background-color: rgba(255, 107, 0, 0.9); /* Orange with transparency */
        color: white;
    }
    
    .notification.error {
        background-color: rgba(239, 68, 68, 0.9); /* Red with transparency */
        color: white;
    }
    
    .notification.info {
        background-color: rgba(255, 107, 0, 0.9); /* Blue with transparency */
        color: white;
    }
    
    .notification-icon {
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
    
    .notification-message {
        flex: 1;
    }
    
    .notification-close {
        margin-left: 1rem;
        cursor: pointer;
        flex-shrink: 0;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .notification-close:hover {
        opacity: 1;
    }
    
    /* Confirmation Dialog Animation */
    #confirmationDialog .bg-white {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.2s ease-in-out;
    }

    .dropdown-menu.dropdown-up {
        bottom: 100%;
        top: auto;
    }

    .dropdown-menu.dropdown-down {
        top: 100%;
        bottom: auto;
    }

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

<script src="{{asset('js/produk/produk.js')}}"></script>

@endsection