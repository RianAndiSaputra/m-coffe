@extends('layouts.app')

@section('title', 'Manajemen Member')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusMember" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Anda yakin ingin menghapus member ini? Data yang dihapus tidak dapat dikembalikan.</p>
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
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Member</h1>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <!-- Input dengan ikon pencarian -->
            <div class="relative w-full md:w-64">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
              </span>
              <input id="searchInput" type="text" placeholder="Pencarian...."
                  class="w-full pl-10 pr-4 py-3 border rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
          </div>

            <!-- Tombol Tambah Member -->
            <a href="#" onclick="openModalTambah()"
                class="px-5 py-3 text-base font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 shadow">
                + Tambah Member
            </a>
        </div>
    </div>
</div>

<!-- Card: Member Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="users" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Manajemen Member</h2>
            <p class="text-sm text-gray-600">Kelola semua member Kifa Bakery di sini.</p>
        </div>
    </div>
</div>

<!-- Card: Tabel Member -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="memberTable" class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-semibold">No.</th>
                    <th class="py-3 font-semibold">Nama</th>
                    <th class="py-3 font-semibold">Kode Member</th>
                    <th class="py-3 font-semibold">Email</th>
                    <th class="py-3 font-semibold">Alamat</th>
                    <th class="py-3 font-semibold">Jenis Kelamin</th>
                    <th class="py-3 font-semibold">Total Transaksi</th>
                    <th class="py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <!-- Member 1 -->
                <tr>
                    <td class="py-4">1</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Agen July</div>
                                <div class="text-sm text-gray-500">0812-3456-7890</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">0000001</td>
                    <td class="py-4">-</td>
                    <td class="py-4">Klaten</td>
                    <td class="py-4">Laki-laki</td>
                    <td class="py-4">5</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <div class="px-4 py-2 font-bold text-left border-b">Aksi</div>
                                <button onclick="history(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                    <i data-lucide="history" class="w-5 h-5 mr-3 text-gray-500"></i> History
                                </button>
                                <button onclick="editMember(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Member 2 -->
                <tr>
                    <td class="py-4">2</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Agen Sarah</div>
                                <div class="text-sm text-gray-500">0812-9876-5432</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">0000002</td>
                    <td class="py-4">sarah@example.com</td>
                    <td class="py-4">Yogyakarta</td>
                    <td class="py-4">Perempuan</td>
                    <td class="py-4">12</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <div class="px-4 py-2 font-bold text-left border-b">Aksi</div>
                                <button onclick="history(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                    <i data-lucide="history" class="w-5 h-5 mr-3 text-gray-500"></i> History
                                </button>
                                <button onclick="editMember(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Member 3 -->
                <tr>
                    <td class="py-4">3</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Agen Budi</div>
                                <div class="text-sm text-gray-500">0812-8765-4321</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">0000003</td>
                    <td class="py-4">budi@example.com</td>
                    <td class="py-4">Solo</td>
                    <td class="py-4">Laki-laki</td>
                    <td class="py-4">8</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <div class="px-4 py-2 font-bold text-left border-b">Aksi</div>
                                <button onclick="history(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                    <i data-lucide="history" class="w-5 h-5 mr-3 text-gray-500"></i> History
                                </button>
                                <button onclick="editMember(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600">
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

@include('partials.member.tambah-member')
@include('partials.member.edit-member')

