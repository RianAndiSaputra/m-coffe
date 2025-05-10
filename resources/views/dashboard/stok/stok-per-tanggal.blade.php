@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert akan muncul di sini secara dinamis -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-3xl font-bold text-gray-800">Manajemen Stok</h1>
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
            </span>
            <input type="text" placeholder="Pencarian..."
                class="w-full pl-10 pr-4 py-3 border rounded-lg text-base font-medium focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" />
        </div>
    </div>
</div>

<!-- Card: Stok Info + Aksi -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Judul -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="package" class="w-5 h-5 text-black mt-1"></i>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Menampilkan stok untuk: Kifa Bakery Pusat</h2>
            <p id="reportDate" class="text-sm text-gray-600">Data stok per tanggal <span class="font-medium">{{ date('d M Y') }}</span></p>
        </div>
    </div>
</div>

<!-- Card: Tabel Laporan Stok -->
<div class="bg-white rounded-lg shadow-lg p-6">
   <div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800">Custom Stok Per Tanggal</h1>
    <p class="text-sm text-gray-600 mb-2">Lihat stok pada tanggal tertentu untuk Kifa Bakery Pusat</p>

    <!-- Filter Tanggal -->
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
    <div class="overflow-x-auto">
        <table class="w-full text-base">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Produk</th>
                    <th class="py-3 font-bold">Kategori</th>
                    <th class="py-3 font-bold">Stok</th>
                    <th class="py-3 font-bold">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <!-- Produk 1 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="croissant" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Roti Coklat Keju</span>
                                <span class="text-xs text-gray-500">KFB-001</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-medium">Roti Manis</td>
                    <td class="py-4 font-bold text-orange-600">25</td>
                    <td class="py-4">
                        <span class="px-3 py-1 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">Aman</span>
                    </td>
                </tr>

                <!-- Produk 2 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cake" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Black Forest</span>
                                <span class="text-xs text-gray-500">KFB-002</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-medium">Kue Ulang Tahun</td>
                    <td class="py-4 font-bold text-orange-600">12</td>
                    <td class="py-4">
                        <span class="px-3 py-1 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">Perhatian</span>
                    </td>
                </tr>

                <!-- Produk 3 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cookie" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Kastengel</span>
                                <span class="text-xs text-gray-500">KFB-003</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-medium">Kue Kering</td>
                    <td class="py-4 font-bold text-orange-600">3</td>
                    <td class="py-4">
                        <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Habis</span>
                    </td>
                </tr>

                <!-- Produk 4 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="cupcake" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Donat Coklat</span>
                                <span class="text-xs text-gray-500">KFB-004</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-medium">Donat</td>
                    <td class="py-4 font-bold text-orange-600">48</td>
                    <td class="py-4">
                        <span class="px-3 py-1 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">Aman</span>
                    </td>
                </tr>

                <!-- Produk 5 -->
                <tr>
                    <td class="py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-md bg-orange-100 flex items-center justify-center">
                                <i data-lucide="bread" class="w-5 h-5 text-orange-500"></i>
                            </div>
                            <div>
                                <span class="font-semibold block">Roti Tawar Gandum</span>
                                <span class="text-xs text-gray-500">KFB-005</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 font-medium">Roti Tawar</td>
                    <td class="py-4 font-bold text-orange-600">13</td>
                    <td class="py-4">
                        <span class="px-3 py-1 text-xs font-bold bg-orange-100 text-orange-700 rounded-full">Perhatian</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Inisialisasi flatpickr
    flatpickr("#reportDateInput", {
        dateFormat: "d M Y",
        defaultDate: "today",
        onChange: function(selectedDates, dateStr) {
            updateReportDateRange(dateStr);
            filterStokByDate(dateStr); // Panggil fungsi filter (kalau ada)
        },
        locale: {
            firstDayOfWeek: 1 // Senin sebagai awal minggu
        }
    });

    // Ubah tampilan tanggal di bawah judul
    function updateReportDateRange(dateStr) {
        const display = document.getElementById('reportDateRange');
        if (display) {
            display.textContent = `Menampilkan stok per tanggal ${dateStr}`;
        }
    }

    // Panggil fungsi ini saat halaman siap
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('reportDateInput');
        if (input) {
            const flatpickrInstance = input._flatpickr;
            if (flatpickrInstance) {
                updateReportDateRange(flatpickrInstance.input.value);
            }
        }
    });

    // Placeholder fungsi filter jika belum ada
    function filterStokByDate(date) {
        console.log("Filter stok berdasarkan tanggal:", date);
        // Tambahkan logika filter sesuai kebutuhan di sini
    }
</script>

@endsection