<!-- History Modal -->
<div id="historyModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute w-full h-full bg-gray-900 opacity-50" onclick="closeModal('historyModal')"></div>
    <div class="bg-white w-11/12 md:max-w-6xl mx-auto rounded shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="p-8 text-[16px]"> <!-- Lebihkan padding dan ukuran teks -->
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">Riwayat Transaksi</h2>
                    <p class="text-base text-gray-600">Lihat riwayat transaksi berdasarkan tanggal</p>
                </div>
                <button onclick="closeModal('historyModal')" class="text-gray-500 hover:text-red-500 text-2xl">✕</button>
            </div>

            <!-- Date Range & Search -->
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <div class="relative w-full md:w-1/2">
                    <input id="dateRange" type="text" class="border p-3 rounded w-full pl-12 text-base" placeholder="Pilih rentang tanggal" readonly />
                    <div class="absolute left-4 top-3.5 text-gray-400">
                        <!-- Calendar icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full md:w-1/2">
                    <input 
                        id="searchInvoice" 
                        type="text" 
                        placeholder="Cari transaksi berdasarkan invoice..." 
                        class="border p-3 rounded w-full pl-12 text-base"
                        oninput="filterTransactions()"
                    />
                    <div class="absolute left-4 top-3.5 text-gray-400">
                        <!-- Search icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Summary -->
            <div class="bg-orange-50 p-4 rounded mb-6 flex justify-between items-center text-base">
                <div id="summaryText">
                    <span class="font-semibold text-lg">Total Transaksi 1 Mei 2025 - 12 Mei 2025</span><br>
                    <span class="text-gray-500 text-sm">0 transaksi</span>
                </div>
                <div class="text-orange-600 font-bold text-2xl" id="totalAmount">Rp 0</div>
            </div>

            <!-- Transaction Table -->
            <div class="overflow-auto border border-gray-200 rounded-md">
                <table class="w-full text-base text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Invoice</th>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Kasir</th>
                            <th class="p-3">Pembayaran</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Total</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTable">
                        <tr class="border-t border-gray-200">
                            <td colspan="7" class="text-center py-6 text-gray-500">Tidak ada transaksi pada tanggal ini.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Close Button -->
            <div class="flex justify-end pt-6">
                <button onclick="closeModal('historyModal')" class="px-5 py-3 text-base bg-orange-500 text-white rounded hover:bg-orange-600 transition">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    // Sample transaction data (replace with real data from your backend)
    const transactions = [
        {
            invoice: "INV-20250501-001",
            waktu: "1 Mei 2025, 10:15",
            kasir: "Budi",
            pembayaran: "Tunai",
            status: "Selesai",
            total: 125000,
            date: "2025-05-01"
        },
        {
            invoice: "INV-20250503-002",
            waktu: "3 Mei 2025, 14:30",
            kasir: "Ani",
            pembayaran: "Debit",
            status: "Selesai",
            total: 87500,
            date: "2025-05-03"
        },
        {
            invoice: "INV-20250505-003",
            waktu: "5 Mei 2025, 09:45",
            kasir: "Budi",
            pembayaran: "QRIS",
            status: "Selesai",
            total: 210000,
            date: "2025-05-05"
        },
        {
            invoice: "INV-20250510-004",
            waktu: "10 Mei 2025, 16:20",
            kasir: "Citra",
            pembayaran: "Kredit",
            status: "Selesai",
            total: 156000,
            date: "2025-05-10"
        },
        {
            invoice: "INV-20250512-005",
            waktu: "12 Mei 2025, 11:05",
            kasir: "Ani",
            pembayaran: "Tunai",
            status: "Selesai",
            total: 98000,
            date: "2025-05-12"
        }
    ];

    // Initialize date range picker
    const dateRangePicker = flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["2025-05-01", "2025-05-12"],
        locale: "id",
        onChange: function(selectedDates, dateStr, instance) {
            updateTransactionView();
        }
    });

    // Function to filter transactions based on date range and search keyword
    function filterTransactions() {
        updateTransactionView();
    }

    // Main function to update the transaction view
    function updateTransactionView() {
        const tbody = document.getElementById("transactionTable");
        const totalAmount = document.getElementById("totalAmount");
        const summaryText = document.getElementById("summaryText");
        const searchKeyword = document.getElementById("searchInvoice").value.toLowerCase();
        
        // Get selected date range
        const selectedDates = dateRangePicker.selectedDates;
        let startDate = null;
        let endDate = null;
        
        if (selectedDates.length === 2) {
            startDate = new Date(selectedDates[0]);
            endDate = new Date(selectedDates[1]);
            // Set end date to end of day
            endDate.setHours(23, 59, 59, 999);
        }

        // Filter transactions
        const filtered = transactions.filter(t => {
            // Filter by date range if selected
            if (startDate && endDate) {
                const transactionDate = new Date(t.date);
                if (transactionDate < startDate || transactionDate > endDate) {
                    return false;
                }
            }
            
            // Filter by search keyword
            if (searchKeyword && !t.invoice.toLowerCase().includes(searchKeyword)) {
                return false;
            }
            
            return true;
        });

        // Update table content
        tbody.innerHTML = filtered.length
            ? filtered.map((t, i) => `
                <tr class="hover:bg-gray-50">
                    <td class="p-2 border">${i + 1}</td>
                    <td class="p-2 border font-mono">${t.invoice}</td>
                    <td class="p-2 border">${t.waktu}</td>
                    <td class="p-2 border">${t.kasir}</td>
                    <td class="p-2 border">${t.pembayaran}</td>
                    <td class="p-2 border">
                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">${t.status}</span>
                    </td>
                    <td class="p-2 border font-medium">Rp ${t.total.toLocaleString('id-ID')}</td>
                </tr>
            `).join("")
            : `<tr><td colspan="7" class="text-center py-4 text-gray-500">Tidak ada transaksi yang sesuai dengan kriteria.</td>`;

        // Update summary
        const total = filtered.reduce((sum, t) => sum + t.total, 0);
        totalAmount.textContent = "Rp " + total.toLocaleString('id-ID');
        
        // Update date range text
        if (selectedDates.length === 2) {
            const startStr = selectedDates[0].toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            const endStr = selectedDates[1].toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            summaryText.innerHTML = `Total Transaksi ${startStr} - ${endStr}<br><span class="text-gray-500 text-xs">${filtered.length} transaksi</span>`;
        } else {
            summaryText.innerHTML = `Total Semua Transaksi<br><span class="text-gray-500 text-xs">${filtered.length} transaksi</span>`;
        }
    }

    // Close modal function
    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }

    // Initialize the view when page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateTransactionView();
    });
</script>