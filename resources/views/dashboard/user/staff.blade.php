@extends('layouts.app')

@section('title', 'Manajemen Staff')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Staff</h1>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <!-- Input dengan ikon pencarian -->
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                </span>
                <input type="text" placeholder="Pencarian...."
                    class="w-full pl-10 pr-4 py-3 border rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
            </div>

            <!-- Tombol Tambah Staff -->
            <a href="#" onclick="openModalTambahStaff()"
                class="px-5 py-3 text-base font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 shadow">
                + Tambah Staff
            </a>
        </div>
    </div>
</div>

<!-- Card: Staff Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="users" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Daftar Staff</h2>
            <p class="text-sm text-gray-600">Kelola staff dan penugasan shift.</p>
        </div>
    </div>
</div>

<!-- Card: Tabel Staff -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-semibold">Nama</th>
                    <th class="py-3 font-semibold">Peran</th>
                    <th class="py-3 font-semibold">Shift</th>
                    <th class="py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <!-- Staff 1 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Mona</div>
                                <div class="text-sm text-gray-500">mona@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-blue-100 text-blue-700 rounded-full">Kasir</span>
                    </td>
                    <td class="py-4">07:45:00 - 07:45:00</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editStaff(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(1)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Staff 2 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Pusat</div>
                                <div class="text-sm text-gray-500">pusat@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-purple-100 text-purple-700 rounded-full">Supervisor</span>
                    </td>
                    <td class="py-4">07:48:00 - 07:48:00</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editStaff(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(2)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Staff 3 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">Pak Agung</div>
                                <div class="text-sm text-gray-500">agung@example.com</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium bg-green-100 text-green-700 rounded-full">Admin</span>
                    </td>
                    <td class="py-4">09:00:00 - 09:00:00</td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 bottom-full mb-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editStaff(3)" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
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

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapusStaff" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-96">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-600">Anda yakin ingin menghapus staff ini? Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="mt-4 flex justify-end gap-3">
                    <button id="btnBatalHapusStaff" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button id="btnKonfirmasiHapusStaff" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md shadow-sm hover:bg-red-700 focus:outline-none">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Staff -->
<div id="modalTambahStaff" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalTambahStaff()">
  <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg max-h-screen flex flex-col" onclick="event.stopPropagation()">
    
    <!-- Header -->
    <div class="p-6 border-b">
      <h2 class="text-xl font-semibold">Tambah Staff Baru</h2>
      <p class="text-sm text-gray-500">Tambahkan staff baru dengan mengisi detail di bawah ini.</p>
    </div>

    <!-- Scrollable Content -->
    <div class="overflow-y-auto p-6 space-y-6 flex-1">
      <div class="space-y-4">
        <!-- Nama Staff -->
        <div>
          <label class="block font-medium mb-1">Nama <span class="text-red-500">*</span></label>
          <input type="text" id="namaStaff" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Nama staff" required>
          <p id="errorNamaStaff" class="text-red-500 text-xs mt-1 hidden">Nama staff wajib diisi</p>
        </div>

        <!-- Email Staff -->
        <div>
          <label class="block font-medium mb-1">Email <span class="text-red-500">*</span></label>
          <input type="email" id="emailStaff" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Email staff" required>
          <p id="errorEmailStaff" class="text-red-500 text-xs mt-1 hidden">Email wajib diisi dan valid</p>
        </div>

        <!-- Password -->
        <div>
          <label class="block font-medium mb-1">Password <span class="text-red-500">*</span></label>
          <input type="password" id="passwordStaff" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Password" required>
          <p id="errorPasswordStaff" class="text-red-500 text-xs mt-1 hidden">Password wajib diisi (min. 8 karakter)</p>
        </div>

        <!-- Peran -->
        <div>
          <label class="block font-medium mb-1">Peran <span class="text-red-500">*</span></label>
          <select id="peranStaff" class="w-full border rounded-lg px-4 py-2 text-sm" required>
            <option value="" disabled selected>Pilih peran</option>
            <option value="kasir">Kasir</option>
            <option value="supervisor">Supervisor</option>
            <option value="admin">Admin</option>
            <option value="manajer">Manajer</option>
          </select>
          <p id="errorPeranStaff" class="text-red-500 text-xs mt-1 hidden">Peran wajib dipilih</p>
        </div>

        <!-- Shift -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Waktu Mulai</label>
            <input type="time" id="waktuMulai" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="--.--">
          </div>
          <div>
            <label class="block font-medium mb-1">Waktu Selesai</label>
            <input type="time" id="waktuSelesai" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="--.--">
          </div>
        </div>

        <!-- Outlet -->
        <div>
          <label class="block font-medium mb-1">Outlet</label>
          <select id="outletStaff" class="w-full border rounded-lg px-4 py-2 text-sm">
            <option value="pusat" selected>Kifa Bakery Pusat</option>
            <option value="cabang1">Kifa Bakery Cabang 1</option>
            <option value="cabang2">Kifa Bakery Cabang 2</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="p-6 border-t flex justify-end gap-3">
      <button id="btnBatalModalTambahStaff" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
      <button id="btnTambahStaff" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 flex items-center gap-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        <span>Simpan</span>
      </button>
    </div>
  </div>
</div>

<!-- Modal Edit Staff -->
<div id="modalEditStaff" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalEditStaff()">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg max-h-screen flex flex-col" onclick="event.stopPropagation()">
      
      <!-- Header -->
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold">Edit Staff</h2>
        <p class="text-sm text-gray-500">Edit informasi staff</p>
      </div>
  
      <!-- Scrollable Content -->
      <div class="overflow-y-auto p-6 space-y-6 flex-1">
        <div class="space-y-4">
          <!-- Nama Staff -->
          <div>
            <label class="block font-medium mb-1">Nama <span class="text-red-500">*</span></label>
            <input type="text" id="editNamaStaff" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Nama staff" required>
            <p id="errorEditNamaStaff" class="text-red-500 text-xs mt-1 hidden">Nama staff wajib diisi</p>
          </div>
  
          <!-- Email Staff -->
          <div>
            <label class="block font-medium mb-1">Email <span class="text-red-500">*</span></label>
            <input type="email" id="editEmailStaff" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Email staff" required>
            <p id="errorEditEmailStaff" class="text-red-500 text-xs mt-1 hidden">Email wajib diisi dan valid</p>
          </div>
  
          <!-- Password -->
          <div>
            <label class="block font-medium mb-1">Password</label>
            <input type="password" id="editPasswordStaff" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Kosongkan jika tidak ingin mengubah">
            <p id="errorEditPasswordStaff" class="text-red-500 text-xs mt-1 hidden">Password minimal 8 karakter</p>
          </div>
  
          <!-- Peran -->
          <div>
            <label class="block font-medium mb-1">Peran <span class="text-red-500">*</span></label>
            <select id="editPeranStaff" class="w-full border rounded-lg px-4 py-2 text-sm" required>
              <option value="" disabled>Pilih peran</option>
              <option value="kasir">Kasir</option>
              <option value="supervisor">Supervisor</option>
              <option value="admin">Admin</option>
              <option value="manajer">Manajer</option>
            </select>
            <p id="errorEditPeranStaff" class="text-red-500 text-xs mt-1 hidden">Peran wajib dipilih</p>
          </div>
  
          <!-- Shift -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium mb-1">Waktu Mulai</label>
              <input type="time" id="editWaktuMulai" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="--.--">
            </div>
            <div>
              <label class="block font-medium mb-1">Waktu Selesai</label>
              <input type="time" id="editWaktuSelesai" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="--.--">
            </div>
          </div>
  
          <!-- Outlet -->
          <div>
            <label class="block font-medium mb-1">Outlet</label>
            <select id="editOutletStaff" class="w-full border rounded-lg px-4 py-2 text-sm">
              <option value="pusat">Kifa Bakery Pusat</option>
              <option value="cabang1">Kifa Bakery Cabang 1</option>
              <option value="cabang2">Kifa Bakery Cabang 2</option>
            </select>
          </div>
        </div>
      </div>
  
      <!-- Footer -->
      <div class="p-6 border-t flex justify-end gap-3">
        <button id="btnBatalModalEditStaff" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
        <button id="btnSimpanEditStaff" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i>
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </div>
  </div>

<script>

// Fungsi untuk menampilkan search
function setupRealTimeSearch() {
    const searchInput = document.querySelector('input[type="text"][placeholder="Pencarian...."]');
    
    if (searchInput) {
        // Tambahkan event listener untuk input
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const nama = row.querySelector('td:first-child .font-semibold').textContent.toLowerCase();
                const email = row.querySelector('td:first-child .text-sm').textContent.toLowerCase();
                const peran = row.querySelector('td:nth-child(2) span').textContent.toLowerCase();
                const shift = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                if (nama.includes(searchTerm) || 
                    email.includes(searchTerm) || 
                    peran.includes(searchTerm) || 
                    shift.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Tambahkan debounce untuk optimasi performa
        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }
        
        const processChange = debounce((e) => {
            // Logika pencarian sudah di atas
        });
        
        searchInput.addEventListener('input', processChange);
    }
}

// Panggil fungsi setup saat dokumen siap
document.addEventListener('DOMContentLoaded', function() {
    setupRealTimeSearch();
    
    // Inisialisasi Lucide Icons
    if (window.lucide) {
        window.lucide.createIcons();
    }
});

// Fungsi untuk menampilkan alert
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertId = 'alert-' + Date.now();
    
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
    
    if (window.lucide) {
        window.lucide.createIcons();
    }
    
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

// Fungsi untuk toggle dropdown
function toggleDropdown(button) {
    const menu = button.nextElementSibling;

    document.querySelectorAll('.dropdown-menu').forEach(m => {
        if (m !== menu) {
            m.classList.add('hidden');
            m.classList.remove('dropdown-up');
            m.classList.remove('dropdown-down');
        }
    });

    menu.classList.toggle('hidden');
    menu.classList.remove('dropdown-up', 'dropdown-down');

    const menuRect = menu.getBoundingClientRect();
    const buttonRect = button.getBoundingClientRect();
    const spaceBelow = window.innerHeight - buttonRect.bottom;
    const spaceAbove = buttonRect.top;

    if (spaceBelow < menuRect.height && spaceAbove > menuRect.height) {
        menu.classList.add('dropdown-up');
    } else {
        menu.classList.add('dropdown-down');
    }
}

// Tutup dropdown jika klik di luar
document.addEventListener('click', function (e) {
    if (!e.target.closest('.relative.inline-block')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
            menu.classList.remove('dropdown-up');
            menu.classList.remove('dropdown-down');
        });
    }
});