<script>
    // Variabel global untuk menyimpan ID member yang akan dihapus
    let memberIdToDelete = null;

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
        memberIdToDelete = id;
        const modal = document.getElementById('modalHapusMember');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Fungsi untuk menutup modal konfirmasi hapus
    function closeConfirmDelete() {
        const modal = document.getElementById('modalHapusMember');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        memberIdToDelete = null;
    }

    // Fungsi untuk menghapus member
    function hapusMember() {
        if (memberIdToDelete) {
            console.log('Menghapus member ID:', memberIdToDelete);
            // Di sini Anda bisa menambahkan AJAX request untuk menghapus data
            
            // Tampilkan alert sukses
            showAlert('success', 'Member berhasil dihapus!');
            
            // Tutup modal konfirmasi
            closeConfirmDelete();
            
            // Di production, Anda mungkin perlu me-refresh data atau menghapus baris dari tabel
        }
    }

    // Fungsi untuk menampilkan history member
    function history(id) {
        console.log('Melihat history member ID:', id);
        // Implementasi untuk menampilkan history member
        showAlert('success', `Melihat history member ID: ${id}`);
    }

    // Event listener untuk modal konfirmasi hapus
    document.getElementById('btnBatalHapus').addEventListener('click', closeConfirmDelete);
    document.getElementById('btnKonfirmasiHapus').addEventListener('click', hapusMember);

    // Fungsi toggle dropdown yang diperbarui
    function toggleDropdown(button) {
        const menu = button.nextElementSibling;

        // Tutup semua dropdown lain
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            if (m !== menu) {
                m.classList.add('hidden');
            }
        });

         // Toggle dropdown terkait tombol yang diklik
    menu.classList.toggle('hidden');

        // Hitung posisi
        const buttonRect = button.getBoundingClientRect();
    const spaceBelow = window.innerHeight - buttonRect.bottom;

// Jika menu sedang ditampilkan, posisikan dengan benar
if (!menu.classList.contains('hidden')) {
    // Dapatkan koordinat dari button dan window
    const buttonRect = button.getBoundingClientRect();
    const spaceBelow = window.innerHeight - buttonRect.bottom;
    const menuHeight = menu.clientHeight || 300; // Perkiraan tinggi jika belum dirender

    // Reset posisi dan margin terlebih dahulu
    menu.style.top = '';
    menu.style.bottom = '';
    menu.style.right = '0';
    menu.style.left = '';
    menu.style.marginTop = '';
    menu.style.marginBottom = '';

    // Jika ruang di bawah tidak cukup dan ruang di atas lebih banyak
    if (spaceBelow < menuHeight && buttonRect.top > menuHeight) {
        // Tampilkan dropdown di atas tombol
        menu.style.bottom = '100%';
        menu.style.marginBottom = '5px';
    } else {
        // Tampilkan dropdown di bawah tombol
        menu.style.top = '100%';
        menu.style.marginTop = '5px';
    }

    // Periksa juga posisi horizontal untuk memastikan dropdown tetap di dalam viewport
    const menuRect = menu.getBoundingClientRect();
    if (menuRect.right > window.innerWidth) {
        // Jika terlalu ke kanan, sesuaikan posisi ke kiri
        menu.style.right = '0';
        menu.style.left = 'auto';
    }
}
}

