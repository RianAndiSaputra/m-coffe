<!-- Stock Adjustment Modal -->
<div id="stockModal" class="modal fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-3xl mx-auto rounded-lg shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-xl font-bold">Sesuaikan Stok</p>
                <button onclick="closeModal('stockModal')" class="modal-close cursor-pointer z-50 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
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
                        <select id="product_id" class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Pilih produk</option>
                        </select>
                    </div>

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-2">Nilai + / -</label>
                            <input type="number" id="quantity_change" class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" placeholder="Masukkan nilai">
                        </div>
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-2">Tipe</label>
                            <select id="adjust_type" class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Pilih tipe</option>
                                <option value="shipment">Kiriman</option>
                                <option value="purchase">Pembelian</option>
                                <option value="sale">Penjualan</option>
                                <option value="adjustment">Penyesuaian</option>
                                <option value="stocktake">Stok Opname</option>
                                <option value="transfer">Transfer</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea id="notes" class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" rows="3" placeholder="Masukkan keterangan (opsional)"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-2 space-x-4">
                    <button onclick="closeModal('stockModal')" class="px-6 py-2 text-base bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                    <button onclick="submitStockAdjustment()" class="px-6 py-2 text-base bg-orange-500 text-white rounded-lg hover:bg-orange-600">Sesuaikan Stok</button>
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
                                <input type="date" id="date_from" class="px-3 py-1 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            <div class="flex items-center">
                                <label class="text-sm font-medium text-gray-700 mr-2">Sampai:</label>
                                <input type="date" id="date_to" class="px-3 py-1 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            <button onclick="loadInventoryHistory()" class="px-4 py-1 text-sm bg-orange-500 text-white rounded-lg hover:bg-orange-600">Filter</button>
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
                                    Memuat data...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        if (modalId === 'stockModal') {
            loadProducts();
            
            // Set default dates for history filter
            const today = new Date();
            const lastMonth = new Date(today);
            lastMonth.setMonth(today.getMonth() - 1);
            
            document.getElementById('date_from').valueAsDate = lastMonth;
            document.getElementById('date_to').valueAsDate = today;
            
            // If active tab is history, load the history
            if (!document.getElementById('historyContent').classList.contains('hidden')) {
                loadInventoryHistory();
            }
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Tab switching functionality
    document.getElementById('adjustTab').addEventListener('click', function () {
        this.classList.add('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('historyTab').classList.remove('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('historyTab').classList.add('text-gray-500');
        document.getElementById('adjustContent').classList.remove('hidden');
        document.getElementById('historyContent').classList.add('hidden');
    });

    document.getElementById('historyTab').addEventListener('click', function () {
        this.classList.add('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('adjustTab').classList.remove('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('adjustTab').classList.add('text-gray-500');
        document.getElementById('historyContent').classList.remove('hidden');
        document.getElementById('adjustContent').classList.add('hidden');
        
        // Load history data when switching to history tab
        loadInventoryHistory();
    });
    
    // Get outlet ID from local storage or parent component
    function getOutletId() {
        // You can get this from your app context or state
        const outletId = localStorage.getItem('outlet_id');
        if (!outletId) {
            alert('Tidak ada outlet yang dipilih');
            return null;
        }
        return outletId;
    }
    
    // Get auth token from localStorage
    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Anda tidak terautentikasi');
            return null;
        }
        return token;
    }
    
    function loadProducts() {
        console.log('loadProducts function called');
        
        // Get necessary values
        const outletId = getOutletId();
        const token = getToken();
        
        console.log('outletId:', outletId);
        console.log('token:', token ? 'Token exists' : 'Token missing');
        
        if (!outletId || !token) {
            console.error('Missing outletId or token. Cannot load products.');
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
        
        // Try the original URL from your code
        const apiUrl = `/api/products/outlet/pos/${outletId}`;
        console.log('Fetching products from:', apiUrl);
        
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('API response:', data);
            
            productSelect.innerHTML = '<option value="">Pilih produk</option>';
            productSelect.disabled = false;
            
            if (data.success && data.data && data.data.products) {
                // Sort products by name
                const products = data.data.products.sort((a, b) => a.name.localeCompare(b.name));
                
                if (products.length === 0) {
                    console.log('No products found in the response');
                    productSelect.innerHTML += '<option value="" disabled>Tidak ada produk</option>';
                    return;
                }
                
                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = `${product.name} (${product.sku}) - Stok: ${product.quantity || 0}`;
                    productSelect.appendChild(option);
                });
                
                console.log(`Loaded ${products.length} products successfully`);
            } else {
                console.error('Error loading products:', data.message || 'Format data tidak sesuai');
                productSelect.innerHTML += '<option value="" disabled>Gagal memuat produk</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            
            // If the first attempt fails, try an alternative URL
            console.log('Trying alternative endpoint...');
            
            const alternativeUrl = `/api//products/outlet/pos/{outletId}`;
            console.log('Fetching products from alternative URL:', alternativeUrl);
            
            fetch(alternativeUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error on alternative URL! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Alternative API response:', data);
                
                productSelect.innerHTML = '<option value="">Pilih produk</option>';
                productSelect.disabled = false;
                
                if (data.success && data.data && data.data.products) {
                    // Sort products by name
                    const products = data.data.products.sort((a, b) => a.name.localeCompare(b.name));
                    
                    if (products.length === 0) {
                        console.log('No products found in the response');
                        productSelect.innerHTML += '<option value="" disabled>Tidak ada produk</option>';
                        return;
                    }
                    
                    products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.id;
                        option.textContent = `${product.name} (${product.sku}) - Stok: ${product.quantity || 0}`;
                        productSelect.appendChild(option);
                    });
                    
                    console.log(`Loaded ${products.length} products successfully from alternative URL`);
                } else {
                    console.error('Error loading products from alternative URL:', data.message || 'Format data tidak sesuai');
                    productSelect.innerHTML += '<option value="" disabled>Gagal memuat produk</option>';
                }
            })
            .catch(secondError => {
                console.error('Error with alternative endpoint:', secondError);
                productSelect.innerHTML = '<option value="">Error memuat produk</option>';
                productSelect.disabled = false;
            });
        });
    }

    // Make sure the function gets called when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, calling loadProducts()');
        loadProducts();
    });

    // Or if you need to call it after some event
    function initializeProductDropdown() {
        console.log('Initializing product dropdown');
        loadProducts();
    }
    
    // Load inventory history
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
                    Memuat data...
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
                    
                    if (history.status === 'approved') {
                        statusText = 'Disetujui';
                        statusClass = 'text-green-600';
                    } else if (history.status === 'rejected') {
                        statusText = 'Ditolak';
                        statusClass = 'text-red-600';
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
                        <td class="px-4 py-3 text-sm ${history.quantity_change > 0 ? 'text-green-600' : 'text-red-600'}">${history.quantity_change > 0 ? '+' : ''}${history.quantity_change}</td>
                        <td class="px-4 py-3 text-sm">${typeMap[history.type] || history.type}</td>
                        <td class="px-4 py-3 text-sm">${history.notes || '-'}</td>
                        <td class="px-4 py-3 text-sm ${statusClass}">${statusText}</td>
                    `;
                    
                    historyTableBody.appendChild(row);
                });
            } else {
                historyTableBody.innerHTML = `
                    <tr class="border-b">
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada data penyesuaian stok untuk periode yang dipilih.
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('historyTableBody').innerHTML = `
                <tr class="border-b">
                    <td colspan="6" class="px-4 py-8 text-center text-red-500">
                        Terjadi kesalahan saat memuat data. Silakan coba lagi.
                    </td>
                </tr>
            `;
        });
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
            alert('Silakan pilih produk');
            return;
        }
        
        if (!quantityChange) {
            alert('Silakan masukkan nilai perubahan stok');
            return;
        }
        
        if (!adjustType) {
            alert('Silakan pilih tipe penyesuaian');
            return;
        }
        
        // Show loading state
        const submitButton = document.querySelector('#adjustContent button:last-child');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Memproses...';
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
            submitButton.textContent = originalText;
            submitButton.disabled = false;
            
            if (data.success) {
                alert(data.message || 'Penyesuaian stok berhasil disimpan');
                
                // Reset form
                document.getElementById('product_id').value = '';
                document.getElementById('quantity_change').value = '';
                document.getElementById('adjust_type').value = '';
                document.getElementById('notes').value = '';
                
                // Switch to history tab to show the result
                document.getElementById('historyTab').click();
            } else {
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            submitButton.textContent = originalText;
            submitButton.disabled = false;
            alert('Terjadi kesalahan saat menyimpan penyesuaian stok');
        });
    }
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
</style>