// Modal Edit Staff
const modalEditStaff = document.getElementById('modalEditStaff');
const batalBtnEditStaff = document.getElementById('btnBatalModalEditStaff');
let currentEditStaffId = null;

function openModalEditStaff(id) {
    currentEditStaffId = id;
    
    // In a real application, you would fetch the staff data from your backend
    // Here we're just simulating with dummy data
    const dummyStaffData = {
        1: {
            nama: 'Mona',
            email: 'mona@example.com',
            peran: 'kasir',
            waktuMulai: '07:45',
            waktuSelesai: '07:45',
            outlet: 'pusat'
        },
        2: {
            nama: 'Pusat',
            email: 'pusat@example.com',
            peran: 'supervisor',
            waktuMulai: '07:48',
            waktuSelesai: '07:48',
            outlet: 'pusat'
        },
        3: {
            nama: 'Pak Agung',
            email: 'agung@example.com',
            peran: 'admin',
            waktuMulai: '09:00',
            waktuSelesai: '09:00',
            outlet: 'pusat'
        }
    };
    
    const staffData = dummyStaffData[id] || dummyStaffData[1];
    
    // Fill the form with staff data
    document.getElementById('editNamaStaff').value = staffData.nama;
    document.getElementById('editEmailStaff').value = staffData.email;
    document.getElementById('editPeranStaff').value = staffData.peran;
    document.getElementById('editWaktuMulai').value = staffData.waktuMulai;
    document.getElementById('editWaktuSelesai').value = staffData.waktuSelesai;
    document.getElementById('editOutletStaff').value = staffData.outlet;
    
    modalEditStaff.classList.remove('hidden');
    modalEditStaff.classList.add('flex');
}

