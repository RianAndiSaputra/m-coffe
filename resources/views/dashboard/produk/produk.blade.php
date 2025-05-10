@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')

<!-- Page Title + Action -->
<div class="mb-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Produk</h1>
        <a href="#" class="px-4 py-2 text-sm text-white bg-orange-600 rounded hover:bg-orange-600">
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
        
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm table-100[vh]">
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
                    <td class="relative">
                        <div class="relative">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i>
                            </button>

                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-10 mt-2 w-32 bg-white border border-gray-200 rounded shadow text-sm">
                                <button onclick="editProduk(1)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusProduk(1)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left text-red-600">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>

                </tr>

                <!-- Produk lainnya bisa ditambahkan sesuai pola di atas -->
            </tbody>
        </table>
    </div>
</div>

@include('partials.modal-tambah-produk')

<script>
    const modal = document.getElementById('modalTambahProduk');
    const batalBtn = document.getElementById('btnBatalModal');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Trigger buka modal
    document.querySelectorAll('a[href="#"]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            openModal();
        });
    });

    // Klik batal
    batalBtn.addEventListener('click', () => {
        closeModal();
    });

    function toggleDropdown(button) {
        // Tutup dropdown lain
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== button.nextElementSibling) {
                menu.classList.add('hidden');
            }
        });

        // Toggle dropdown terkait tombol yang diklik
        const menu = button.nextElementSibling;
        menu.classList.toggle('hidden');
    }

    // Tutup semua dropdown jika klik di luar
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
        }
    });

    // Fungsi edit & hapus
    function editProduk(id) {
        console.log('Edit produk ID:', id);
        // Bisa buka modal edit di sini
    }

    function hapusProduk(id) {
        if (confirm('Yakin ingin menghapus produk ini?')) {
            console.log('Hapus produk ID:', id);
            // Kirim permintaan hapus ke server di sini
        }
    }
</script>



@endsection
