@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')

<!-- Page Title + Action -->
<div class="mb-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Kategori</h1>
        <div class="flex items-center gap-2">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <!-- Heroicons search icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
                    </svg>
                </span>
                <input 
                    type="text" 
                    placeholder="Cari kategori..." 
                    class="pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    id="searchKategori"
                />
            </div>
            <button 
                onclick="openModal('modalTambahKategori')" 
                class="px-4 py-2 text-sm text-white bg-orange-600 rounded hover:bg-orange-700"
            >
                + Tambah Kategori
            </button>
        </div>
    </div>
</div>


<!-- Card: Outlet Info -->
<div class="bg-white rounded-lg p-4 shadow mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
            Mengelola kategori untuk: Kifa Bakery Pusat
        </h2>
        <p class="text-sm text-gray-600">Data yang ditampilkan adalah untuk outlet Kifa Bakery Pusat.</p>
    </div>
</div>

<!-- Card: Tabel Kategori -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header Table -->
    <div class="mb-4">
        <h1 class="font-medium text-[20px] text-gray-800">Daftar Kategori</h1>
        <span class="font-medium text-gray-500">Kelola kategori produk yang tersedia di toko Anda</span>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-600 border-b">
                <tr>
                    <th class="py-2">No.</th>
                    <th class="py-2">Kategori</th>
                    <th class="py-2">Deskripsi</th>
                    <th class="py-2">Jumlah Produk</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <!-- Kategori 1 -->
                <tr class="border-b">
                    <td class="py-3">1</td>
                    <td class="py-3 font-medium">Kue</td>
                    <td class="py-3">Berbagai macam jenis kue</td>
                    <td class="py-3">15 produk</td>
                    <td class="py-3 relative">
                        <div class="relative">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i>
                            </button>

                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-10 mt-2 w-32 bg-white border border-gray-200 rounded shadow text-sm">
                                <button onclick="openEditModal(1)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusKategori(1)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left text-red-600">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Kategori 2 -->
                <tr class="border-b">
                    <td class="py-3">2</td>
                    <td class="py-3 font-medium">Roti</td>
                    <td class="py-3">Roti segar dan roti tawar</td>
                    <td class="py-3">8 produk</td>
                    <td class="py-3 relative">
                        <div class="relative">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i>
                            </button>
                            <div class="dropdown-menu hidden absolute right-0 z-10 mt-2 w-32 bg-white border border-gray-200 rounded shadow text-sm">
                                <button onclick="openEditModal(2)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusKategori(2)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left text-red-600">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Kategori 3 -->
                <tr class="border-b">
                    <td class="py-3">3</td>
                    <td class="py-3 font-medium">Minuman</td>
                    <td class="py-3">Minuman segar dan jus</td>
                    <td class="py-3">5 produk</td>
                    <td class="py-3 relative">
                        <div class="relative">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i>
                            </button>
                            <div class="dropdown-menu hidden absolute right-0 z-10 mt-2 w-32 bg-white border border-gray-200 rounded shadow text-sm">
                                <button onclick="openEditModal(3)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusKategori(3)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left text-red-600">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@include('partials.kategori.modal-tambah-kategori')
@include('partials.kategori.modal-edit-kategori')

<script>
    // Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById(modalId).classList.add('flex');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).classList.remove('flex');
    }

    // Event listeners untuk tombol batal
    document.addEventListener('DOMContentLoaded', function() {
        // Tombol batal modal tambah
        const btnBatalTambah = document.getElementById('btnBatalModalKategori');
        if (btnBatalTambah) {
            btnBatalTambah.addEventListener('click', function() {
                closeModal('modalTambahKategori');
            });
        }

        // Tombol batal modal edit
        const btnBatalEdit = document.getElementById('btnBatalEditKategori');
        if (btnBatalEdit) {
            btnBatalEdit.addEventListener('click', function() {
                closeModal('modalEditKategori');
            });
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
            const openModals = document.querySelectorAll('.fixed.inset-0.flex');
            openModals.forEach(modal => {
                closeModal(modal.id);
            });
        }
    });

    // Dropdown Functions
    function toggleDropdown(button) {
        // Close other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== button.nextElementSibling) {
                menu.classList.add('hidden');
            }
        });

        // Toggle current dropdown
        const menu = button.nextElementSibling;
        menu.classList.toggle('hidden');
    }

    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
        }
    });

    // Edit Kategori Function
    function openEditModal(kategoriId) {
        // In a real app, you would fetch the kategori data from your backend
        const kategoriData = getKategoriData(kategoriId); // Mock function
        
        // Fill the edit form
        document.getElementById('editKategoriId').textContent = kategoriData.id;
        document.getElementById('editNamaKategori').value = kategoriData.nama;
        document.getElementById('editDeskripsiKategori').value = kategoriData.deskripsi;
        
        openModal('modalEditKategori');
    }

    // Mock function to get kategori data - replace with actual API call
    function getKategoriData(kategoriId) {
        const kategories = {
            1: {
                id: 1,
                nama: "Kue",
                deskripsi: "Berbagai macam jenis kue"
            },
            2: {
                id: 2,
                nama: "Roti",
                deskripsi: "Roti segar dan roti tawar"
            },
            3: {
                id: 3,
                nama: "Minuman",
                deskripsi: "Minuman segar dan jus"
            }
        };
        return kategories[kategoriId];
    }

    // Delete Kategori Function
    function hapusKategori(id) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            console.log('Hapus kategori ID:', id);
        }
    }
</script>

@endsection