function closeModalEditStaff() {
    modalEditStaff.classList.add('hidden');
    modalEditStaff.classList.remove('flex');
    currentEditStaffId = null;
}

batalBtnEditStaff.addEventListener('click', closeModalEditStaff);

// Fungsi edit staff - PENTING: Hanya definisikan SATU kali
function editStaff(id) {
    openModalEditStaff(id);
}

// Validasi form edit staff
function validateEditFormStaff() {
    let isValid = true;
    
    // Validasi nama
    const namaStaff = document.getElementById('editNamaStaff');
    const errorNamaStaff = document.getElementById('errorEditNamaStaff');
    if (!namaStaff.value.trim()) {
        errorNamaStaff.classList.remove('hidden');
        namaStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorNamaStaff.classList.add('hidden');
        namaStaff.classList.remove('border-red-500');
    }
    
    // Validasi email
    const emailStaff = document.getElementById('editEmailStaff');
    const errorEmailStaff = document.getElementById('errorEditEmailStaff');
    if (!emailStaff.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailStaff.value)) {
        errorEmailStaff.classList.remove('hidden');
        emailStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorEmailStaff.classList.add('hidden');
        emailStaff.classList.remove('border-red-500');
    }
    
    // Validasi password (optional)
    const passwordStaff = document.getElementById('editPasswordStaff');
    const errorPasswordStaff = document.getElementById('errorEditPasswordStaff');
    if (passwordStaff.value.trim() && passwordStaff.value.length < 8) {
        errorPasswordStaff.classList.remove('hidden');
        passwordStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorPasswordStaff.classList.add('hidden');
        passwordStaff.classList.remove('border-red-500');
    }
    
    // Validasi peran
    const peranStaff = document.getElementById('editPeranStaff');
    const errorPeranStaff = document.getElementById('errorEditPeranStaff');
    if (!peranStaff.value) {
        errorPeranStaff.classList.remove('hidden');
        peranStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorPeranStaff.classList.add('hidden');
        peranStaff.classList.remove('border-red-500');
    }
    
    return isValid;
}

