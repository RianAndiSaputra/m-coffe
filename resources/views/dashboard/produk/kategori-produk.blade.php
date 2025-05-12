@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

@include('partials.kategori.modal-konfirmasi-hapus')

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Kategori</h1>
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
                    class="w-full pl-10 pr-4 py-3 border rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    id="searchKategori"
                />
            </div>
            <button 
                onclick="openModal('modalTambahKategori')" 
                class="px-5 py-3 text-base font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 shadow"
            >
                + Tambah Kategori
            </button>
        </div>
    </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-lg p-4 shadow mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-4 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Mengelola kategori untuk: Kifa Bakery Pusat</h2>
            <p class="text-sm text-gray-600">Data yang ditampilkan adalah untuk outlet Kifa Bakery Pusat.</p>
        </div>
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
        <table class="w-full text-base">
            <thead class="text-left text-gray-600 border-b">
                <tr>
                    <th class="py-2 font-semibold">No.</th>
                    <th class="py-2 font-semibold">Kategori</th>
                    <th class="py-2 font-semibold">Deskripsi</th>
                    <th class="py-2 font-semibold">Jumlah Produk</th>
                    <th class="py-2 font-semibold">Aksi</th>
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
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>

                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-10 mt-1 w-32 bg-white border border-gray-200 rounded-lg shadow-xl text-sm">
                                <button onclick="openEditModal(1)" class="flex items-center w-full px-3 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusKategori(1)" class="flex items-center w-full px-3 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
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
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i>
                            </button>
                            <div class="dropdown-menu hidden absolute right-0 z-10 mt-1 w-32 bg-white border border-gray-200 rounded-lg shadow-xl text-sm">
                                <button onclick="openEditModal(2)" class="flex items-center w-full px-3 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusKategori(2)" class="flex items-center w-full px-3 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Kategori 3 -->
                <tr class="border-b">
                    <td class="py-4">3</td>
                    <td class="py-4 font-medium">Minuman</td>
                    <td class="py-4">Minuman segar dan jus</td>
                    <td class="py-4">5 produk</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 bottom-full mb-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="openEditModal(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusKategori(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
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

@include('partials.kategori.modal-tambah-kategori')
@include('partials.kategori.modal-edit-kategori')

<script>
    // Variabel untuk menyimpan ID kategori yang akan dihapus
    let kategoriHapusId = null;
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

    // Dropdown Functions - Updated to be dynamic like manajemen outlet
    function toggleDropdown(button) {
        const menu = button.nextElementSibling;

        // Tutup semua dropdown lain
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) {
                m.classList.add('hidden');
                m.classList.remove('dropdown-up');
                m.classList.remove('dropdown-down');
            }
        });

        // Toggle dropdown terkait tombol yang diklik
        menu.classList.toggle('hidden');

        // Reset posisi
        menu.classList.remove('dropdown-up', 'dropdown-down');

        // Cek ruang yang tersedia
        const menuRect = menu.getBoundingClientRect();
        const buttonRect = button.getBoundingClientRect();
        const spaceBelow = window.innerHeight - buttonRect.bottom;
        const spaceAbove = buttonRect.top;

        // Atur arah dropdown
        if (spaceBelow < menuRect.height && spaceAbove > menuRect.height) {
            // Tampilkan ke atas
            menu.classList.add('dropdown-up');
            menu.style.bottom = "100%";
            menu.style.marginBottom = "0.25rem";
            menu.style.top = "auto";
            menu.style.marginTop = "0";
        } else {
            // Tampilkan ke bawah
            menu.classList.add('dropdown-down');
            menu.style.top = "100%";
            menu.style.marginTop = "0.25rem";
            menu.style.bottom = "auto";
            menu.style.marginBottom = "0";
        }
    }

    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative.inline-block')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
                menu.classList.remove('dropdown-up');
                menu.classList.remove('dropdown-down');
            });
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

    // Delete Kategori Function (Updated)
    function hapusKategori(id) {
        // Dapatkan data kategori
        const kategoriData = getKategoriData(id);
        
        // Set ID kategori yang akan dihapus
        kategoriHapusId = id;
        
        // Update nama kategori di modal konfirmasi
        document.getElementById('hapusNamaKategori').textContent = kategoriData.nama;
        
        // Tampilkan modal konfirmasi
        openModal('modalKonfirmasiHapus');
    }
    // Event listeners untuk modal konfirmasi hapus
    document.addEventListener('DOMContentLoaded', function() {
        // Tombol batal hapus
        const btnBatalHapus = document.getElementById('btnBatalHapus');
        if (btnBatalHapus) {
            btnBatalHapus.addEventListener('click', function() {
                closeModal('modalKonfirmasiHapus');
                kategoriHapusId = null; // Reset ID kategori
            });
        }
        
        // Tombol konfirmasi hapus
        const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
        if (btnKonfirmasiHapus) {
            btnKonfirmasiHapus.addEventListener('click', function() {
                // Di sini Anda akan melakukan penghapusan kategori
                // Misalnya dengan AJAX call ke backend
                console.log('Menghapus kategori ID:', kategoriHapusId);
                
                // Simulasi sukses (ganti dengan kode nyata)
                setTimeout(() => {
                    closeModal('modalKonfirmasiHapus');
                    showAlert('success', 'Kategori berhasil dihapus!');
                    
                    // Di aplikasi nyata, Anda mungkin perlu me-refresh data
                    // atau menghapus baris dari tabel
                    
                    // Reset ID kategori
                    kategoriHapusId = null;
                }, 500);
            });
        }
    });
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