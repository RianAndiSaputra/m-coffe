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
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">Outlet Aktif: Kifa Bakery Pusat</h2>
            <p class="text-sm text-gray-600">Data riwayat transaksi kas untuk outlet Kifa Bakery Pusat.</p>
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
            <tbody class="text-gray-700 divide-y">
                <!-- Contoh Riwayat -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">Admin</td>
                    <td class="py-4">10:00:12</td>
                    <td>
                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs">Pemasukan</span>
                    </td>
                    <td class="text-sm text-gray-600">Penjualan Harian</td>
                    <td class="text-green-600 font-semibold">+Rp 150.000</td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4">Admin</td>
                    <td class="py-4">09:30:00</td>
                    <td>
                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs">Pengeluaran</span>
                    </td>
                    <td class="text-sm text-gray-600">Pembelian Gas</td>
                    <td class="text-red-600 font-semibold">-Rp 50.000</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between mt-4">
        <div class="text-sm text-gray-600">
            Menampilkan 1 sampai 2 dari 10 entri
        </div>
        <div class="flex space-x-1">
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">Previous</button>
            <button class="px-3 py-1 border rounded text-sm bg-orange-600 text-white hover:bg-orange-700">1</button>
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border rounded text-sm hover:bg-gray-50">Next</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr("#cashDateInput", {
        dateFormat: "d M Y",
        defaultDate: "today",
        onChange: function(selectedDates, dateStr) {
            updateCashDateDisplay(dateStr);
            filterCashByDate(dateStr);
        },
        locale: {
            firstDayOfWeek: 1
        }
    });

    function updateCashDateDisplay(dateStr) {
        console.log(`Tanggal dipilih: ${dateStr}`);
    }

    function filterCashByDate(date) {
        console.log("Filter kas berdasarkan tanggal:", date);
        // Tambahkan logika filter di sini
    }
</script>

@endsection