@extends('layouts.app')

@section('title', 'Penyesuaian Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Modal Penyesuaian Stok -->
@include('partials.stok.modal-penyesuaian-stok')

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-2xl font-extrabold text-gray-800">MANAJEMEN STOK</h1>
        <div class="relative w-full md:w-64">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
        </span>
        <input type="text" id="searchInput" placeholder="Pencarian..."
            class="w-full pl-10 pr-4 py-3 border rounded-lg text-base font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
    </div>
    </div>
</div>

<!-- Card: Stok Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="package-plus" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h2 class="text-lg font-bold text-gray-800" id="outletName">Menampilkan stok untuk : loading...</h2>
            <p class="text-sm font-medium text-gray-600">Lakukan penyesuaian stok produk di outlet Kifa Bakery.</p>
        </div>
    </div>
    <!-- Outlet Display + Date Selection -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
        <!-- Outlet Display -->
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-700">Outlet:</span>
            <span class="font-bold text-orange-600">Kifa Bakery Pusat</span>
        </div>
        <!-- Date Selection -->
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-gray-700">Tanggal:</span>
            <input type="date" id="dateSelector" class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
        </div>
    </div>
</div>

<!-- Card: Tabel Stok -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Sku</th>
                    <th class="py-3 font-bold">Produk</th>
                    {{-- <th class="py-3 font-bold">Jumlah Sebelum</th> --}}
                    <th class="py-3 font-bold">Status</th>
                    {{-- <th class="py-3 font-bold">Perubahan</th> --}}
                    <th class="py-3 font-bold">Tipe</th>
                    <th class="py-3 font-bold">Tanggal</th>
                    <th class="py-3 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="inventoryTableBody" class="text-gray-700 divide-y">
                <!-- Data will be loaded here dynamically -->
                <tr>
                    <td colspan="8" class="py-4 text-center text-gray-500">
                        <div class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memuat data stok...</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="loading" class="py-4 text-center hidden">
        <div class="inline-flex items-center gap-2">
            <svg class="animate-spin h-5 w-5 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memuat data...</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default date in the date picker to today
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        document.getElementById('dateSelector').value = `${year}-${month}-${day}`;
        
        // Load inventory data for outlet ID 1 by default
        fetchInventoryHistory(1);
        
        // Add event listener to date selector
        document.getElementById('dateSelector').addEventListener('change', function() {
            fetchInventoryHistory(1);
        });
        
        // Add event listener to search input
        document.getElementById('searchInput').addEventListener('input', function() {
            filterInventoryTable(this.value);
        });
    });
    
    //Function to fetch inventory history for a specific outlet
    function fetchInventoryHistory(outletId) {
        showLoading(true);
        clearInventoryTable();
        
        // Get selected date from the date picker
        const selectedDate = document.getElementById('dateSelector').value;
        
        // Tampilkan nama outlet di UI
        document.getElementById('outletName').textContent = `Menampilkan stok untuk : Outlet ${outletId}`;
        
        fetch(`/api/products/outlet/${outletId}?date=${selectedDate}`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.data) {
                    // Format data untuk tabel
                    const formattedData = formatInventoryData(data.data, outletId);
                    populateInventoryTable(formattedData);
                    
                    // Update outlet name if available
                    if (data.data.length > 0 && data.data[0].outlets && data.data[0].outlets.length > 0) {
                        const outletName = data.data[0].outlets.find(o => o.id === outletId)?.name || `Outlet ${outletId}`;
                        document.getElementById('outletName').textContent = `Menampilkan stok untuk : ${outletName}`;
                    }
                } else {
                    showNoDataMessage();
                }
            })
            .catch(error => {
                console.error('Error fetching inventory history:', error);
                showAlert('error', 'Gagal memuat data stok. Silakan coba lagi.');
                showNoDataMessage();
            })
            .finally(() => {
                showLoading(false);
            });
    }

    // Format data dari API ke format yang dibutuhkan untuk tabel
    function formatInventoryData(products, outletId) {
        let inventoryRecords = [];
        
        products.forEach(product => {
            // Temukan outlet yang relevan
            const outlet = product.outlets.find(o => o.id === outletId) || product.outlets[0];
            
            // Jika ada riwayat inventaris
            if (product.inventory_history && product.inventory_history.length > 0) {
                product.inventory_history.forEach(history => {
                    inventoryRecords.push({
                        product: {
                            id: product.id,
                            name: product.name,
                            sku: product.sku
                        },
                        outlet: {
                            id: outlet.id,
                            name: outlet.name
                        },
                        quantity_before: history.quantity_before,
                        quantity_after: history.quantity_after,
                        quantity_change: history.quantity_change,
                        type: history.type,
                        created_at: new Date().toISOString() // Karena API tidak memberikan tanggal, kita gunakan tanggal saat ini
                    });
                });
            } else {
                // Jika tidak ada riwayat, tambahkan stok terkini
                inventoryRecords.push({
                    product: {
                        id: product.id,
                        name: product.name,
                        sku: product.sku
                    },
                    outlet: {
                        id: outlet.id,
                        name: outlet.name
                    },
                    quantity_before: 0,
                    quantity_after: product.quantity,
                    quantity_change: product.quantity,
                    type: "current",
                    created_at: new Date().toISOString()
                });
            }
        });
        
        return inventoryRecords;
    }

    // Function to populate inventory table with data
    function populateInventoryTable(inventoryData) {
        const tableBody = document.getElementById('inventoryTableBody');
        tableBody.innerHTML = '';
        
        if (inventoryData.length === 0) {
            showNoDataMessage();
            return;
        }
        
        inventoryData.forEach(item => {
            const row = document.createElement('tr');
            row.dataset.productName = item.product.name.toLowerCase(); // For search functionality
            row.dataset.sku = item.product.sku.toLowerCase(); // For search functionality
            
            // Create cell for SKU
            const skuCell = document.createElement('td');
            skuCell.className = 'py-4 font-bold';
            skuCell.textContent = item.product.sku;
            row.appendChild(skuCell);
            
            // Create cell for Product Name
            const productCell = document.createElement('td');
            productCell.className = 'py-4';
            const productContent = document.createElement('div');
            productContent.className = 'flex items-center gap-3';
            productContent.innerHTML = `
                <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                    <i data-lucide="package" class="w-5 h-5 text-orange-500"></i>
                </div>
                <span class="font-semibold">${item.product.name}</span>
            `;
            productCell.appendChild(productContent);
            row.appendChild(productCell);
            
            // Create cell for Quantity After (Status)
            const qtyAfterCell = document.createElement('td');
            qtyAfterCell.className = 'py-4';
            qtyAfterCell.innerHTML = `
                <span class="px-3 py-1.5 text-sm font-bold bg-orange-100 text-orange-700 rounded-full">
                    ${item.quantity_after}
                </span>
            `;
            row.appendChild(qtyAfterCell);
            
            // Create cell for Type
            const typeCell = document.createElement('td');
            typeCell.className = 'py-4 font-medium';
            
            // Map the type to more readable Indonesian text
            const typeMapping = {
                'shipment': 'Pengiriman',
                'adjustment': 'Penyesuaian',
                'sale': 'Penjualan',
                'purchase': 'Pembelian',
                'transfer_in': 'Transfer Masuk',
                'transfer_out': 'Transfer Keluar',
                'other': 'Lainnya',
                'current': 'Stok Terkini'
            };
            
            typeCell.textContent = typeMapping[item.type] || item.type;
            row.appendChild(typeCell);
            
            // Create cell for Date
            const dateCell = document.createElement('td');
            dateCell.className = 'py-4 font-medium';
            
            // Format the date safely
            let formattedDate;
            try {
                // Jika tanggal valid
                const date = new Date(item.created_at);
                if (!isNaN(date.getTime())) {
                    formattedDate = new Intl.DateTimeFormat('id-ID', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }).format(date);
                } else {
                    formattedDate = 'Tanggal tidak valid';
                }
            } catch (e) {
                console.warn('Error formatting date:', e);
                formattedDate = 'Tanggal tidak tersedia';
            }
            
            dateCell.textContent = formattedDate;
            row.appendChild(dateCell);
            
            // Create cell for Actions
            const actionCell = document.createElement('td');
            actionCell.className = 'py-4 text-right';
            actionCell.innerHTML = `
                <button onclick="openModalAdjust('${item.product.sku}', '${item.product.name}', '${item.outlet.name}', ${item.quantity_after})" 
                    class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-bold text-white bg-orange-500 rounded-md hover:bg-orange-600">
                    <i data-lucide="clipboard-list" class="w-4 h-4"></i> Sesuaikan
                </button>
            `;
            row.appendChild(actionCell);
            
            tableBody.appendChild(row);
        });
        
        // Re-initialize Lucide icons
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
    
    // Function to clear inventory table
    function clearInventoryTable() {
        const tableBody = document.getElementById('inventoryTableBody');
        tableBody.innerHTML = '';
    }
    
    // Function to show a message when no data is available
    function showNoDataMessage() {
        const tableBody = document.getElementById('inventoryTableBody');
        tableBody.innerHTML = `
            <tr>
                <td colspan="8" class="py-4 text-center text-gray-500">
                    Tidak ada data stok untuk outlet ini
                </td>
            </tr>
        `;
    }
    
    // Function to toggle loading indicator
    function showLoading(isLoading) {
        const loading = document.getElementById('loading');
        if (isLoading) {
            loading.classList.remove('hidden');
        } else {
            loading.classList.add('hidden');
        }
    }
    
    // Function to filter inventory table based on search term
    function filterInventoryTable(searchTerm) {
        searchTerm = searchTerm.toLowerCase().trim();
        const rows = document.querySelectorAll('#inventoryTableBody tr');
        
        rows.forEach(row => {
            // Skip rows that don't have dataset properties (like "no data" rows)
            if (!row.dataset.productName && !row.dataset.sku) {
                return;
            }
            
            const productName = row.dataset.productName;
            const sku = row.dataset.sku;
            
            if (productName.includes(searchTerm) || sku.includes(searchTerm)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Check if there are any visible rows after filtering
        const visibleRows = document.querySelectorAll('#inventoryTableBody tr:not(.hidden)');
        if (visibleRows.length === 0 && searchTerm.length > 0) {
            const tableBody = document.getElementById('inventoryTableBody');
            
            // Append a "no results" row if it doesn't exist yet
            if (!document.getElementById('noResultsRow')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = `
                    <td colspan="8" class="py-4 text-center text-gray-500">
                        Tidak ada hasil untuk pencarian "${searchTerm}"
                    </td>
                `;
                tableBody.appendChild(noResultsRow);
            }
        } else {
            // Remove the "no results" row if it exists
            const noResultsRow = document.getElementById('noResultsRow');
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    }

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
                <p class="text-sm font-bold">${message}</p>
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

    // Fungsi untuk membuka modal penyesuaian
    function openModalAdjust(sku, produk, outlet, stok) {
        const modal = document.getElementById('modalAdjustStock');
        
        // Set data ke form
        document.getElementById('adjustSku').textContent = sku;
        document.getElementById('adjustProduk').textContent = produk;
        document.getElementById('adjustOutlet').textContent = outlet;
        document.getElementById('stokSaatIni').textContent = stok;
        document.getElementById('jumlahAdjust').value = '';
        document.getElementById('keteranganAdjust').value = '';
        
        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // Fungsi untuk menutup modal penyesuaian
    function closeModalAdjust() {
        const modal = document.getElementById('modalAdjustStock');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Fungsi untuk submit penyesuaian
    function submitAdjust() {
        // Ambil data dari form
        const jumlah = parseInt(document.getElementById('jumlahAdjust').value);
        const tipe = document.getElementById('tipeAdjust').value;
        const keterangan = document.getElementById('keteranganAdjust').value;
        
        // Validasi input
        if (!jumlah) {
            showAlert('error', 'Jumlah penyesuaian harus diisi');
            return;
        }
        
        if (!tipe) {
            showAlert('error', 'Silakan pilih tipe penyesuaian');
            return;
        }
        
        // Ambil data produk dari form
        const outletId = localStorage.getItem('activeOutlet') || 1;
        const sku = document.getElementById('adjustSku').textContent;
        const stokSaatIni = parseInt(document.getElementById('stokSaatIni').textContent);
        
        // Tampilkan loading
        showLoading(true);
        
        // Buat objek data untuk dikirim ke API
        const requestData = {
            product_sku: sku,
            outlet_id: outletId, // Gunakan ID outlet yang sedang aktif
            quantity_before: stokSaatIni,
            quantity_after: stokSaatIni + jumlah,
            quantity_change: jumlah,
            type: tipe,
            notes: keterangan
        };
        
        // Kirim data ke API
        fetch('http://127.0.0.1:8000/api/inventory-histories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Tutup modal
                closeModalAdjust();
                
                // Tampilkan pesan sukses
                const action = jumlah > 0 ? 'menambah' : 'mengurangi';
                showAlert('success', `Berhasil ${action} stok sebesar ${Math.abs(jumlah)}`);
                
                // Refresh data inventori
                const outletId = 1; // Gunakan ID outlet yang sedang aktif
                fetchInventoryHistory(outletId);
            } else {
                showAlert('error', data.message || 'Gagal menyimpan penyesuaian stok');
            }
        })
        .catch(error => {
            console.error('Error submitting adjustment:', error);
            showAlert('error', 'Gagal menyimpan penyesuaian stok. Silakan coba lagi.');
        })
        .finally(() => {
            showLoading(false);
        });
    }

    // Event listener untuk tombol di modal
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnBatalAdjust')?.addEventListener('click', closeModalAdjust);
        document.getElementById('btnSubmitAdjust')?.addEventListener('click', submitAdjust);
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