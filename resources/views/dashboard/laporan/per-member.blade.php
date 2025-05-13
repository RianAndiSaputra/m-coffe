@extends('layouts.app')

@section('title', 'Laporan Penjualan per Member')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Laporan Penjualan per Member</h1>
        <div class="flex gap-2">
            <button onclick="printReport()" class="px-4 py-2 bg-white text-orange-500 border border-orange-500 rounded-lg hover:bg-orange-50 flex items-center gap-2">
                <i data-lucide="printer" class="w-5 h-5"></i>
                Cetak
            </button>
            <button onclick="exportReport()" class="px-4 py-2 bg-white text-green-500 border border-green-500 rounded-lg hover:bg-green-50 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Ekspor
            </button>
        </div>
    </div>
</div>

<!-- Card: Info Outlet -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: Kifa Bakery Pusat</h4>
            <p class="text-sm text-gray-600">Periode: <span id="dateRangeDisplay">01 Mei 2025 - 11 Mei 2025</span></p>
        </div>
    </div>
    <div class="text-right">
        <p class="text-sm font-medium text-gray-600">Total Member</p>
        <h4 class="text-xl font-bold text-gray-800" id="totalMembers">3 member</h4>
    </div>
</div>

<!-- Laporan Penjualan per Member -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Penjualan per Member</h1>
        <p class="text-sm text-gray-600">Riwayat transaksi pembelian masing-masing member</p>
        
        <!-- Filter + Search -->
        <div class="flex flex-col md:flex-row md:items-end gap-4 mt-3 w-full">
            <!-- Filter Tanggal -->
            <div class="flex-1">
                <h2 class="text-sm font-medium text-gray-800 mb-1">Rentang Tanggal</h2>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
                        </span>
                        <input type="text" id="dateRange" placeholder="Pilih rentang tanggal"
                            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                    </div>
                </div>
            </div>
            <!-- Cari Member -->
            <div class="flex-1">
                <h2 class="text-sm font-medium text-gray-800 mb-1">Cari Member</h2>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Cari member..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" />
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <!-- Total Transaksi -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="totalTransactions">5 transaksi</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <i data-lucide="shopping-bag" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Produk Terjual -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Produk Terjual</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="totalProductsSold">24 produk</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-full">
                    <i data-lucide="package" class="w-6 h-6 text-green-500"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Pendapatan -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-gray-800" id="totalRevenue">Rp 1.250.000</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-full">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Tables Section -->
    <div id="memberTablesContainer" class="mt-8 space-y-8">
        <!-- Tables will be generated here dynamically -->
    </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    // Sample data for demonstration
    const memberData = [
        {
            id: 'M001',
            name: 'Budi Santoso',
            phone: '081234567890',
            joinDate: '15 Jan 2023',
            totalSpent: 'Rp 750.000',
            transactions: [
                {
                    date: '10 Mei 2025',
                    invoice: 'INV-20250510-001',
                    items: [
                        { product: 'Roti Tawar Gandum', qty: 2, price: 'Rp 25.000', total: 'Rp 50.000' },
                        { product: 'Brownies Coklat', qty: 3, price: 'Rp 15.000', total: 'Rp 45.000' },
                        { product: 'Donat Glaze', qty: 5, price: 'Rp 10.000', total: 'Rp 50.000' }
                    ],
                    subtotal: 'Rp 145.000',
                    discount: 'Rp 5.000',
                    total: 'Rp 140.000'
                },
                {
                    date: '05 Mei 2025',
                    invoice: 'INV-20250505-003',
                    items: [
                        { product: 'Pastel Sayur', qty: 4, price: 'Rp 12.000', total: 'Rp 48.000' },
                        { product: 'Roti Sobek Keju', qty: 2, price: 'Rp 18.000', total: 'Rp 36.000' }
                    ],
                    subtotal: 'Rp 84.000',
                    discount: 'Rp 4.000',
                    total: 'Rp 80.000'
                }
            ]
        },
        {
            id: 'M002',
            name: 'Ani Wijaya',
            phone: '082345678901',
            joinDate: '20 Mar 2024',
            totalSpent: 'Rp 350.000',
            transactions: [
                {
                    date: '08 Mei 2025',
                    invoice: 'INV-20250508-002',
                    items: [
                        { product: 'Bolu Gulung', qty: 1, price: 'Rp 75.000', total: 'Rp 75.000' },
                        { product: 'Chiffon Cake', qty: 1, price: 'Rp 65.000', total: 'Rp 65.000' }
                    ],
                    subtotal: 'Rp 140.000',
                    discount: 'Rp 10.000',
                    total: 'Rp 130.000'
                },
                {
                    date: '03 Mei 2025',
                    invoice: 'INV-20250503-001',
                    items: [
                        { product: 'Roti Tawar Original', qty: 3, price: 'Rp 20.000', total: 'Rp 60.000' },
                        { product: 'Pizza Mini', qty: 2, price: 'Rp 25.000', total: 'Rp 50.000' }
                    ],
                    subtotal: 'Rp 110.000',
                    discount: 'Rp 10.000',
                    total: 'Rp 100.000'
                }
            ]
        },
        {
            id: 'M003',
            name: 'Citra Dewi',
            phone: '083456789012',
            joinDate: '05 Feb 2025',
            totalSpent: 'Rp 150.000',
            transactions: [
                {
                    date: '02 Mei 2025',
                    invoice: 'INV-20250502-001',
                    items: [
                        { product: 'Croissant', qty: 2, price: 'Rp 25.000', total: 'Rp 50.000' },
                        { product: 'Bagel', qty: 3, price: 'Rp 20.000', total: 'Rp 60.000' }
                    ],
                    subtotal: 'Rp 110.000',
                    discount: 'Rp 10.000',
                    total: 'Rp 100.000'
                }
            ]
        }
    ];

    // Initialize date range picker
    const dateRangePicker = flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["2025-05-01", "2025-05-11"],
        locale: "id",
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length === 2) {
                const startDate = formatDate(selectedDates[0]);
                const endDate = formatDate(selectedDates[1]);
                document.getElementById('dateRangeDisplay').textContent = `${startDate} - ${endDate}`;
                filterData();
                showAlert('success', `Menampilkan data dari ${startDate} sampai ${endDate}`);
            }
        }
    });

    // Format date to Indonesian format
    function formatDate(date) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    // Search input handler
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        filterData();
    });

    // Filter data function
    function filterData() {
        const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
        
        // Filter members based on search term
        const filteredMembers = memberData.filter(member => 
            member.name.toLowerCase().includes(searchTerm) ||
            member.phone.includes(searchTerm) ||
            member.id.toLowerCase().includes(searchTerm)
        );
        
        // Update member tables
        const container = document.getElementById('memberTablesContainer');
        container.innerHTML = '';
        
        let totalTransactions = 0;
        let totalProducts = 0;
        let totalRevenue = 0;
        
        filteredMembers.forEach(member => {
            // Create member card
            const memberCard = document.createElement('div');
            memberCard.className = 'bg-gray-50 rounded-lg p-4 mb-4';
            memberCard.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">${member.name}</h3>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                            <p class="text-sm text-gray-600">ID: ${member.id}</p>
                            <p class="text-sm text-gray-600">Telp: ${member.phone}</p>
                            <p class="text-sm text-gray-600">Bergabung: ${member.joinDate}</p>
                            <p class="text-sm text-gray-600">Total Belanja: <span class="font-semibold">${member.totalSpent}</span></p>
                        </div>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <p class="text-sm text-gray-600">Total Transaksi: <span class="font-semibold">${member.transactions.length}</span></p>
                    </div>
                </div>
            `;
            container.appendChild(memberCard);
            
            // Create transactions table for this member
            const tableDiv = document.createElement('div');
            tableDiv.className = 'overflow-x-auto';
            tableDiv.innerHTML = `
                <table class="w-full text-sm">
                    <thead class="text-left text-gray-700 bg-gray-100">
                        <tr>
                            <th class="py-3 font-bold px-4">Tanggal</th>
                            <th class="py-3 font-bold px-4">Invoice</th>
                            <th class="py-3 font-bold px-4">Produk</th>
                            <th class="py-3 font-bold px-4 text-right">Qty</th>
                            <th class="py-3 font-bold px-4 text-right">Harga</th>
                            <th class="py-3 font-bold px-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y" id="transactions-${member.id}">
                        <!-- Transactions will be inserted here -->
                    </tbody>
                </table>
            `;
            container.appendChild(tableDiv);
            
            // Add transactions for this member
            const tbody = document.getElementById(`transactions-${member.id}`);
            
            member.transactions.forEach((trans, index) => {
                // Add transaction row
                trans.items.forEach((item, itemIndex) => {
                    const row = document.createElement('tr');
                    if (itemIndex === 0) {
                        // First item shows transaction date and invoice
                        row.innerHTML = `
                            <td class="py-4 px-4" rowspan="${trans.items.length}">${trans.date}</td>
                            <td class="py-4 px-4" rowspan="${trans.items.length}">${trans.invoice}</td>
                            <td class="py-4 px-4">${item.product}</td>
                            <td class="py-4 px-4 text-right">${item.qty}</td>
                            <td class="py-4 px-4 text-right">${item.price}</td>
                            <td class="py-4 px-4 text-right">${item.total}</td>
                        `;
                    } else {
                        // Subsequent items only show product details
                        row.innerHTML = `
                            <td class="py-4 px-4">${item.product}</td>
                            <td class="py-4 px-4 text-right">${item.qty}</td>
                            <td class="py-4 px-4 text-right">${item.price}</td>
                            <td class="py-4 px-4 text-right">${item.total}</td>
                        `;
                    }
                    tbody.appendChild(row);
                    
                    // Update totals
                    totalProducts += item.qty;
                });
                
                // Add transaction summary row
                const summaryRow = document.createElement('tr');
                summaryRow.className = 'bg-gray-50 font-semibold';
                summaryRow.innerHTML = `
                    <td class="py-3 px-4 text-right" colspan="4">Subtotal</td>
                    <td class="py-3 px-4 text-right">${trans.subtotal}</td>
                    <td class="py-3 px-4"></td>
                `;
                tbody.appendChild(summaryRow);
                
                const discountRow = document.createElement('tr');
                discountRow.className = 'bg-gray-50 font-semibold';
                discountRow.innerHTML = `
                    <td class="py-3 px-4 text-right" colspan="4">Diskon</td>
                    <td class="py-3 px-4 text-right text-red-500">-${trans.discount}</td>
                    <td class="py-3 px-4"></td>
                `;
                tbody.appendChild(discountRow);
                
                const totalRow = document.createElement('tr');
                totalRow.className = 'bg-gray-100 font-bold';
                totalRow.innerHTML = `
                    <td class="py-3 px-4 text-right" colspan="4">Total</td>
                    <td class="py-3 px-4 text-right">${trans.total}</td>
                    <td class="py-3 px-4"></td>
                `;
                tbody.appendChild(totalRow);
                
                // Add spacer row
                const spacerRow = document.createElement('tr');
                spacerRow.innerHTML = '<td class="py-2" colspan="6"></td>';
                tbody.appendChild(spacerRow);
                
                // Update transaction count
                totalTransactions++;
                // Update revenue (remove 'Rp ' and convert to number)
                totalRevenue += parseInt(trans.total.replace('Rp ', '').replace(/\./g, ''));
            });
        });
        
        // Update summary cards
        document.getElementById('totalMembers').textContent = `${filteredMembers.length} member`;
        document.getElementById('totalTransactions').textContent = `${totalTransactions} transaksi`;
        document.getElementById('totalProductsSold').textContent = `${totalProducts} produk`;
        document.getElementById('totalRevenue').textContent = `Rp ${formatNumber(totalRevenue)}`;
    }

    // Format number with thousand separators
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Print report function
    function printReport() {
        showAlert('info', 'Mempersiapkan laporan untuk dicetak...');
        setTimeout(() => {
            window.print();
        }, 1000);
    }
    
    // Export report function
    function exportReport() {
        showAlert('info', 'Mempersiapkan laporan untuk diekspor...');
        setTimeout(() => {
            const a = document.createElement('a');
            a.href = 'data:text/csv;charset=utf-8,';
            a.download = `laporan-penjualan-member-${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            showAlert('success', 'Laporan berhasil diekspor');
        }, 1000);
    }
    
    // Show alert function
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md ${type === 'error' ? 'bg-red-100 text-red-700' : 
                         type === 'success' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'}`;
        alert.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : 
                                    type === 'success' ? 'check-circle' : 'info'}" 
                       class="w-5 h-5"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        `;
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    // Initial load
    filterData();
</script>

@endsection