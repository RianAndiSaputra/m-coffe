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
            <!-- Input dengan ikon pencarian -->
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                </span>
                <input type="text" id="searchInput" placeholder="Pencarian...."
                    class="w-full pl-10 pr-4 py-3 border rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
            </div>

            <!-- Tombol Tambah Outlet -->
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
            <tbody id="outletTableBody" class="text-gray-700 divide-y">
                <!-- Data outlet akan dimuat secara dinamis di sini -->
            </tbody>
        </table>
    </div>
</div>

@include('partials.outlet.modal-tambah-outlet')
@include('partials.outlet.modal-edit-outlet')

<script>
   // Variabel global
        let outletIdToDelete = null;
        let allOutlets = [];

        // Fungsi untuk mendapatkan CSRF token
        function getCSRFToken() {
            // Cari meta tag dengan name="csrf-token"
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.getAttribute('content');
            }
            return null;
        }

        // Fungsi untuk memuat data outlet dari API
        async function loadOutlets() {
            try {
                const token = localStorage.getItem('token');
                
                const response = await fetch('http://127.0.0.1:8000/api/outlets', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                // Cek jika diarahkan ke halaman login
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                
                const data = await response.json();
                
                if (data.success) {
                    allOutlets = data.data;
                    renderOutlets(allOutlets);
                } else {
                    showAlert('error', 'Gagal memuat data outlet');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat memuat data');
            }
        }

        // Fungsi untuk menampilkan data outlet di tabel
        function renderOutlets(outlets) {
            const tableBody = document.getElementById('outletTableBody');
            tableBody.innerHTML = '';

            outlets.forEach((outlet, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="py-4">${index + 1}</td>
                    <td class="py-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <i data-lucide="map-pin" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-base text-gray-900">${outlet.name}</div>
                                <div class="text-sm text-gray-500">${outlet.email}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4">${outlet.address}</td>
                    <td class="py-4">${outlet.phone}</td>
                    <td class="py-4">${outlet.tax}%</td>
                    <td class="py-4">
                        <span class="px-3 py-1.5 text-sm font-medium ${outlet.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'} rounded-full">
                            ${outlet.is_active ? 'Aktif' : 'Tidak Aktif'}
                        </span>
                    </td>
                    <td class="py-4 relative">
                        <div class="relative inline-block">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                                <button onclick="editOutlet(${outlet.id})" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left rounded-t-lg">
                                    <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                                </button>
                                <button onclick="showConfirmDelete(${outlet.id})" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Inisialisasi ikon Lucide
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

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
            //fungsi delete
        async function hapusOutlet() {
            if (!outletIdToDelete) return;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const token = localStorage.getItem('token');
            
            try {
                const response = await fetch(`/api/outlets/${outletIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include'
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Gagal menghapus outlet');
                }
                
                showAlert('success', data.message || 'Outlet berhasil dihapus');
                allOutlets = allOutlets.filter(outlet => outlet.id !== outletIdToDelete);
                renderOutlets(allOutlets);
            } catch (error) {
                console.error('Delete error:', error);
                showAlert('error', error.message);
            } finally {
                closeConfirmDelete();
            }
        }
        // Fungsi untuk menambahkan outlet baru
        async function tambahOutlet() {
            // Validasi form sebelum submit
            if (!validateForm()) {
                return;
            }

            const formData = new FormData();
            formData.append('name', document.getElementById('namaOutlet').value);
            formData.append('phone', document.getElementById('teleponOutlet').value);
            formData.append('address', document.getElementById('alamatOutlet').value);
            formData.append('email', document.getElementById('emailOutlet').value);
            formData.append('tax', document.getElementById('pajakOutlet').value || '0.00');
            formData.append('nomor_transaksi_bank', document.getElementById('nomorTransaksi').value);
            formData.append('nama_bank', document.getElementById('namaBank').value);
            formData.append('atas_nama_bank', document.getElementById('atasNama').value);
            formData.append('is_active', document.getElementById('statusAktif').checked ? '1' : '0');
            
            const fileInput = document.getElementById('fotoOutlet');
            if (fileInput.files[0]) {
                formData.append('qris', fileInput.files[0]);
            }

            // Tambahkan CSRF token
            const csrfToken = getCSRFToken();
            if (csrfToken) {
                formData.append('_token', csrfToken);
            }

            // Tampilkan loading state
            const btnTambah = document.getElementById('btnTambahOutlet');
            const originalText = btnTambah.innerHTML;
            btnTambah.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            btnTambah.disabled = true;

            try {
                const token = localStorage.getItem('token');
                const response = await fetch('http://127.0.0.1:8000/api/outlets', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                // Cek jika diarahkan ke halaman login
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                const data = await response.json();

                if (data.success) {
                    showAlert('success', 'Outlet berhasil ditambahkan!');
                    closeModalTambah();
                    loadOutlets(); // Memuat ulang data
                    resetForm();
                } else {
                    showAlert('error', data.message || 'Gagal menambahkan outlet');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat menambahkan outlet');
            } finally {
                // Kembalikan ke state semula
                btnTambah.innerHTML = originalText;
                btnTambah.disabled = false;
            }
        }

            async function updateOutlet() {
        // Validasi form (tetap gunakan kode validasi yang ada)
        if (!validateEditForm()) {
            return;
        }

        const outletId = document.getElementById('outletIdToEdit').value;
        if (!outletId) return;

        // Siapkan data form
        const formData = new FormData();
        formData.append('name', document.getElementById('editNamaOutlet').value);
        formData.append('phone', document.getElementById('editNomorTelepon').value);
        formData.append('address', document.getElementById('editAlamatLengkap').value);
        formData.append('email', document.getElementById('editEmail').value);
        formData.append('tax', document.getElementById('editPersentasePajak').value || '0.00');
        formData.append('nomor_transaksi_bank', document.getElementById('editNoTransaksi').value);
        formData.append('nama_bank', document.getElementById('editNamaBank').value);
        formData.append('atas_nama_bank', document.getElementById('editAtasNama').value);
        formData.append('is_active', document.getElementById('editStatusAktif').checked ? '1' : '0');
        
        // Tambahkan file jika ada
        const fileInput = document.getElementById('editFotoOutlet');
        if (fileInput.files[0]) {
            formData.append('qris', fileInput.files[0]);
        }

        // Dapatkan token CSRF
        const csrfToken = getCSRFToken();
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        // Tampilkan loading
        const btnSimpan = document.getElementById('btnSimpanPerubahan');
        const originalText = btnSimpan.innerHTML;
        btnSimpan.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
        btnSimpan.disabled = true;

        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`http://127.0.0.1:8000/api/outlets/${outletId}`, {
                method: 'POST', // Tetap gunakan POST karena Laravel menerima _method
                body: formData,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const data = await response.json();

            if (data.success) {
                showAlert('success', 'Outlet berhasil diperbarui!');
                closeModalEdit();
                loadOutlets(); // Muat ulang data
            } else {
                showAlert('error', data.message || 'Gagal memperbarui outlet');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat memperbarui outlet');
        } finally {
            // Kembalikan tombol ke state semula
            btnSimpan.innerHTML = originalText;
            btnSimpan.disabled = false;
        }
    }

        // Fungsi untuk mengisi form edit dengan data outlet
        function editOutlet(id) {
            const outlet = allOutlets.find(o => o.id == id);
            if (!outlet) return;

            document.getElementById('outletIdToEdit').value = outlet.id;
            document.getElementById('editNamaOutlet').value = outlet.name;
            document.getElementById('editNomorTelepon').value = outlet.phone;
            document.getElementById('editAlamatLengkap').value = outlet.address;
            document.getElementById('editEmail').value = outlet.email;
            document.getElementById('editPersentasePajak').value = outlet.tax;
            document.getElementById('editNoTransaksi').value = outlet.nomor_transaksi_bank || '';
            document.getElementById('editNamaBank').value = outlet.nama_bank || '';
            document.getElementById('editAtasNama').value = outlet.atas_nama_bank || '';
            document.getElementById('editStatusAktif').checked = outlet.is_active;

            // Set preview foto
            const preview = document.getElementById('editCurrentFoto');
            const icon = document.getElementById('editDefaultIcon');
            if (outlet.qris_url) {
                preview.src = outlet.qris_url;
                preview.classList.remove('hidden');
                icon.classList.add('hidden');
            } else {
                preview.classList.add('hidden');
                icon.classList.remove('hidden');
            }

            openModalEdit();
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

        // Fungsi untuk validasi form tambah
        function validateForm() {
            let isValid = true;
            
            const namaOutlet = document.getElementById('namaOutlet');
            const errorNama = document.getElementById('errorNama');
            if (!namaOutlet.value.trim()) {
                errorNama.classList.remove('hidden');
                namaOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorNama.classList.add('hidden');
                namaOutlet.classList.remove('border-red-500');
            }
            
            const teleponOutlet = document.getElementById('teleponOutlet');
            const errorTelepon = document.getElementById('errorTelepon');
            if (!teleponOutlet.value.trim()) {
                errorTelepon.classList.remove('hidden');
                teleponOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorTelepon.classList.add('hidden');
                teleponOutlet.classList.remove('border-red-500');
            }
            
            const alamatOutlet = document.getElementById('alamatOutlet');
            const errorAlamat = document.getElementById('errorAlamat');
            if (!alamatOutlet.value.trim()) {
                errorAlamat.classList.remove('hidden');
                alamatOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorAlamat.classList.add('hidden');
                alamatOutlet.classList.remove('border-red-500');
            }
            
            const emailOutlet = document.getElementById('emailOutlet');
            const errorEmail = document.getElementById('errorEmail');
            if (emailOutlet.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailOutlet.value)) {
                errorEmail.classList.remove('hidden');
                emailOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorEmail.classList.add('hidden');
                emailOutlet.classList.remove('border-red-500');
            }
            
            return isValid;
        }

        // Fungsi untuk validasi form edit
        function validateEditForm() {
            let isValid = true;
            
            const namaOutlet = document.getElementById('editNamaOutlet');
            const errorNama = document.getElementById('errorEditNama');
            if (!namaOutlet.value.trim()) {
                errorNama.classList.remove('hidden');
                namaOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorNama.classList.add('hidden');
                namaOutlet.classList.remove('border-red-500');
            }
            
            const teleponOutlet = document.getElementById('editNomorTelepon');
            const errorTelepon = document.getElementById('errorEditTelepon');
            if (!teleponOutlet.value.trim()) {
                errorTelepon.classList.remove('hidden');
                teleponOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorTelepon.classList.add('hidden');
                teleponOutlet.classList.remove('border-red-500');
            }
            
            const alamatOutlet = document.getElementById('editAlamatLengkap');
            const errorAlamat = document.getElementById('errorEditAlamat');
            if (!alamatOutlet.value.trim()) {
                errorAlamat.classList.remove('hidden');
                alamatOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorAlamat.classList.add('hidden');
                alamatOutlet.classList.remove('border-red-500');
            }
            
            const emailOutlet = document.getElementById('editEmail');
            const errorEmail = document.getElementById('errorEditEmail');
            if (emailOutlet.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailOutlet.value)) {
                errorEmail.classList.remove('hidden');
                emailOutlet.classList.add('border-red-500');
                isValid = false;
            } else {
                errorEmail.classList.add('hidden');
                emailOutlet.classList.remove('border-red-500');
            }
            
            return isValid;
        }

        // Fungsi untuk reset form tambah
        function resetForm() {
            document.getElementById('namaOutlet').value = '';
            document.getElementById('teleponOutlet').value = '';
            document.getElementById('alamatOutlet').value = '';
            document.getElementById('emailOutlet').value = '';
            document.getElementById('pajakOutlet').value = '';
            document.getElementById('nomorTransaksi').value = '';
            document.getElementById('namaBank').value = '';
            document.getElementById('atasNama').value = '';
            document.getElementById('fotoOutlet').value = '';
            document.getElementById('statusAktif').checked = true;
            
            document.getElementById('currentFotoOutlet').src = '#';
            document.getElementById('currentFotoOutlet').classList.add('hidden');
            document.getElementById('defaultIcon').classList.remove('hidden');
            
            document.querySelectorAll('[id^="error"]').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        }

        // Fungsi untuk pencarian
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const filteredOutlets = allOutlets.filter(outlet => 
                outlet.name.toLowerCase().includes(searchTerm) || 
                outlet.address.toLowerCase().includes(searchTerm) ||
                outlet.phone.toLowerCase().includes(searchTerm) ||
                outlet.email.toLowerCase().includes(searchTerm));
            
            renderOutlets(filteredOutlets);
        });

        // Tutup semua dropdown jika klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative.inline-block')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                    menu.classList.remove('dropdown-up');
                    menu.classList.remove('dropdown-down');
                });
            }
        });

        // Modal functions
        function openModalTambah() {
            document.getElementById('modalTambahOutlet').classList.remove('hidden');
            document.getElementById('modalTambahOutlet').classList.add('flex');
        }

        function closeModalTambah() {
            document.getElementById('modalTambahOutlet').classList.add('hidden');
            document.getElementById('modalTambahOutlet').classList.remove('flex');
        }

        function openModalEdit() {
            document.getElementById('modalEditOutlet').classList.remove('hidden');
            document.getElementById('modalEditOutlet').classList.add('flex');
        }

        function closeModalEdit() {
            document.getElementById('modalEditOutlet').classList.add('hidden');
            document.getElementById('modalEditOutlet').classList.remove('flex');
        }

        // Fungsi untuk preview foto outlet
        function previewFotoOutlet(input) {
            const preview = document.getElementById('currentFotoOutlet');
            const icon = document.getElementById('defaultIcon');
            const errorFoto = document.getElementById('errorFoto');
            
            errorFoto.classList.add('hidden');
            
            if (input.files && input.files[0]) {
                if (input.files[0].size > 2 * 1024 * 1024) {
                    errorFoto.classList.remove('hidden');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Fungsi untuk preview foto outlet di modal edit
        function previewEditFoto(input) {
            const preview = document.getElementById('editCurrentFoto');
            const icon = document.getElementById('editDefaultIcon');
            const errorFoto = document.getElementById('errorEditFoto');
            
            errorFoto.classList.add('hidden');
            
            if (input.files && input.files[0]) {
                if (input.files[0].size > 2 * 1024 * 1024) {
                    errorFoto.classList.remove('hidden');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Event listener untuk modal konfirmasi hapus
        document.getElementById('btnBatalHapus').addEventListener('click', closeConfirmDelete);
        document.getElementById('btnKonfirmasiHapus').addEventListener('click', hapusOutlet);

        // Event listener untuk form tambah outlet
        document.getElementById('btnTambahOutlet').addEventListener('click', function(e) {
            e.preventDefault();
            tambahOutlet();
        });

        // Event listener untuk form edit outlet
        document.getElementById('btnSimpanPerubahan').addEventListener('click', function(e) {
            e.preventDefault();
            updateOutlet();
        });

        // Event listener untuk input enter di form
        document.querySelectorAll('#modalTambahOutlet input, #modalEditOutlet input').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (this.closest('#modalTambahOutlet')) {
                        tambahOutlet();
                    } else if (this.closest('#modalEditOutlet')) {
                        updateOutlet();
                    }
                }
            });
        });

        // Memuat data saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            loadOutlets();
            
            // Inisialisasi event listener untuk modal
            document.getElementById('btnBatalModalTambah').addEventListener('click', closeModalTambah);
            document.getElementById('btnBatalModalEdit').addEventListener('click', closeModalEdit);
        });
</script>

<style>
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