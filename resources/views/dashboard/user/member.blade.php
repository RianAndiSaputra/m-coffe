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
            <button onclick="openModalTambah()"
                class="px-5 py-3 text-base font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 shadow">
                + Tambah Member
            </button>
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
            <tbody id="memberTableBody" class="text-gray-700 divide-y">
                <!-- Data akan diisi secara dinamis -->
            </tbody>
        </table>
        
        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="flex justify-center items-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
        </div>
    </div>
</div>

@include('partials.member.tambah-member')
@include('partials.member.edit-member')

<script>
    // Variabel global
    let memberIdToDelete = null;
    let currentPage = 1;
    let totalPages = 1;
    let allMembers = [];
    let filteredMembers = [];
    const itemsPerPage = 10;

    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            window.lucide.createIcons();
        }

        loadMembers();

        document.getElementById('btnBatalHapus').addEventListener('click', closeConfirmDelete);
        document.getElementById('btnKonfirmasiHapus').addEventListener('click', hapusMember);

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderMembers();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderMembers();
            }
        });
    });

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
            <div class="flex-1"><p class="text-sm font-medium">${message}</p></div>
            <button onclick="closeAlert('${alertId}')" class="p-1 rounded-full hover:bg-gray-100">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;

        alertContainer.prepend(alertElement);
        if (window.lucide) window.lucide.createIcons();
        setTimeout(() => closeAlert(alertId), 5000);
    }

    function closeAlert(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.classList.add('animate-fade-out');
            setTimeout(() => alert.remove(), 300);
        }
    }

    async function loadMembers() {
        try {
            const token = localStorage.getItem('token');
            document.getElementById('loadingIndicator').classList.remove('hidden');
            document.getElementById('memberTableBody').innerHTML = '';

            const response = await fetch('http://127.0.0.1:8000/api/members', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                allMembers = data.data;
                filteredMembers = [...allMembers];
                totalPages = Math.ceil(filteredMembers.length / itemsPerPage);
                renderMembers();
            } else {
                throw new Error(data.message || 'Gagal memuat data member');
            }
        } catch (error) {
            showAlert('error', error.message);
        } finally {
            document.getElementById('loadingIndicator').classList.add('hidden');
        }
    }

    function renderMembers() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedMembers = filteredMembers.slice(startIndex, endIndex);
        const tableBody = document.getElementById('memberTableBody');
        tableBody.innerHTML = '';

        if (paginatedMembers.length === 0) {
            tableBody.innerHTML = `
                <tr id="noResultsMessage">
                    <td colspan="8" class="py-8 text-center">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="w-8 h-8 text-gray-400"></i>
                            <p class="text-gray-500 font-medium">Tidak ada member yang ditemukan</p>
                        </div>
                    </td>
                </tr>
            `;
            if (window.lucide) window.lucide.createIcons();
            return;
        }

        paginatedMembers.forEach((member, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-4">${startIndex + index + 1}</td>
                <td class="py-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-orange-100 p-2 rounded-full">
                            <i data-lucide="user" class="w-6 h-6 text-orange-500"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-base text-gray-900">${member.name}</div>
                            <div class="text-sm text-gray-500">${member.phone || '-'}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4">${member.member_code}</td>
                <td class="py-4">${member.email || '-'}</td>
                <td class="py-4">${member.address || '-'}</td>
                <td class="py-4">${member.gender === 'male' ? 'Laki-laki' : member.gender === 'female' ? 'Perempuan' : '-'}</td>
                <td class="py-4">${member.orders_count || 0}</td>
                <td class="py-4 relative">
                    <div class="relative inline-block">
                        <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                            <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-base">
                            <div class="px-4 py-2 font-bold text-left border-b">Aksi</div>
                            <button onclick="historyMember(${member.id})" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                <i data-lucide="history" class="w-5 h-5 mr-3 text-gray-500"></i> History
                            </button>
                            <button onclick="editMember(${member.id})" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left">
                                <i data-lucide="pencil" class="w-5 h-5 mr-3 text-gray-500"></i> Edit
                            </button>
                            <button onclick="showConfirmDelete(${member.id})" class="flex items-center w-full px-4 py-2.5 hover:bg-gray-100 text-left text-red-600">
                                <i data-lucide="trash-2" class="w-5 h-5 mr-3"></i> Hapus
                            </button>
                        </div>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        updatePaginationControls();
        if (window.lucide) window.lucide.createIcons();
    }

    function updatePaginationControls() {
        const pageInfo = document.getElementById('pageInfo');
        const prevButton = document.getElementById('prevPage');
        const nextButton = document.getElementById('nextPage');

        pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages}`;
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages || totalPages === 0;
    }

    function showConfirmDelete(id) {
        memberIdToDelete = id;
        const modal = document.getElementById('modalHapusMember');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeConfirmDelete() {
        const modal = document.getElementById('modalHapusMember');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        memberIdToDelete = null;
    }

    async function hapusMember() {
        if (!memberIdToDelete) return;
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`http://127.0.0.1:8000/api/members/${memberIdToDelete}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            const data = await response.json();

            if (response.ok) {
                showAlert('success', 'Member berhasil dihapus!');
                loadMembers();
            } else {
                throw new Error(data.message || 'Gagal menghapus member');
            }
        } catch (error) {
            showAlert('error', error.message);
        } finally {
            closeConfirmDelete();
        }
    }

    // Fungsi untuk menampilkan history member
    function historyMember(id) {
        console.log('Melihat history member ID:', id);
        showAlert('success', `Melihat history member ID: ${id}`);
        // Implementasi lebih lanjut untuk menampilkan history transaksi
    }

    // Fungsi untuk edit member
    function editMember(id) {
        const member = allMembers.find(m => m.id === id);
        if (!member) return;
        
        // Isi form edit dengan data member
        document.getElementById('editNamaMember').value = member.name;
        document.getElementById('editTeleponMember').value = member.phone || '';
        document.getElementById('editEmailMember').value = member.email || '';
        document.getElementById('editAlamatMember').value = member.address || '';
        document.getElementById('editJenisKelamin').value = member.gender || '';
        document.getElementById('memberIdToEdit').value = member.id;
        
        // Buka modal edit
        openModalEdit();
    }

    // Fungsi untuk submit form edit member
    async function submitEditMember(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const memberId = formData.get('memberIdToEdit');
        
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/members/${memberId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: formData.get('editNamaMember'),
                    phone: formData.get('editTeleponMember'),
                    email: formData.get('editEmailMember'),
                    address: formData.get('editAlamatMember'),
                    gender: formData.get('editJenisKelamin'),
                    member_code: formData.get('editKodeMember')
                })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                showAlert('success', 'Data member berhasil diperbarui!');
                loadMembers(); // Refresh data
                closeModalEdit();
            } else {
                throw new Error(data.message || 'Gagal memperbarui member');
            }
        } catch (error) {
            showAlert('error', error.message);
        }
    }

    // Fungsi untuk submit form tambah member
    async function submitForm() {
    if (!validateForm()) return;

    const btnTambah = document.getElementById('btnTambahMember');
    const originalText = btnTambah.innerHTML;
    btnTambah.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...`;
    btnTambah.disabled = true;

    const token = localStorage.getItem('token');

    try {
        const response = await fetch('http://127.0.0.1:8000/api/members', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                name: document.getElementById('namaMember').value,
                phone: document.getElementById('teleponMember').value,
                email: document.getElementById('emailMember').value,
                address: document.getElementById('alamatMember').value,
                gender: document.getElementById('jenisKelamin').value
            })
        });

        const result = await response.json();

        if (response.ok) {
            showAlert('success', 'Member baru berhasil ditambahkan!');
            resetForm();
            closeModalTambah();
            loadMembers(); // refresh data di halaman utama
        } else {
            throw new Error(result.message || 'Gagal menambahkan member');
        }

    } catch (error) {
        showAlert('error', error.message);
    } finally {
        btnTambah.innerHTML = originalText;
        btnTambah.disabled = false;
    }
    }

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
        const menuHeight = menu.clientHeight || 300;

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
            menu.classList.add('dropdown-animation-up');
            menu.classList.remove('dropdown-animation-down');
        } else {
            // Tampilkan dropdown di bawah tombol
            menu.style.top = '100%';
            menu.style.marginTop = '5px';
            menu.classList.add('dropdown-animation-down');
            menu.classList.remove('dropdown-animation-up');
        }

        // Periksa juga posisi horizontal untuk memastikan dropdown tetap di dalam viewport
        const menuRect = menu.getBoundingClientRect();
        if (menuRect.right > window.innerWidth) {
            menu.style.right = '0';
            menu.style.left = 'auto';
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

    // Event listener untuk form
   document.getElementById('formTambahMember')?.addEventListener('submit', function (e) {
    e.preventDefault();
    submitForm();
    });
    document.getElementById('formEditMember')?.addEventListener('submit', submitEditMember);
    document.getElementById('btnTambahMember')?.addEventListener('click', function () {
        submitForm();
    });

    // Fungsi untuk melakukan pencarian member
    function searchMembers() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        
        if (searchInput.trim() === '') {
            filteredMembers = [...allMembers];
        } else {
            filteredMembers = allMembers.filter(member => {
                return (
                    member.name.toLowerCase().includes(searchInput) ||
                    (member.phone && member.phone.toLowerCase().includes(searchInput)) ||
                    (member.member_code && member.member_code.toLowerCase().includes(searchInput)) ||
                    (member.email && member.email.toLowerCase().includes(searchInput)) ||
                    (member.address && member.address.toLowerCase().includes(searchInput))
                );
            });
        }
        
        currentPage = 1;
        totalPages = Math.ceil(filteredMembers.length / itemsPerPage);
        renderMembers();
    }

    // Event listener untuk input pencarian dengan debounce
    let debounceTimer;
    document.getElementById('searchInput')?.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            searchMembers();
        }, 300);
    });

    // Event listener untuk enter key pada input pencarian
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(debounceTimer);
            searchMembers();
        }
    });

    // Lazy loading untuk tabel
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Jika tabel masuk viewport, load data
                loadMembers();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    observer.observe(document.getElementById('memberTable'));
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
        z-index: 9999;
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
    
    /* Loading spinner */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>

@endsection