// Submit form edit staff
document.getElementById('btnSimpanEditStaff').addEventListener('click', function() {
    if (validateEditFormStaff()) {
        // Simulasi loading
        const btnEdit = this;
        const originalText = btnEdit.innerHTML;
        btnEdit.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
        btnEdit.disabled = true;
        
        // Simulasi AJAX request
        setTimeout(() => {
            const formData = {
                id: currentEditStaffId,
                nama: document.getElementById('editNamaStaff').value,
                email: document.getElementById('editEmailStaff').value,
                peran: document.getElementById('editPeranStaff').value,
                shift: {
                    mulai: document.getElementById('editWaktuMulai').value,
                    selesai: document.getElementById('editWaktuSelesai').value
                },
                outlet: document.getElementById('editOutletStaff').value
            };
            
            if (document.getElementById('editPasswordStaff').value.trim()) {
                formData.password = document.getElementById('editPasswordStaff').value;
            }
            
            console.log('Data staff yang akan diupdate:', formData);
            
            // Tutup modal
            closeModalEditStaff();
            
            // Tampilkan alert sukses
            showAlert('success', 'Data staff berhasil diperbarui!');
            
            // Kembalikan tombol ke state semula
            btnEdit.innerHTML = originalText;
            btnEdit.disabled = false;
            
            // In a real app, you would update the table here
        }, 1500);
    }
});

// Modal Tambah Staff
const modalTambahStaff = document.getElementById('modalTambahStaff');
const batalBtnTambahStaff = document.getElementById('btnBatalModalTambahStaff');

function openModalTambahStaff() {
    modalTambahStaff.classList.remove('hidden');
    modalTambahStaff.classList.add('flex');
}

function closeModalTambahStaff() {
    modalTambahStaff.classList.add('hidden');
    modalTambahStaff.classList.remove('flex');
}

batalBtnTambahStaff.addEventListener('click', closeModalTambahStaff);

// Modal Hapus Staff
const modalHapusStaff = document.getElementById('modalHapusStaff');
const batalBtnHapusStaff = document.getElementById('btnBatalHapusStaff');
const konfirmasiBtnHapusStaff = document.getElementById('btnKonfirmasiHapusStaff');
let staffIdToDelete = null;

