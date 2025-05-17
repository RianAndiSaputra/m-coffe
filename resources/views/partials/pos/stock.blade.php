<!-- Stock Adjustment Modal -->
<div id="stockModal" class="modal fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-3xl mx-auto rounded-lg shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-xl font-bold">Sesuaikan Stok</p>
                <button onclick="closeModal('stockModal')" class="modal-close cursor-pointer z-50 text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <p class="text-base text-gray-600 mb-4">Sesuaikan stok produk. Perubahan memerlukan persetujuan admin</p>

            <!-- Tabs -->
            <div class="flex bg-gray-100 rounded-lg p-1 mb-6 w-fit">
                <button id="adjustTab" class="tab-button active px-6 py-2 rounded-lg font-medium text-base text-orange-500 bg-white shadow">Sesuaikan</button>
                <button id="historyTab" class="tab-button px-6 py-2 rounded-lg font-medium text-base text-gray-500 hover:text-gray-700">Riwayat</button>
            </div>

            <!-- Adjust Content -->
            <div id="adjustContent" class="tab-content">
                <div class="mb-6">
                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 mb-2">Nama Produk</label>
                        <div class="relative">
                            <select id="product_id" class="w-full px-4 py-2.5 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 appearance-none bg-white pr-10">
                                <option value="">Pilih produk</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-2">Nilai + / -</label>
                            <input type="number" id="quantity_change" class="w-full px-4 py-2.5 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" placeholder="Masukkan nilai">
                        </div>
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-2">Tipe</label>
                            <div class="relative">
                                <select id="adjust_type" class="w-full px-4 py-2.5 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 appearance-none bg-white pr-10">
                                    <option value="">Pilih tipe</option>
                                    <option value="shipment">Kiriman</option>
                                    <option value="purchase">Pembelian</option>
                                    <option value="sale">Penjualan</option>
                                    <option value="adjustment">Penyesuaian</option>
                                    <option value="stocktake">Stok Opname</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="other">Lainnya</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea id="notes" class="w-full px-4 py-2.5 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" rows="3" placeholder="Masukkan keterangan (opsional)"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-2 space-x-4">
                    <button onclick="closeModal('stockModal')" class="px-6 py-2.5 text-base bg-gray-300 rounded-lg hover:bg-gray-400 flex items-center gap-2">
                        <i data-lucide="x" class="w-4 h-4"></i> Batal
                    </button>
                    <button onclick="submitStockAdjustment()" class="px-6 py-2.5 text-base bg-orange-500 text-white rounded-lg hover:bg-orange-600 flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i> Sesuaikan Stok
                    </button>
                </div>
            </div>

            <!-- History Content -->
            <div id="historyContent" class="tab-content hidden">
                <div class="mb-4">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-700">Riwayat Penyesuaian Stok</h3>
                        
                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 mt-2 md:mt-0">
                            <div class="flex items-center">
                                <label class="text-sm font-medium text-gray-700 mr-2">Dari:</label>
                                <div class="relative">
                                    <input type="date" id="date_from" class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                                    <i data-lucide="calendar" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="text-sm font-medium text-gray-700 mr-2">Sampai:</label>
                                <div class="relative">
                                    <input type="date" id="date_to" class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                                    <i data-lucide="calendar" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                            <button onclick="loadInventoryHistory()" class="px-4 py-1.5 text-sm bg-orange-500 text-white rounded-lg hover:bg-orange-600 flex items-center gap-1">
                                <i data-lucide="filter" class="w-4 h-4"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="border-b">
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Tanggal</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Nama Produk</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Perubahan</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Tipe</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Keterangan</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <tr class="border-b">
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex justify-center items-center gap-2">
                                        <i data-lucide="loader" class="w-5 h-5 animate-spin text-gray-400"></i>
                                        Memuat data...
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Container -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-3 w-80"></div>

<!-- Include Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>

