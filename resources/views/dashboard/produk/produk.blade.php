@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')

<!-- Page Title + Action -->
<div class="mb-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Produk</h1>
        <a href="#" class="px-4 py-2 text-sm text-white bg-orange-700 rounded hover:bg-orange-800">
            + Tambah Produk
        </a>
    </div>
</div>

<!-- Card: Outlet Info + Aksi -->
<div class="bg-white rounded-lg p-4 shadow mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
            Outlet Aktif: Kifa Bakery Pusat
        </h2>
        <p class="text-sm text-gray-600">Data yang ditampilkan adalah untuk outlet Kifa Bakery Pusat.</p>
    </div>
    <div class="flex items-center space-x-2">
        <button class="flex items-center px-4 py-2 text-sm bg-white border rounded shadow hover:bg-gray-50">
            <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Cetak
        </button>
        <button class="flex items-center px-4 py-2 text-sm bg-white border rounded shadow hover:bg-gray-50">
            <i data-lucide="download" class="w-4 h-4 mr-2"></i> Ekspor
        </button>
    </div>
</div>

<!-- Card: Tabel Produk -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header Table: Pencarian dan Tambah -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <input type="text" placeholder="Pencarian...." class="w-full md:w-1/3 border rounded px-3 py-2 text-sm mb-2 md:mb-0" />
        <a href="#" class="px-4 py-2 text-sm text-white bg-orange-500 rounded hover:bg-orange-600">
            + Tambah Produk
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm table-auto">
            <thead class="text-left text-gray-600 border-b">
                <tr>
                    <th class="py-2">No.</th>
                    <th class="py-2">Nama Produk</th>
                    <th class="py-2">SKU</th>
                    <th class="py-2">Kategori</th>
                    <th class="py-2">Harga</th>
                    <th class="py-2">Stok</th>
                    <th class="py-2">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <!-- Produk 1 -->
                <tr class="border-b">
                    <td class="py-3">1</td>
                    <td class="py-3 flex items-center space-x-2">
                        <img src="#" alt="gambar" class="w-10 h-10 bg-gray-100 rounded object-cover" />
                        <div>
                            <p class="font-medium">Bolu Pisang</p>
                            <p class="text-xs text-gray-500">test</p>
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
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-600 rounded">Active</span>
                    </td>
                    <td><i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i></td>
                </tr>

                <!-- Produk lainnya bisa ditambahkan sesuai pola di atas -->
            </tbody>
        </table>
    </div>
</div>

@include('partials.produk.modal-tambah-produk')

<script>
    const modal = document.getElementById('modalTambahProduk');
    const batalBtn = document.getElementById('btnBatalModal');

    // Buka modal
    document.querySelectorAll('a[href="#"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Tutup modal saat klik batal
    batalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Tutup modal saat klik di luar kontennya
    modal.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
</script>


@endsection
