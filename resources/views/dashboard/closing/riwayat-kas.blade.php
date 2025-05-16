@extends('layouts.app')

@section('title', 'Manajemen Riwayat Kas')

@section('content')

<!-- Page Title -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Riwayat Kas</h1>
    </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">Outlet Aktif: {{ $outlet->name ?? 'Kifa Bakery Pusat' }}</h2>
            <p class="text-sm text-gray-600">Data riwayat transaksi kas untuk outlet {{ $outlet->name ?? 'Kifa Bakery Pusat' }}.</p>
        </div>
    </div>
</div>

<!-- Card: Tabel Riwayat Kas -->
<div class="bg-white rounded-lg shadow p-4">
    <!-- Header Card + Filter Tanggal -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h3 class="text-2xl font-bold text-gray-800">Riwayat Kas</h3>
        <div class="relative mt-2 sm:mt-0">
            <input id="cashDateInput" type="text"
                class="w-full sm:w-56 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Pilih Tanggal" />
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i data-lucide="calendar" class="w-4 h-4 text-gray-500"></i>
            </span>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">User</th>
                    <th class="py-3 font-bold">Waktu</th>
                    <th class="py-3 font-bold">Tipe</th>
                    <th class="py-3 font-bold">Alasan</th>
                    <th class="py-3 font-bold">Total</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="cash-history-table">
                <!-- Data akan dimasukkan lewat JavaScript -->
                <tr class="border-b hover:bg-gray-50">
                    <td colspan="5" class="py-4 text-center text-gray-500">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Cek token
        const token = localStorage.getItem('token');
        if (!token) {
            console.error('Token not found. User might need to login again.');
            document.getElementById('cash-history-table').innerHTML = `
                <tr class="border-b hover:bg-gray-50">
                    <td colspan="5" class="py-4 text-center text-red-500">Sesi login telah berakhir. Silakan login kembali.</td>
                </tr>
            `;
            return;
        }

        const outletId = "{{ $outlet_id ?? 1 }}"; // Ganti dengan ID outlet aktif
        let selectedDate = null;

        // Inisialisasi datepicker
        flatpickr("#cashDateInput", {
            dateFormat: "Y-m-d",
            defaultDate: "today",
            onChange: function(selectedDates, dateStr) {
                selectedDate = dateStr;
                fetchCashHistory(outletId, dateStr);
            },
            onReady: function() {
                // Ambil tanggal hari ini dalam format YYYY-MM-DD
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const dateStr = `${year}-${month}-${day}`;
                
                // Set nilai input dan filter data
                document.getElementById('cashDateInput').value = dateStr;
                selectedDate = dateStr;
            },
            locale: {
                firstDayOfWeek: 1
            }
        });

        // Fungsi untuk mengambil data riwayat kas
        function fetchCashHistory(outletId, date = null) {
    // Tampilkan loading
    document.getElementById('cash-history-table').innerHTML = `
        <tr class="border-b hover:bg-gray-50">
            <td colspan="5" class="py-4 text-center text-gray-500">Memuat data...</td>
        </tr>
    `;

    // Siapkan query parameters
    let params = {
        source: 'cash',
        outlet_id: outletId
    };

    if (date) {
        params.date = date;
    }

    // Panggil API untuk mendapatkan riwayat kas
    axios.get('/api/cash-register-transactions', { 
        params,
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        const data = response.data.data;
        renderCashHistory(data);
    })
    .catch(error => {
        console.error('Error fetching cash history:', error);
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token');
            document.getElementById('cash-history-table').innerHTML = `
                <tr class="border-b hover:bg-gray-50">
                    <td colspan="5" class="py-4 text-center text-red-500">Sesi login telah berakhir. Silakan login kembali.</td>
                </tr>
            `;
        } else {
            document.getElementById('cash-history-table').innerHTML = `
                <tr class="border-b hover:bg-gray-50">
                    <td colspan="5" class="py-4 text-center text-red-500">Terjadi kesalahan saat memuat data</td>
                </tr>
            `;
        }
    });
}


        // Fungsi untuk menampilkan data dalam tabel
        function renderCashHistory(data) {
            const tableBody = document.getElementById('cash-history-table');
            
            // Clear existing content
            tableBody.innerHTML = '';

            if (!data || data.length === 0) {
                tableBody.innerHTML = `
                    <tr class="border-b hover:bg-gray-50">
                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada data transaksi kas untuk ditampilkan</td>
                    </tr>
                `;
                return;
            }

            data.forEach(transaction => {
                const formattedTime = moment(transaction.created_at).format('HH:mm:ss');
                const formattedDate = moment(transaction.created_at).format('DD MMM YYYY');
                const isAdd = transaction.type === 'add';
                const formattedAmount = new Intl.NumberFormat('id-ID').format(transaction.amount);
                const userName = transaction.user ? transaction.user.name : 'System';
                const reason = transaction.reason || '-';
                const source = transaction.source ? transaction.source.toUpperCase() : '-';

                const row = document.createElement('tr');
                row.className = 'border-b hover:bg-gray-50';
                row.innerHTML = `
                    <td class="py-4">${userName}</td>
                    <td class="py-4">
                        <div>${formattedTime}</div>
                        <div class="text-xs text-gray-500">${formattedDate}</div>
                    </td>
                    <td>
                        ${isAdd 
                            ? '<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">Pemasukan</span>' 
                            : '<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs">Pengeluaran</span>'
                        }
                        
                    </td>
                    <td class="text-sm text-gray-600">${reason}</td>
                    <td class="${isAdd ? 'text-green-600' : 'text-red-600'} font-semibold">
                        ${isAdd ? '+' : '-'}Rp ${formattedAmount}
                    </td>
                `;
                
                tableBody.appendChild(row);
            });
        }

        // Fungsi untuk memuat data
        function loadCashHistory() {
            const outletId = document.getElementById('outlet_id').value; // Pastikan ada input outlet_id di form
            
            fetch(`/cash-register-transactions/history?outlet_id=${outletId}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        renderCashHistory(result.data);
                    } else {
                        console.error('Error:', result.message);
                        renderCashHistory([]);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    renderCashHistory([]);
                });
        }

        // Load data saat halaman dimuat
        fetchCashHistory(outletId);
    });
</script>

@endsection