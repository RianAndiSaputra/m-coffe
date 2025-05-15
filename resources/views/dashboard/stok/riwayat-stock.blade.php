@extends('layouts.app')

@section('title', 'Manajemen Riwayat Stok')

@section('content')

<!-- Page Title -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Riwayat Stok</h1>
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <!-- Heroicons search icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
                </svg>
            </span>
            <input 
                type="text" 
                placeholder="Cari Produk..." 
                class="w-full pl-10 pr-4 py-3 border rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                {{-- id="searchKategori" --}}
            />
        </div>
    </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 outlet-name">Outlet Aktif: Loading...</h2>
            <p class="text-sm text-gray-600 outlet-address">Memuat data outlet...</p>
        </div>
    </div>
</div>

<!-- Card: Tabel Riwayat Stok -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header Table: Filter Tanggal -->
    <div class="mb-6">
        <div class="mt-2">
        <label for="reportDateInput" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
            <div class="relative">
                <input id="reportDateInput" type="text"
                    class="w-full sm:w-56 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                    placeholder="Tanggal" />
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-500"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Jam</th>
                    <th class="py-3 font-bold">Produk</th>
                    <th class="py-3 font-bold">Stok Sebelumnya</th>
                    <th class="py-3 font-bold">Stok Baru</th>
                    <th class="py-3 font-bold">Perubahan</th>
                    <th class="py-3 font-bold">Tipe</th>
                    <th class="py-3 font-bold">Catatan</th>
                </tr>
            </thead>
            <tbody id="historyTableBody" class="text-gray-700 divide-y">
                <!-- Data akan diisi via JavaScript -->
                <tr id="loadingRow">
                    <td colspan="7" class="py-4 text-center text-gray-500">
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{-- <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-gray-600">
            Menampilkan 1 sampai 3 dari 15 entri
        </div>
        <div class="flex space-x-1">
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">
                Previous
            </button>
            <button class="px-3 py-1 border rounded text-sm bg-orange-600 text-white hover:bg-orange-700">
                1
            </button>
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">
                2
            </button>
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">
                Next
            </button>
        </div>
    </div> --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Mapping style untuk tipe stok
    const typeStyles = {
        'purchase': { bg: 'bg-green-100', text: 'text-green-600' },
        'sale': { bg: 'bg-red-100', text: 'text-red-600' },
        'adjustment': { bg: 'bg-yellow-100', text: 'text-yellow-600' },
        'other': { bg: 'bg-gray-100', text: 'text-gray-600' },
        'stocktake': { bg: 'bg-purple-100', text: 'text-purple-600' },
        'shipment': { bg: 'bg-blue-100', text: 'text-blue-600' },
        'transfer_in': { bg: 'bg-teal-100', text: 'text-teal-600' },
        'transfer_out': { bg: 'bg-orange-100', text: 'text-orange-600' }
    };

    // Format waktu dari ISO
    function formatTime(isoString) {
        const date = new Date(isoString);
        return date.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit',
            hour12: false 
        });
    }

    // document.getElementById('searchInput').addEventListener('input', function(e) {
    //     const searchTerm = e.target.value.toLowerCase();
    //     const rows = document.querySelectorAll('#historyTableBody tr');
        
    //     rows.forEach(row => {
    //         const productName = row.querySelector('td:nth-child(2) span').textContent.toLowerCase();
    //         row.style.display = productName.includes(searchTerm) ? '' : 'none';
    //     });
    // });

    // Fetch data dari API
    async function fetchInventoryHistory(date) {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/inventory-histories/outlet/1?date=${date}`, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    'Accept': 'application/json'
                }
            });
            const { data, success, message } = await response.json();
            
            if (!success) throw new Error(message);
            
            return data;
        } catch (error) {
            showAlert('error', `Gagal memuat data: ${error.message}`);
            return [];
        }
    }

    // Update tampilan
    async function updateHistoryTable(date) {
        const tbody = document.getElementById('historyTableBody');
        tbody.innerHTML = `<tr id="loadingRow"><td colspan="7" class="py-4 text-center text-gray-500">Memuat data...</td></tr>`;
        
        const data = await fetchInventoryHistory(date);
        
        // Update info outlet
        if (data.length > 0) {
            document.querySelector('.outlet-name').textContent = `Outlet Aktif: ${data[0].outlet.name}`;
            document.querySelector('.outlet-address').textContent = data[0].outlet.address;
        }

        // Update tabel
        tbody.innerHTML = data.map(history => `
            <tr class="border-b hover:bg-gray-50">
                <td class="py-4">${formatTime(history.created_at)}</td>
                <td class="py-4">
                    <div class="flex items-center space-x-2">
                        <img src="https://via.placeholder.com/40" alt="gambar" class="w-8 h-8 bg-gray-100 rounded object-cover" />
                        <span>${history.product.name}</span>
                    </div>
                </td>
                <td>${history.quantity_before}</td>
                <td>${history.quantity_after}</td>
                <td class="${history.quantity_change > 0 ? 'text-green-500' : 'text-red-500'}">
                    ${history.quantity_change > 0 ? '+' : ''}${history.quantity_change}
                </td>
                <td>
                    <span class="px-2 py-1 ${typeStyles[history.type].bg} ${typeStyles[history.type].text} rounded text-xs capitalize">
                        ${history.type.replace(/_/g, ' ')}
                    </span>
                </td>
                <td class="text-xs text-gray-500">${history.notes || '-'}</td>
            </tr>
        `).join('');
    }

    // Update filter tanggal
    flatpickr("#reportDateInput", {
        dateFormat: "Y-m-d",
        defaultDate: "today",
        onChange: async function(selectedDates, dateStr) {
            await updateHistoryTable(dateStr);
        },
        locale: {
            firstDayOfWeek: 1
        }
    });

    // Panggil pertama kali saat halaman load
    document.addEventListener('DOMContentLoaded', async () => {
        const initialDate = new Date().toISOString().split('T')[0];
        await updateHistoryTable(initialDate);
    });

        function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md ${type === 'error' ? 'bg-red-100 text-red-700' : 
                         type === 'success' ? 'bg-orange-100 text-orange-700' : 'bg-orange-100 text-orange-700'}`;
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
        
        // Make sure Lucide icons are initialized for the new alert
        if (window.lucide) {
            window.lucide.createIcons();
        }
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
</script>

@endsection