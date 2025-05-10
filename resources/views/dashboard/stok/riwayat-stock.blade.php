@extends('layouts.app')

@section('title', 'Manajemen Riwayat Stok')

@section('content')

<!-- Page Title -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
    <h1 class="text-xl font-semibold text-gray-800">Manajemen Riwayat Stok</h1>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <!-- Heroicons search icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
                    </svg>
                </span>
                <input 
                    type="text" 
                    placeholder="Cari Produk..." 
                    class="pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    {{-- id="searchKategori" --}}
                />
            </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-lg p-4 shadow mb-4">
    <div>
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
            Outlet Aktif: Kifa Bakery Pusat
        </h2>
        <p class="text-sm text-gray-600">Data riwayat perubahan stok untuk outlet Kifa Bakery Pusat.</p>
    </div>
</div>

<!-- Card: Tabel Riwayat Stok -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header Table: Filter Tanggal -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <div class="flex items-center space-x-2">
            <input type="date" class="border rounded px-3 py-2 text-sm">
            <span class="text-gray-500">s/d</span>
            <input type="date" class="border rounded px-3 py-2 text-sm">
            <button class="px-3 py-2 text-sm bg-orange-600 text-white rounded hover:bg-orange-700">
                Filter
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-600 border-b">
                <tr>
                    <th class="py-2">Jam</th>
                    <th class="py-2">Produk</th>
                    <th class="py-2">Stok Sebelumnya</th>
                    <th class="py-2">Stok Baru</th>
                    <th class="py-2">Perubahan</th>
                    <th class="py-2">Tipe</th>
                    <th class="py-2">Catatan</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <!-- Riwayat 1 -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">10:30:42</td>
                    <td class="py-3">
                        <div class="flex items-center space-x-2">
                            <img src="https://via.placeholder.com/40" alt="gambar" class="w-8 h-8 bg-gray-100 rounded object-cover" />
                            <span>Bolu Pisang</span>
                        </div>
                    </td>
                    <td>25</td>
                    <td>20</td>
                    <td class="text-red-500">-5</td>
                    <td><span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs">Penjualan</span></td>
                    <td class="text-xs text-gray-500">Pesanan #TRX-001</td>
                </tr>
                
                <!-- Riwayat 2 -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">09:15:22</td>
                    <td class="py-3">
                        <div class="flex items-center space-x-2">
                            <img src="https://via.placeholder.com/40" alt="gambar" class="w-8 h-8 bg-gray-100 rounded object-cover" />
                            <span>Roti Sobek</span>
                        </div>
                    </td>
                    <td>15</td>
                    <td>30</td>
                    <td class="text-green-500">+15</td>
                    <td><span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">Restok</span></td>
                    <td class="text-xs text-gray-500">Supplier: Mitra Roti</td>
                </tr>
                
                <!-- Riwayat 3 -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">08:05:10</td>
                    <td class="py-3">
                        <div class="flex items-center space-x-2">
                            <img src="https://via.placeholder.com/40" alt="gambar" class="w-8 h-8 bg-gray-100 rounded object-cover" />
                            <span>Donat Coklat</span>
                        </div>
                    </td>
                    <td>12</td>
                    <td>10</td>
                    <td class="text-red-500">-2</td>
                    <td><span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-xs">Koreksi</span></td>
                    <td class="text-xs text-gray-500">Stok rusak</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-gray-600">
            Menampilkan 1 sampai 3 dari 15 entri
        </div>
        <div class="flex space-x-1">
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">
                Previous
            </button>
            <button class="px-3 py-1 border rounded text-sm bg-orange-600 text-white hover:bg-orange-700">
                1
            </button>
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">
                2
            </button>
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">
                Next
            </button>
        </div>
    </div>
</div>

@endsection