// Tutup semua dropdown jika klik di luar
document.addEventListener('click', function(e) {
if (!e.target.closest('.relative.inline-block')) {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
    });
}
});

    // Fungsi untuk modal tambah dan edit
    const modalTambah = document.getElementById('modalTambahMember');
    const modalEdit = document.getElementById('modalEditMember');
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
    batalBtnTambah?.addEventListener('click', () => {
        closeModalTambah();
    });
    
    // Klik batal untuk modal edit
    batalBtnEdit?.addEventListener('click', () => {
        closeModalEdit();
    });

    function editMember(id) {
        console.log('Edit member ID:', id);
        openModalEdit();
        
        const memberData = {
            1: {
                nama: 'Agen July',
                telepon: '0812-3456-7890',
                email: '',
                alamat: 'Klaten',
                jenis_kelamin: 'Laki-laki'
            },
            2: {
                nama: 'Agen Sarah',
                telepon: '0812-9876-5432',
                email: 'sarah@example.com',
                alamat: 'Yogyakarta',
                jenis_kelamin: 'Perempuan'
            },
            3: {
                nama: 'Agen Budi',
                telepon: '0812-8765-4321',
                email: 'budi@example.com',
                alamat: 'Solo',
                jenis_kelamin: 'Laki-laki'
            }
        };
        
        if (memberData[id]) {
            document.getElementById('editNamaMember').value = memberData[id].nama;
            document.getElementById('editTeleponMember').value = memberData[id].telepon;
            document.getElementById('editEmailMember').value = memberData[id].email;
            document.getElementById('editAlamatMember').value = memberData[id].alamat;
            document.getElementById('editJenisKelamin').value = memberData[id].jenis_kelamin;
            document.getElementById('memberIdToEdit').value = id;
        }
    }

    // Simulasi aksi form
    document.getElementById('formTambahMember')?.addEventListener('submit', function(e) {
        e.preventDefault();
        closeModalTambah();
        showAlert('success', 'Member baru berhasil ditambahkan!');
    });

    document.getElementById('formEditMember')?.addEventListener('submit', function(e) {
        e.preventDefault();
        closeModalEdit();
        showAlert('success', 'Data member berhasil diperbarui!');
    });

    // Fungsi untuk melakukan pencarian member
    function searchMembers() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const tableRows = document.querySelectorAll('#memberTable tbody tr:not(#noResultsMessage)');
        let found = false;
        
        // Loop melalui semua baris dalam tabel
        tableRows.forEach(row => {
            // Jangan proses jika ini adalah baris pesan "tidak ada hasil"
            if (row.id === 'noResultsMessage') return;
            
            // Ambil data yang akan dicari
            const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const telepon = row.querySelector('td:nth-child(2) .text-sm').textContent.toLowerCase();
            const kodeMember = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const alamat = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
            
            // Cek apakah kata kunci pencarian ada di salah satu kolom
            if (nama.includes(searchInput) || 
                telepon.includes(searchInput) || 
                kodeMember.includes(searchInput) || 
                email.includes(searchInput) || 
                alamat.includes(searchInput)) {
                row.classList.remove('hidden');
                found = true;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Hapus pesan "tidak ada hasil" yang sudah ada
        const existingNoResults = document.getElementById('noResultsMessage');
        if (existingNoResults) {
            existingNoResults.remove();
        }
        
        // Jika tidak ada hasil dan input tidak kosong, tampilkan pesan
        if (!found && searchInput !== '') {
            const tbody = document.querySelector('#memberTable tbody');
            const noResults = document.createElement('tr');
            noResults.id = 'noResultsMessage';
            noResults.innerHTML = `
                <td colspan="8" class="py-8 text-center">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                        <p class="text-gray-500 font-medium">Tidak ada member yang ditemukan</p>
                        <p class="text-gray-400 text-sm">Coba gunakan kata kunci lain</p>
                    </div>
                </td>
            `;
            tbody.appendChild(noResults);
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
    }

    // Event listener untuk input pencarian dengan debounce
    let debounceTimer;
    document.getElementById('searchInput')?.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            searchMembers();
        }, 300); // Delay 300ms setelah user selesai mengetik
    });

    // Event listener untuk enter key pada input pencarian
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(debounceTimer);
            searchMembers();
        }
    });

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Lucide icons jika tersedia
        if (window.lucide) {
            window.lucide.createIcons();
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
    
    /* Styling untuk dropdown */
    .dropdown-menu {
        position: absolute;
        right: 0;
        z-index: 9999; /* Nilai sangat tinggi */
        margin-top: 0.25rem;
        width: 10rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform-origin: top right;
    }
.relative.inline-block {
        position: relative;
    }
    td {
        overflow: visible !important;
    }
/* Animasi untuk dropdowns */
@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes dropdownFadeInUp {
    from {
        opacity: 0;
        transform: translateY(5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-animation-down {
    animation: dropdownFadeIn 0.2s ease-out forwards;
}

.dropdown-animation-up {
    animation: dropdownFadeInUp 0.2s ease-out forwards;
}
</style>

@endsection