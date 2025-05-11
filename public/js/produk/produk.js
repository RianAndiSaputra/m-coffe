    let produkHapusId = null;
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
            },
            info: {
                bgColor: 'bg-blue-50',
                borderColor: 'border-blue-200',
                textColor: 'text-blue-800',
                icon: 'info',
                iconColor: 'text-blue-500'
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

        // Get the dropdown menu
        const menu = button.nextElementSibling;
        const isOpen = !menu.classList.contains('hidden');
        
        // Toggle current dropdown
        if (!isOpen) {
            // Calculate position
            const buttonRect = button.getBoundingClientRect();
            const spaceBelow = window.innerHeight - buttonRect.bottom;
            const menuHeight = 128; // Approximate menu height
            
            // Remove previous positioning classes
            menu.classList.remove('dropdown-up', 'dropdown-down');
            
            if (spaceBelow < menuHeight) {
                menu.classList.add('dropdown-up');
            } else {
                menu.classList.add('dropdown-down');
            }
        }
        
        menu.classList.toggle('hidden');
    }

        document.addEventListener('click', function(e) {
        const isDropdownButton = e.target.closest('[onclick^="toggleDropdown"]');
        const isDropdownMenu = e.target.closest('.dropdown-menu');
        
        if (!isDropdownButton && !isDropdownMenu) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Handle escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
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

    // Delete Product Function (Updated)
    function hapusProduk(id) {
        // Dapatkan data produk
        const produkData = getProductData(id);
        
        // Set ID produk yang akan dihapus
        produkHapusId = id;
        
        // Update nama produk di modal konfirmasi
        document.getElementById('hapusNamaProduk').textContent = produkData.nama;
        
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
                produkHapusId = null; // Reset ID produk
            });
        }
        
        // Tombol konfirmasi hapus
        const btnKonfirmasiHapus = document.getElementById('btnKonfirmasiHapus');
        if (btnKonfirmasiHapus) {
            btnKonfirmasiHapus.addEventListener('click', function() {
                // Di sini Anda akan melakukan penghapusan produk
                // Misalnya dengan AJAX call ke backend
                const produkData = getProductData(produkHapusId);
                console.log('Menghapus produk ID:', produkHapusId);
                
                // Simulasi sukses (ganti dengan kode nyata)
                setTimeout(() => {
                    closeModal('modalKonfirmasiHapus');
                    showAlert('success', `Produk ${produkData.nama} berhasil dihapus!`);
                    
                    // Di aplikasi nyata, Anda mungkin perlu me-refresh data
                    // atau menghapus baris dari tabel
                    
                    // Reset ID produk
                    produkHapusId = null;
                }, 500);
            });
        }
    });

    
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