<script>
    // Initialize Lucide Icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });

    // Modern notification function
    function showNotification(type, title, message) {
        const container = document.getElementById('notification-container');
        const icons = {
            success: 'check-circle',
            error: 'x-circle',
            warning: 'alert-triangle',
            info: 'info'
        };
        const colors = {
            success: 'bg-green-100 border-green-500 text-green-700',
            error: 'bg-red-100 border-red-500 text-red-700',
            warning: 'bg-yellow-100 border-yellow-500 text-yellow-700',
            info: 'bg-blue-100 border-blue-500 text-blue-700'
        };
        
        const notification = document.createElement('div');
        notification.className = `p-4 rounded-lg border-l-4 ${colors[type]} shadow-lg transform transition-all duration-300 ease-in-out translate-x-96 opacity-0`;
        notification.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i data-lucide="${icons[type]}" class="w-5 h-5 mt-0.5"></i>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="font-medium">${title}</p>
                    <p class="mt-1 text-sm">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="rounded-md focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        `;
        
        container.appendChild(notification);
        setTimeout(() => {
            notification.classList.remove('translate-x-96', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 10);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-96', 'opacity-0');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
        
        // Initialize icons in the new notification
        lucide.createIcons();
    }

    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        if (modalId === 'stockModal') {
            loadProducts();
            
            // Set default dates for history filter
            const today = new Date();
            const lastMonth = new Date(today);
            lastMonth.setMonth(today.getMonth() - 1);
            
            const dateFromInput = document.getElementById('date_from');
            const dateToInput = document.getElementById('date_to');
            
            if (dateFromInput) dateFromInput.valueAsDate = lastMonth;
            if (dateToInput) dateToInput.valueAsDate = today;
            
            // If active tab is history, load the history
            if (document.getElementById('historyContent') && 
                !document.getElementById('historyContent').classList.contains('hidden')) {
                loadInventoryHistory();
            }
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const adjustTab = document.getElementById('adjustTab');
        const historyTab = document.getElementById('historyTab');
        
        if (adjustTab) {
            adjustTab.addEventListener('click', function () {
                this.classList.add('active', 'text-orange-500', 'bg-white', 'shadow');
                document.getElementById('historyTab').classList.remove('active', 'text-orange-500', 'bg-white', 'shadow');
                document.getElementById('historyTab').classList.add('text-gray-500');
                document.getElementById('adjustContent').classList.remove('hidden');
                document.getElementById('historyContent').classList.add('hidden');
            });
        }
        
        if (historyTab) {
            historyTab.addEventListener('click', function () {
                this.classList.add('active', 'text-orange-500', 'bg-white', 'shadow');
                document.getElementById('adjustTab').classList.remove('active', 'text-orange-500', 'bg-white', 'shadow');
                document.getElementById('adjustTab').classList.add('text-gray-500');
                document.getElementById('historyContent').classList.remove('hidden');
                document.getElementById('adjustContent').classList.add('hidden');
                
                // Load history data when switching to history tab
                loadInventoryHistory();
            });
        }
    });
    
    // Get outlet ID from local storage or parent component
    function getOutletId() {
        const outletId = localStorage.getItem('outlet_id');
        if (!outletId) {
            showNotification('warning', 'Peringatan', 'Tidak ada outlet yang dipilih');
            return null;
        }
        return outletId;
    }
    
    // Get auth token from localStorage
    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            showNotification('error', 'Error', 'Anda tidak terautentikasi');
            return null;
        }
        return token;
    }
    
    function loadProducts() {
        // Get necessary values
        const outletId = getOutletId();
        const token = getToken();
        
        if (!outletId || !token) {
            return;
        }
        
        // Update UI to show loading state
        const productSelect = document.getElementById('product_id');
        if (!productSelect) {
            console.error('Product select element not found with ID "product_id"');
            return;
        }
        
        productSelect.innerHTML = '<option value="">Memuat produk...</option>';
        productSelect.disabled = true;
        
        const apiUrl = `/api/products/outlet/${outletId}`;
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            productSelect.innerHTML = '<option value="">Pilih produk</option>';
            productSelect.disabled = false;
            
            if (data.success && data.data) {
                const products = Array.isArray(data.data) ? 
                    data.data.sort((a, b) => a.name.localeCompare(b.name)) : 
                    [];
                
                if (products.length === 0) {
                    productSelect.innerHTML += '<option value="" disabled>Tidak ada produk</option>';
                    return;
                }
                
                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = `${product.name} (${product.sku || 'No SKU'}) - Stok: ${product.quantity || 0}`;
                    productSelect.appendChild(option);
                });
            } else {
                showNotification('error', 'Error', data.message || 'Format data tidak sesuai');
                productSelect.innerHTML += '<option value="" disabled>Gagal memuat produk</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            showNotification('error', 'Error', 'Gagal memuat daftar produk');
            productSelect.innerHTML = '<option value="">Error memuat produk</option>';
            productSelect.disabled = false;
        });
    }

    function loadInventoryHistory() {
        const outletId = getOutletId();
        const token = getToken();
        const dateFrom = document.getElementById('date_from').value;
        const dateTo = document.getElementById('date_to').value;
        
        if (!outletId || !token) return;
        
        // Update table with loading message
        document.getElementById('historyTableBody').innerHTML = `
            <tr class="border-b">
                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                    <div class="flex justify-center items-center gap-2">
                        <i data-lucide="loader" class="w-5 h-5 animate-spin text-gray-400"></i>
                        Memuat data...
                    </div>
                </td>
            </tr>
        `;
        
        fetch(`/api/adjust-inventory/${outletId}?date_from=${dateFrom}&date_to=${dateTo}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(data => {
            const historyTableBody = document.getElementById('historyTableBody');
            historyTableBody.innerHTML = '';
            
            if (data.success && data.data.length > 0) {
                data.data.forEach(history => {
                    const row = document.createElement('tr');
                    row.className = 'border-b hover:bg-gray-50';
                    
                    // Format date
                    const date = new Date(history.created_at);
                    const formattedDate = date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    // Map status to Indonesian
                    let statusText = 'Menunggu';
                    let statusClass = 'text-yellow-600';
                    let statusIcon = 'clock';
                    
                    if (history.status === 'approved') {
                        statusText = 'Disetujui';
                        statusClass = 'text-green-600';
                        statusIcon = 'check-circle';
                    } else if (history.status === 'rejected') {
                        statusText = 'Ditolak';
                        statusClass = 'text-red-600';
                        statusIcon = 'x-circle';
                    }
                    
                    // Map type to Indonesian
                    const typeMap = {
                        'shipment': 'Kiriman',
                        'purchase': 'Pembelian',
                        'sale': 'Penjualan',
                        'adjustment': 'Penyesuaian',
                        'stocktake': 'Stok Opname',
                        'transfer': 'Transfer',
                        'other': 'Lainnya'
                    };
                    
                    row.innerHTML = `
                        <td class="px-4 py-3 text-sm">${formattedDate}</td>
                        <td class="px-4 py-3 text-sm">${history.product.name}</td>
                        <td class="px-4 py-3 text-sm ${history.quantity_change > 0 ? 'text-green-600' : 'text-red-600'} font-medium">
                            ${history.quantity_change > 0 ? '+' : ''}${history.quantity_change}
                        </td>
                        <td class="px-4 py-3 text-sm">${typeMap[history.type] || history.type}</td>
                        <td class="px-4 py-3 text-sm">${history.notes || '-'}</td>
                        <td class="px-4 py-3 text-sm ${statusClass} flex items-center gap-1">
                            <i data-lucide="${statusIcon}" class="w-4 h-4"></i> ${statusText}
                        </td>
                    `;
                    
                    historyTableBody.appendChild(row);
                });
                
                // Initialize icons in the table
                lucide.createIcons();
            } else {
                historyTableBody.innerHTML = `
                    <tr class="border-b">
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                                <span>Tidak ada data penyesuaian stok untuk periode yang dipilih.</span>
                            </div>
                        </td>
                    </tr>
                `;
                
                // Initialize icons in the empty state
                lucide.createIcons();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('historyTableBody').innerHTML = `
                <tr class="border-b">
                    <td colspan="6" class="px-4 py-8 text-center text-red-500">
                        <div class="flex flex-col items-center gap-2">
                            <i data-lucide="alert-circle" class="w-8 h-8"></i>
                            <span>Terjadi kesalahan saat memuat data. Silakan coba lagi.</span>
                        </div>
                    </td>
                </tr>
            `;
            
            // Initialize icons in the error state
            lucide.createIcons();
        });
    }
    
    // Function to filter history based on date inputs
    function filterHistory() {
        loadInventoryHistory();
    }

    // Submit stock adjustment
    function submitStockAdjustment() {
        const outletId = getOutletId();
        const token = getToken();
        const productId = document.getElementById('product_id').value;
        const quantityChange = document.getElementById('quantity_change').value;
        const adjustType = document.getElementById('adjust_type').value;
        const notes = document.getElementById('notes').value;
        
        if (!outletId || !token) return;
        
        // Validate inputs
        if (!productId) {
            showNotification('warning', 'Peringatan', 'Silakan pilih produk');
            return;
        }
        
        if (!quantityChange) {
            showNotification('warning', 'Peringatan', 'Silakan masukkan nilai perubahan stok');
            return;
        }
        
        if (!adjustType) {
            showNotification('warning', 'Peringatan', 'Silakan pilih tipe penyesuaian');
            return;
        }
        
        // Show loading state
        const submitButton = document.querySelector('#adjustContent button:last-child');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Memproses...';
        submitButton.disabled = true;
        
        fetch('/api/adjust-inventory', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                outlet_id: outletId,
                product_id: productId,
                quantity_change: parseInt(quantityChange),
                type: adjustType,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
            
            if (data.success) {
                showNotification('success', 'Berhasil', data.message || 'Penyesuaian stok berhasil disimpan');
                
                // Reset form
                document.getElementById('product_id').value = '';
                document.getElementById('quantity_change').value = '';
                document.getElementById('adjust_type').value = '';
                document.getElementById('notes').value = '';
                
                // Switch to history tab to show the result
                document.getElementById('historyTab').click();
            } else {
                showNotification('error', 'Error', data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
            showNotification('error', 'Error', 'Terjadi kesalahan saat menyimpan penyesuaian stok');
        });
    }

    // Initialize everything when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Call loadProducts if we're on a page with that functionality
        const productSelect = document.getElementById('product_id');
        if (productSelect) {
            loadProducts();
        }
        
        // Set up date filter listeners if present
        const filterButton = document.getElementById('filterButton');
        if (filterButton) {
            filterButton.addEventListener('click', filterHistory);
        }
        
        // Initialize all Lucide icons
        lucide.createIcons();
    });
</script>

<style>
    .tab-button.active {
        background-color: white;
        color: #f97316;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tab-button:not(.active):hover {
        background-color: #f3f4f6;
    }
    
    /* Modern select dropdown styling */
    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1em;
    }
    
    /* Notification animation */
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
</style>