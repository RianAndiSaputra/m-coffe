@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')

<!-- Notification container -->
<div id="notification-container"></div>

<!-- Page Title + Action -->
<div class="mb-4">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Produk</h1>
        <button onclick="openModal('modalTambahProduk')" class="px-4 py-2 text-sm text-white bg-orange-600 rounded hover:bg-orange-700">
            + Tambah Produk
        </button>
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
        <table class="w-full text-sm">
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
                        <img src="https://via.placeholder.com/40" alt="gambar" class="w-10 h-10 bg-gray-100 rounded object-cover" />
                        <div>
                            <p class="font-medium">Bolu Pisang</p>
                            <p class="text-xs text-gray-500">Kue bolu dengan rasa pisang</p>
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
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-600 rounded">Active</span>
                    </td>
                    <td class="relative">
                        <div class="relative">
                            <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded">
                                <i data-lucide="more-vertical" class="w-4 h-4 text-gray-500"></i>
                            </button>

                            <!-- Dropdown -->
                            <div class="dropdown-menu hidden absolute right-0 z-50 mt-2 w-32 bg-white border border-gray-200 rounded shadow text-sm">
                                <button onclick="openEditModal(1)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left">
                                    <i data-lucide="pencil" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                                </button>
                                <button onclick="hapusProduk(1)" class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left text-red-600">
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

@include('partials.produk.modal-tambah-produk')
@include('partials.produk.modal-edit-produk')

