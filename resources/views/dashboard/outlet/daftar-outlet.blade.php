@extends('layouts.app')

@section('title', 'Manajemen Outlet')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusOutlet" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Anda yakin ingin menghapus outlet ini? Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="mt-4 flex justify-end gap-3">
                    <button id="btnBatalHapus" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button id="btnKonfirmasiHapus" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Outlet</h1>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <input type="text" placeholder="Pencarian...."
                class="w-full md:w-64 border rounded-lg px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
            <a href="#" onclick="openModalTambah()"
            class="px-5 py-3 text-base font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 shadow">
                + Tambah Outlet
            </a>
        </div>
    </div>
</div>

<!-- Card: Outlet Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Manajemen Outlet</h2>
            <p class="text-sm text-gray-600">Kelola semua outlet Kifa Bakery di sini.</p>
        </div>
    </div>

    <!-- Kanan: Tombol -->
    <div class="flex items-center space-x-2">
        <button class="flex items-center px-4 py-2 text-sm font-medium bg-white border rounded-md shadow hover:bg-gray-50">
            <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Cetak
        </button>
        <button class="flex items-center px-4 py-2 text-sm font-medium bg-white border rounded-md shadow hover:bg-gray-50">
            <i data-lucide="download" class="w-4 h-4 mr-2"></i> Ekspor
        </button>
    </div>
</div>