function showConfirmDelete(id) {
    staffIdToDelete = id;
    modalHapusStaff.classList.remove('hidden');
    modalHapusStaff.classList.add('flex');
}

function closeConfirmDeleteStaff() {
    modalHapusStaff.classList.add('hidden');
    modalHapusStaff.classList.remove('flex');
    staffIdToDelete = null;
}

function hapusStaff() {
    if (staffIdToDelete) {
        console.log('Menghapus staff ID:', staffIdToDelete);
        showAlert('success', 'Staff berhasil dihapus!');
        closeConfirmDeleteStaff();
    }
}

batalBtnHapusStaff.addEventListener('click', closeConfirmDeleteStaff);
konfirmasiBtnHapusStaff.addEventListener('click', hapusStaff);

// Validasi form tambah staff
function validateFormStaff() {
    let isValid = true;
    
    // Validasi nama
    const namaStaff = document.getElementById('namaStaff');
    const errorNamaStaff = document.getElementById('errorNamaStaff');
    if (!namaStaff.value.trim()) {
        errorNamaStaff.classList.remove('hidden');
        namaStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorNamaStaff.classList.add('hidden');
        namaStaff.classList.remove('border-red-500');
    }
    
    // Validasi email
    const emailStaff = document.getElementById('emailStaff');
    const errorEmailStaff = document.getElementById('errorEmailStaff');
    if (!emailStaff.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailStaff.value)) {
        errorEmailStaff.classList.remove('hidden');
        emailStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorEmailStaff.classList.add('hidden');
        emailStaff.classList.remove('border-red-500');
    }
    
    // Validasi password
    const passwordStaff = document.getElementById('passwordStaff');
    const errorPasswordStaff = document.getElementById('errorPasswordStaff');
    if (!passwordStaff.value.trim() || passwordStaff.value.length < 8) {
        errorPasswordStaff.classList.remove('hidden');
        passwordStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorPasswordStaff.classList.add('hidden');
        passwordStaff.classList.remove('border-red-500');
    }
    
    // Validasi peran
    const peranStaff = document.getElementById('peranStaff');
    const errorPeranStaff = document.getElementById('errorPeranStaff');
    if (!peranStaff.value) {
        errorPeranStaff.classList.remove('hidden');
        peranStaff.classList.add('border-red-500');
        isValid = false;
    } else {
        errorPeranStaff.classList.add('hidden');
        peranStaff.classList.remove('border-red-500');
    }
    
    return isValid;
}

// Submit form tambah staff
document.getElementById('btnTambahStaff').addEventListener('click', function() {
    if (validateFormStaff()) {
        // Simulasi loading
        const btnTambah = this;
        const originalText = btnTambah.innerHTML;
        btnTambah.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
        btnTambah.disabled = true;
        
        // Simulasi AJAX request
        setTimeout(() => {
            const formData = {
                nama: document.getElementById('namaStaff').value,
                email: document.getElementById('emailStaff').value,
                peran: document.getElementById('peranStaff').value,
                shift: {
                    mulai: document.getElementById('waktuMulai').value,
                    selesai: document.getElementById('waktuSelesai').value
                },
                outlet: document.getElementById('outletStaff').value
            };
            
            console.log('Data staff yang akan dikirim:', formData);
            
            // Reset form
            document.getElementById('namaStaff').value = '';
            document.getElementById('emailStaff').value = '';
            document.getElementById('passwordStaff').value = '';
            document.getElementById('peranStaff').value = '';
            document.getElementById('waktuMulai').value = '';
            document.getElementById('waktuSelesai').value = '';
            document.getElementById('outletStaff').value = 'pusat';
            
            // Tutup modal
            closeModalTambahStaff();
            
            // Tampilkan alert sukses
            showAlert('success', 'Staff baru berhasil ditambahkan!');
            
            // Kembalikan tombol ke state semula
            btnTambah.innerHTML = originalText;
            btnTambah.disabled = false;
        }, 1500);
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
    
    /* Style untuk dropdown */
    .dropdown-up {
        bottom: 100%;
        top: auto;
        margin-bottom: 5px;
    }
    
    .dropdown-down {
        top: 100%;
        bottom: auto;
        margin-top: 5px;
    }
</style>

@endsection