<style>
    /* Notification styles */
    .notification {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        transform: translateX(150%);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 1000;
        max-width: 350px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .notification.show {
        transform: translateX(0);
    }
    
    .notification.success {
        background-color: rgba(255, 107, 0, 0.9); /* Orange with transparency */
        color: white;
    }
    
    .notification.error {
        background-color: rgba(239, 68, 68, 0.9); /* Red with transparency */
        color: white;
    }
    
    .notification.info {
        background-color: rgba(255, 107, 0, 0.9); /* Blue with transparency */
        color: white;
    }
    
    .notification-icon {
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
    
    .notification-message {
        flex: 1;
    }
    
    .notification-close {
        margin-left: 1rem;
        cursor: pointer;
        flex-shrink: 0;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .notification-close:hover {
        opacity: 1;
    }
    
    /* Confirmation Dialog Animation */
    #confirmationDialog .bg-white {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.2s ease-in-out;
    }
</style>

<script>
    // Notification system
    function showNotification(type, message) {
        const container = document.getElementById('notification-container');
        const notification = document.createElement('div');
        
        // Choose icon based on notification type
        let iconName = 'alert-circle';
        if (type === 'success') iconName = 'check-circle';
        else if (type === 'info') iconName = 'info';
        
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <i data-lucide="${iconName}" class="w-5 h-5"></i>
            </div>
            <div class="notification-message flex-1 text-sm font-medium">${message}</div>
            <div class="notification-close">
                <i data-lucide="x" class="w-4 h-4"></i>
            </div>
        `;
        
        container.appendChild(notification);
        lucide.createIcons();
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Auto-remove after 5 seconds
        const autoRemove = setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                container.removeChild(notification);
            }, 300);
        }, 5000);
        
        // Manual close
        notification.querySelector('.notification-close').addEventListener('click', () => {
            clearTimeout(autoRemove);
            notification.classList.remove('show');
            setTimeout(() => {
                container.removeChild(notification);
            }, 300);
        });
    }

    // Show specific notification types
    function showError(message) {
        showNotification('error', message);
    }

    function showSuccess(message) {
        showNotification('success', message);
    }

    function showInfo(message) {
        showNotification('info', message);
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
        const btnBatalTambah = document.getElementById('btnBatalModal');
        if (btnBatalTambah) {
            btnBatalTambah.addEventListener('click', function() {
                closeModal('modalTambahProduk');
            });
        }

        // Tombol batal modal edit
        const btnBatalEdit = document.getElementById('btnBatalEdit');
        if (btnBatalEdit) {
            btnBatalEdit.addEventListener('click', function() {
                closeModal('modalEditProduk');
            });
        }
        
        // Handle form submission for adding product
        const formTambahProduk = document.getElementById('formTambahProduk');
        if (formTambahProduk) {
            formTambahProduk.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(formTambahProduk);
                const namaProduk = formData.get('namaProduk');
                
                // Close modal
                closeModal('modalTambahProduk');
                
                // Show success notification
                showSuccess(`Produk ${namaProduk} berhasil ditambahkan!`);
                
                // Reset form
                formTambahProduk.reset();
                
                // In a real app, you would send the data to your backend
                // and refresh the table or add the new product to the table
            });
        }
        
        // Handle form submission for editing product
        const formEditProduk = document.getElementById('formEditProduk');
        if (formEditProduk) {
            formEditProduk.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(formEditProduk);
                const namaProduk = formData.get('namaProduk');
                
                // Close modal
                closeModal('modalEditProduk');
                
                // Show success notification
                showSuccess(`Produk ${namaProduk} berhasil diperbarui!`);
                
                // In a real app, you would send the data to your backend
                // and refresh the table or update the product in the table
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

    // Edit Product Function
    function openEditModal(productId) {
        // In a real app, you would fetch the product data from your backend
        const productData = getProductData(productId); // Mock function
        
        // Fill the edit form
        document.getElementById('editProdukId').textContent = productData.id;
        document.getElementById('editNamaProduk').value = productData.nama;
        document.getElementById('editSkuProduk').value = productData.sku;
        document.getElementById('editDeskripsi').value = productData.deskripsi;
        document.getElementById('editHarga').value = productData.harga;
        document.getElementById('editStok').value = productData.stok;
        document.getElementById('editStokMinimum').value = productData.stok_minimum;
        document.getElementById('editStatus').value = productData.status;
        
        // Set category
        const categorySelect = document.getElementById('editKategori');
        Array.from(categorySelect.options).forEach(option => {
            if (option.value === productData.kategori) {
                option.selected = true;
            }
        });
        
        // Set outlets
        const outletCheckboxes = document.querySelectorAll('#editOutletList input[type="checkbox"]');
        outletCheckboxes.forEach(checkbox => {
            checkbox.checked = productData.outlets.includes(checkbox.value);
        });
        
        // Set image preview if exists
        if (productData.gambar) {
            const imgPreview = document.getElementById('editGambarPreview');
            imgPreview.src = productData.gambar;
            imgPreview.classList.remove('hidden');
        }
        
        openModal('modalEditProduk');
        
        // Show info notification
        showInfo(`Mengubah produk: ${productData.nama}`);
    }

    // Mock function to get product data - replace with actual API call
    function getProductData(productId) {
        const products = {
            1: {
                id: 1,
                nama: "Bolu Pisang",
                sku: "1001",
                deskripsi: "Kue bolu dengan rasa pisang",
                harga: "17500",
                kategori: "cake",
                stok: 20,
                stok_minimum: 5,
                status: "active",
                outlets: ["pusat"],
                gambar: "https://via.placeholder.com/200"
            },
        };
        return products[productId];
    }

    // Delete Product Function
    function hapusProduk(id) {
        const productData = getProductData(id);
        
        // Create confirmation dialog
        showConfirmationDialog(
            'Konfirmasi Hapus Produk',
            `Yakin ingin menghapus produk "${productData.nama}"?`,
            () => {
                console.log('Hapus produk ID:', id);
                // In a real app, you would send a delete request to your backend
                // Example: axios.delete(`/products/${id}`).then(response => { ... });
                
                // Show success notification
                showSuccess(`Produk ${productData.nama} berhasil dihapus!`);
                
                // You would then remove the product from the table
                // Example: document.querySelector(`tr[data-product-id="${id}"]`).remove();
            }
        );
    }
    
    // Custom Confirmation Dialog
    function showConfirmationDialog(title, message, onConfirm) {
        // Create modal container
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50';
        modal.id = 'confirmationDialog';
        
        // Create dialog content
        modal.innerHTML = `
            <div class="bg-white rounded-lg shadow-lg p-6 m-4 max-w-sm w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">${title}</h3>
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none" id="closeConfirmDialog">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <div class="mb-6">
                    <div class="flex items-center justify-center mb-4 text-red-500">
                        <i data-lucide="alert-triangle" class="w-12 h-12"></i>
                    </div>
                    <p class="text-center text-gray-600">${message}</p>
                </div>
                <div class="flex items-center justify-between">
                    <button id="cancelButton" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button id="confirmButton" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 transition-colors">
                        Hapus
                    </button>
                </div>
            </div>
        `;
        
        // Add to DOM
        document.body.appendChild(modal);
        lucide.createIcons();
        
        // Animation
        setTimeout(() => {
            modal.querySelector('.bg-white').style.transform = 'scale(1)';
            modal.querySelector('.bg-white').style.opacity = '1';
        }, 10);
        
        // Handle actions
        modal.querySelector('#closeConfirmDialog').addEventListener('click', () => {
            closeConfirmationDialog();
        });
        
        modal.querySelector('#cancelButton').addEventListener('click', () => {
            closeConfirmationDialog();
        });
        
        modal.querySelector('#confirmButton').addEventListener('click', () => {
            closeConfirmationDialog();
            if (typeof onConfirm === 'function') {
                onConfirm();
            }
        });
        
        // Close when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeConfirmationDialog();
            }
        });
        
        // Additional keyboard handling
        document.addEventListener('keydown', handleEscapeKey);
        
        function handleEscapeKey(e) {
            if (e.key === 'Escape') {
                closeConfirmationDialog();
            }
        }
        
        function closeConfirmationDialog() {
            document.removeEventListener('keydown', handleEscapeKey);
            modal.remove();
        }
    }

    // Initialize Lucide Icons
    document.addEventListener('DOMContentLoaded', function() {
        // This would be replaced with actual Lucide initialization in your app
        lucide.createIcons();
    });
</script>

@endsection