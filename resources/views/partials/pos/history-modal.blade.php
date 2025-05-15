<!-- History Modal -->
<div id="historyModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute w-full h-full bg-gray-900 opacity-50" onclick="tutupModal('historyModal')"></div>
    <div class="bg-white w-11/12 md:max-w-6xl mx-auto rounded shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="p-8 text-[16px]">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">Riwayat Transaksi</h2>
                    <p class="text-base text-gray-600">Lihat riwayat transaksi berdasarkan tanggal</p>
                </div>
                <button onclick="tutupModal('historyModal')" class="text-gray-500 hover:text-red-500 text-2xl">✕</button>
            </div>

            <!-- Date Range & Search -->
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <div class="relative w-full md:w-1/2">
                    <input id="dateRange" type="text" class="border p-3 rounded w-full pl-12 text-base" placeholder="Pilih rentang tanggal" readonly />
                    <div class="absolute left-4 top-3.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="relative w-full md:w-1/2">
                    <input 
                        id="searchInvoice" 
                        type="text" 
                        placeholder="Cari transaksi berdasarkan nomor invoice..." 
                        class="border p-3 rounded w-full pl-12 text-base"
                        oninput="filterTransaksi()"
                    />
                    <div class="absolute left-4 top-3.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Summary -->
            <div class="bg-orange-50 p-4 rounded mb-6 flex justify-between items-center text-base">
                <div id="summaryText">
                    <span class="font-semibold text-lg">Total Transaksi</span><br>
                    <span class="text-gray-500 text-sm">Memuat data...</span>
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
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTable">
                        <tr class="border-t border-gray-200">
                            <td colspan="8" class="text-center py-6 text-gray-500">Memuat data transaksi...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Close Button -->
            <div class="flex justify-end pt-6">
                <button onclick="tutupModal('historyModal')" class="px-5 py-3 text-base bg-orange-500 text-white rounded hover:bg-orange-600 transition">Tutup</button>
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
     // Variabel global untuk menyimpan data transaksi
    let semuaTransaksi = [];
    let sedangMemuat = false;
    const BASE_URL = 'http://127.0.0.1:8000/api'; // Sesuaikan dengan base URL API Anda

    // Inisialisasi date range picker
    const dateRangePicker = flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d M Y",
        locale: "id",
        onChange: function(tanggalTerpilih) {
            if (tanggalTerpilih.length === 2) {
                ambilDataTransaksi(tanggalTerpilih[0], tanggalTerpilih[1]);
            } else {
                ambilDataTransaksi();
            }
        }
    });

    // Fungsi untuk mengambil data transaksi dari backend
    async function ambilDataTransaksi(tanggalMulai = null, tanggalSampai = null) {
        try {
            sedangMemuat = true;
            document.getElementById("transactionTable").innerHTML = `
                <tr class="border-t border-gray-200">
                    <td colspan="8" class="text-center py-6 text-gray-500">Sedang memuat data...</td>
                </tr>
            `;

            // Membuat URL endpoint dengan parameter
            let url = BASE_URL + '/orders/history';
            const params = new URLSearchParams();
            
            if (tanggalMulai && tanggalSampai) {
                params.append('date_from', formatTanggalUntukBackend(tanggalMulai));
                params.append('date_to', formatTanggalUntukBackend(tanggalSampai));
            }
            
            if (params.toString()) {
                url += `?${params.toString()}`;
            }

            // Ambil token dari localStorage atau meta tag
            const token = localStorage.getItem('token') || document.querySelector('meta[name="csrf-token"]').content;

            // Mengambil data dari backend
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': `Bearer ${token}`
                }
            });

            // Cek jika response tidak OK
            if (!response.ok) {
                throw new Error(`Gagal mengambil data: ${response.status} ${response.statusText}`);
            }

            const data = await response.json();
            
            // Jika sukses, proses data
            if (data.success) {
                semuaTransaksi = data.data.orders.map(transaksi => ({
                    id: transaksi.id,
                    invoice: transaksi.order_number,
                    waktu: transaksi.created_at,
                    kasir: transaksi.user,
                    pembayaran: transaksi.payment_method,
                    status: transaksi.status === 'completed' ? 'Selesai' : 
                           transaksi.status === 'canceled' ? 'Dibatalkan' : transaksi.status,
                    total: parseFloat(transaksi.total),
                    date: transaksi.created_at.split(' ')[0],
                    items: transaksi.items,
                    outlet: transaksi.outlet,
                    member: transaksi.member
                }));
                
                perbaruiTampilanTransaksi();
                perbaruiRingkasan(data.data);
            } else {
                throw new Error(data.message || 'Gagal memuat data transaksi');
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById("transactionTable").innerHTML = `
                <tr class="border-t border-gray-200">
                    <td colspan="8" class="text-center py-6 text-red-500">${error.message}</td>
                </tr>
            `;
            document.getElementById("summaryText").innerHTML = `
                <span class="font-semibold text-lg">Gagal memuat data</span><br>
                <span class="text-gray-500 text-sm">${error.message}</span>
            `;
        } finally {
            sedangMemuat = false;
        }
    }

    // Fungsi untuk memfilter transaksi berdasarkan pencarian
    function filterTransaksi() {
        if (sedangMemuat) return;
        perbaruiTampilanTransaksi();
    }

    // Fungsi utama untuk memperbarui tampilan tabel transaksi
    function perbaruiTampilanTransaksi() {
        const tabelBody = document.getElementById("transactionTable");
        const kataKunciPencarian = document.getElementById("searchInvoice").value.toLowerCase();
        
        // Filter transaksi berdasarkan kata kunci
        const transaksiTertampil = semuaTransaksi.filter(transaksi => {
            if (kataKunciPencarian && !transaksi.invoice.toLowerCase().includes(kataKunciPencarian)) {
                return false;
            }
            return true;
        });

        // Perbarui isi tabel
        tabelBody.innerHTML = transaksiTertampil.length
            ? transaksiTertampil.map((transaksi, index) => `
                <tr class="hover:bg-gray-50">
                    <td class="p-2 border">${index + 1}</td>
                    <td class="p-2 border font-mono">${transaksi.invoice}</td>
                    <td class="p-2 border">${formatWaktu(transaksi.waktu)}</td>
                    <td class="p-2 border">${transaksi.kasir}</td>
                    <td class="p-2 border">${transaksi.pembayaran}</td>
                    <td class="p-2 border">
                        <span class="px-2 py-1 rounded-full text-xs ${getClassStatus(transaksi.status)}">
                            ${transaksi.status}
                        </span>
                    </td>
                    <td class="p-2 border font-medium">Rp ${formatUang(transaksi.total)}</td>
                    <td class="p-2 border">
                        <button onclick="lihatDetail('${transaksi.invoice}')" class="text-blue-500 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            `).join("")
            : `<tr><td colspan="8" class="text-center py-4 text-gray-500">Tidak ada transaksi yang sesuai.</td>`;
    }

    // Fungsi untuk memperbarui ringkasan
    function perbaruiRingkasan(data) {
        const totalAmount = document.getElementById("totalAmount");
        const summaryText = document.getElementById("summaryText");
        
        totalAmount.textContent = "Rp " + formatUang(data.total_revenue || 0);
        
        let teksTanggal = "Semua Transaksi";
        if (data.date_from && data.date_to) {
            teksTanggal = `${data.date_from} - ${data.date_to}`;
        }
        
        summaryText.innerHTML = `
            <span class="font-semibold text-lg">Total Transaksi ${teksTanggal}</span><br>
            <span class="text-gray-500 text-sm">${data.total_orders || 0} transaksi</span>
        `;
    }

    // Fungsi untuk menutup modal
    function tutupModal(id) {
        document.getElementById(id).classList.add("hidden");
    }

    // Fungsi untuk membuka modal
    function bukaModal(id) {
        document.getElementById(id).classList.remove("hidden");
        // Ambil data saat modal dibuka jika belum ada data
        if (semuaTransaksi.length === 0) {
            ambilDataTransaksi();
        }
    }

    // ===== FUNGSI BANTUAN =====

    // Format tanggal untuk backend (YYYY-MM-DD)
    function formatTanggalUntukBackend(tanggal) {
        const tahun = tanggal.getFullYear();
        const bulan = String(tanggal.getMonth() + 1).padStart(2, '0');
        const hari = String(tanggal.getDate()).padStart(2, '0');
        return `${tahun}-${bulan}-${hari}`;
    }

    // Format waktu tampilan (DD Bulan YYYY, HH:MM)
    function formatWaktu(waktuStr) {
        if (!waktuStr) return '';
        
        // Format dari backend: "d/m/Y H:i" (15/05/2025 14:30)
        const [tanggal, jam] = waktuStr.split(' ');
        const [hari, bulan, tahun] = tanggal.split('/');
        
        const namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        return `${parseInt(hari)} ${namaBulan[parseInt(bulan) - 1]} ${tahun}, ${jam}`;
    }

    // Format uang (1.000.000)
    function formatUang(jumlah) {
        return jumlah ? jumlah.toLocaleString('id-ID') : '0';
    }

    // Dapatkan class CSS berdasarkan status
    function getClassStatus(status) {
        switch (status.toLowerCase()) {
            case 'selesai': return 'bg-green-100 text-green-800';
            case 'dibatalkan': return 'bg-red-100 text-red-800';
            case 'pending': return 'bg-yellow-100 text-yellow-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }

    // Fungsi untuk melihat detail transaksi
    function lihatDetail(nomorInvoice) {
        const transaksi = semuaTransaksi.find(t => t.invoice === nomorInvoice);
        if (transaksi) {
            alert(`Detail Transaksi:\n\nInvoice: ${transaksi.invoice}\nTanggal: ${formatWaktu(transaksi.waktu)}\nKasir: ${transaksi.kasir}\nMetode Bayar: ${transaksi.pembayaran}\nTotal: Rp ${formatUang(transaksi.total)}\nStatus: ${transaksi.status}`);
        }
    }

    // Event listener untuk modal
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan CSRF token ada
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = '{{ csrf_token() }}';
            document.head.appendChild(meta);
        }
    });
</script>