<!-- Card: Tabel Outlet -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-semibold">No.</th>
                    <th class="py-3 font-semibold">Nama Outlet</th>
                    <th class="py-3 font-semibold">Alamat</th>
                    <th class="py-3 font-semibold">Kontak</th>
                    <th class="py-3 font-semibold">PPN</th>
                    <th class="py-3 font-semibold">Status</th>
                    <th class="py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <!-- Outlet 1 -->
                <tr>
                    <td class="py-4">1</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="map-pin" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Kifa Bakery Pusat</div>
                                <div class="text-sm text-gray-500">outlet1@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">Jl. Merdeka No. 1, Jakarta Pusat</td>
                    <td class="py-4">0812-3456-7890</td>
                    <td class="py-4">12.345.678.9-012.345</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-green-100 text-green-700 rounded-full">Aktif</span>
                    </td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editOutlet(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Outlet 2 -->
                <tr>
                    <td class="py-4">2</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="map-pin" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Kifa Bakery Cabang 1</div>
                                <div class="text-sm text-gray-500">kifacbg1@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">Jl. Mangga No. 12, Jakarta Selatan</td>
                    <td class="py-4">0812-9876-5432</td>
                    <td class="py-4">98.765.432.1-098.765</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-green-100 text-green-700 rounded-full">Aktif</span>
                    </td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editOutlet(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Outlet 3 -->
                <tr>
                    <td class="py-4">3</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="map-pin" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Kifa Bakery Cabang 2</div>
                                <div class="text-sm text-gray-500">kifacbg2@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">Jl. Kenanga No. 25, Jakarta Timur</td>
                    <td class="py-4">0812-8765-4321</td>
                    <td class="py-4">87.654.321.0-987.654</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-yellow-100 text-yellow-700 rounded-full">Renovasi</span>
                    </td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 bottom-full mb-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editOutlet(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
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

@include('partials.outlet.modal-tambah-outlet')
@include('partials.outlet.modal-edit-outlet')

<script>
    // Variabel global untuk menyimpan ID outlet yang akan dihapus
    let outletIdToDelete = null;

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

    // Fungsi untuk menampilkan modal konfirmasi hapus
    function showConfirmDelete(id) {
        outletIdToDelete = id;
        const modal = document.getElementById('modalHapusOutlet');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Fungsi untuk menutup modal konfirmasi hapus
    function closeConfirmDelete() {
        const modal = document.getElementById('modalHapusOutlet');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        outletIdToDelete = null;
    }

    // Fungsi untuk menghapus outlet
    function hapusOutlet() {
        if (outletIdToDelete) {
            console.log('Menghapus outlet ID:', outletIdToDelete);
            // Di sini Anda bisa menambahkan AJAX request untuk menghapus data
            
            // Tampilkan alert sukses
            showAlert('success', 'Outlet berhasil dihapus!');
            
            // Tutup modal konfirmasi
            closeConfirmDelete();
            
            // Di production, Anda mungkin perlu me-refresh data atau menghapus baris dari tabel
        }
    }

    // Event listener untuk modal konfirmasi hapus
    document.getElementById('btnBatalHapus').addEventListener('click', closeConfirmDelete);
    document.getElementById('btnKonfirmasiHapus').addEventListener('click', hapusOutlet);

    // Fungsi toggle dropdown (sama seperti sebelumnya)
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
        } else {
            // Tampilkan ke bawah
            menu.classList.add('dropdown-down');
        }
    }

    // Tutup semua dropdown jika klik di luar
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.relative.inline-block')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
                menu.classList.remove('dropdown-up');
                menu.classList.remove('dropdown-down');
            });
        }
    });

    // Fungsi untuk modal tambah dan edit (sama seperti sebelumnya)
    const modalTambah = document.getElementById('modalTambahOutlet');
    const modalEdit = document.getElementById('modalEditOutlet');
    const batalBtnTambah = document.getElementById('btnBatalModalTambah');
    const batalBtnEdit = document.getElementById('btnBatalModalEdit');

    function openModalTambah() {
        modalTambah.classList.remove('hidden');
        modalTambah.classList.add('flex');
    }

    function closeModalTambah() {
        modalTambah.classList.add('hidden');
        modalTambah.classList.remove('flex');
    }
    
    function openModalEdit() {
        modalEdit.classList.remove('hidden');
        modalEdit.classList.add('flex');
    }
    
    function closeModalEdit() {
        modalEdit.classList.add('hidden');
        modalEdit.classList.remove('flex');
    }

    // Klik batal untuk modal tambah
    batalBtnTambah.addEventListener('click', () => {
        closeModalTambah();
    });
    
    // Klik batal untuk modal edit
    batalBtnEdit.addEventListener('click', () => {
        closeModalEdit();
    });

    function editOutlet(id) {
        console.log('Edit outlet ID:', id);
        openModalEdit();
        
        const outletData = {
            1: {
                nama: 'Kifa Bakery Pusat',
                alamat: 'Jl. Merdeka No. 1, Jakarta Pusat',
                kontak: '0812-3456-7890',
                ppn: '12.345.678.9-012.345',
                status: 'Aktif'
            },
            2: {
                nama: 'Kifa Bakery Cabang 1',
                alamat: 'Jl. Mangga No. 12, Jakarta Selatan',
                kontak: '0812-9876-5432',
                ppn: '98.765.432.1-098.765',
                status: 'Aktif'
            },
            3: {
                nama: 'Kifa Bakery Cabang 2',
                alamat: 'Jl. Kenanga No. 25, Jakarta Timur',
                kontak: '0812-8765-4321',
                ppn: '87.654.321.0-987.654',
                status: 'Renovasi'
            }
        };
        
        if (outletData[id]) {
            document.getElementById('editNamaOutlet').value = outletData[id].nama;
            document.getElementById('editAlamatOutlet').value = outletData[id].alamat;
            document.getElementById('editKontakOutlet').value = outletData[id].kontak;
            document.getElementById('editPpnOutlet').value = outletData[id].ppn;
            document.getElementById('editStatusOutlet').value = outletData[id].status;
            document.getElementById('outletIdToEdit').value = id;
        }
    }

    // Simulasi aksi form
    document.getElementById('formTambahOutlet')?.addEventListener('submit', function(e) {
        e.preventDefault();
        closeModalTambah();
        showAlert('success', 'Outlet baru berhasil ditambahkan!');
    });

    document.getElementById('formEditOutlet')?.addEventListener('submit', function(e) {
        e.preventDefault();
        closeModalEdit();
        showAlert('success', 'Data outlet berhasil diperbarui!');
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