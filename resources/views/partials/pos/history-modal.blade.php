<!-- History Modal -->
<div id="historyModal" class="fixed inset-0 z-50 hidden">
    <!-- Overlay -->
    <div class="absolute w-full h-full bg-gray-900 opacity-50" onclick="tutupModal('historyModal')"></div>

    <!-- Modal Box -->
    <div class="bg-white w-[95%] md:w-11/12 md:max-w-6xl mx-auto rounded shadow-lg z-50 relative mt-10 mb-10 max-h-[90vh] flex flex-col">
        
        <!-- Header (Fixed inside modal) -->
        <div class="p-4 md:p-6 border-b sticky top-0 bg-white z-10">
            <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-2">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold">Riwayat Transaksi</h2>
                    <p class="text-sm md:text-base text-gray-600">Lihat riwayat transaksi berdasarkan tanggal</p>
                </div>
                <button onclick="tutupModal('historyModal')" class="text-gray-500 hover:text-red-500 text-xl md:text-2xl">✕</button>
            </div>
        </div>

        <!-- Body Scrollable -->
        <div class="overflow-y-auto px-4 md:px-8 py-6 flex-1">
            <!-- Date Range & Search -->
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <div class="relative w-full md:w-1/2">
                    <input id="dateRange" type="text" class="border p-3 rounded w-full pl-12 text-base" placeholder="Pilih rentang tanggal" readonly />
                    <div class="absolute left-4 top-3.5 text-gray-400">
                        <!-- Calendar Icon -->
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
                        <!-- Search Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-orange-50 p-4 rounded mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0">
                <div id="summaryText">
                    <span class="font-semibold text-lg">Total Transaksi</span><br>
                    <span class="text-gray-500 text-sm">Memuat data...</span>
                </div>
                <div class="text-orange-600 font-bold text-2xl" id="totalAmount">Rp 0</div>
            </div>

            <!-- Table -->
            <div class="overflow-auto border border-gray-200 rounded-md">
                <table class="w-full text-sm md:text-base text-left">
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
        </div>

        <!-- Footer (Fixed inside modal) -->
        <div class="border-t p-4 md:p-6 bg-white sticky bottom-0 z-10">
            <div class="flex justify-end">
                <button onclick="tutupModal('historyModal')" class="px-5 py-3 text-base bg-orange-500 text-white rounded hover:bg-orange-600 transition">Tutup</button>
            </div>
        </div>

        @include('partials.pos.modal.modal-history-transaksi')
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
    // const BASE_URL = 'http://127.0.0.1:8000/api'; // Sesuaikan dengan base URL API Anda
    // const API_BASE_URL = 'http://127.0.0.1:8000/api';


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
            let url = '/api/orders/history';
            const params = new URLSearchParams();
            
            if (tanggalMulai && tanggalSampai) {
                params.append('date_from', formatTanggalUntukBackend(tanggalMulai));
                params.append('date_to', formatTanggalUntukBackend(tanggalSampai));
            }

            const outletId = localStorage.getItem('outlet_id');
            if (outletId) {
                params.append('outlet_id', outletId);
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
                // Konversi order_number menjadi invoice untuk konsistensi
                semuaTransaksi = data.data.orders.map(transaksi => ({
                    id: transaksi.id,
                    invoice: transaksi.order_number,  // Menggunakan order_number sebagai invoice
                    waktu: transaksi.created_at,      // Menggunakan created_at sebagai waktu
                    kasir: transaksi.user,
                    pembayaran: transaksi.payment_method,
                    status: transaksi.status === 'completed' ? 'Selesai' : 
                            transaksi.status === 'canceled' ? 'Dibatalkan' : transaksi.status,
                    total: parseFloat(transaksi.total),
                    date: transaksi.created_at.split(' ')[0],
                    items: transaksi.items,
                    outlet: transaksi.outlet,
                    outlet_id: transaksi.outlet_id,
                    member: transaksi.member,
                    // Tambahkan properti lain yang dibutuhkan
                    subtotal: parseFloat(transaksi.subtotal || 0),
                    tax: parseFloat(transaksi.tax || 0),
                    discount: parseFloat(transaksi.discount || 0),
                    total_paid: parseFloat(transaksi.total_paid || 0),
                    change: parseFloat(transaksi.change || 0),
                }));
                
                perbaruiTampilanTransaksi();
                perbaruiRingkasan({
                    date_from: data.data.date_from,
                    date_to: data.data.date_to,
                    total_orders: data.data.total_orders,
                    total_revenue: parseFloat(data.data.total_revenue),
                    total_discount: parseFloat(data.data.total_discount),
                    average_order_value: data.data.average_order_value,
                    total_items_sold: data.data.total_items_sold,
                    gross_sales: parseFloat(data.data.gross_sales),
                });
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
                        <button onclick="cetakStruk('${transaksi.invoice}')" class="text-green-500 hover:text-green-700" title="Cetak Struk">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            `).join("")
            : `<tr><td colspan="8" class="text-center py-4 text-gray-500">Tidak ada transaksi yang sesuai.</td>`;
    }

    // Fungsi untuk mencetak struk
    async function cetakStruk(nomorInvoice) {
        try {
            const transaksi = semuaTransaksi.find(t => t.invoice === nomorInvoice);
            if (!transaksi) {
                throw new Error('Transaksi tidak ditemukan');
            }
            
            // Debug untuk memeriksa struktur data transaksi
            console.log('DEBUG TRANSAKSI:', transaksi);

            // Ambil token dari localStorage atau meta tag
            const token = localStorage.getItem('token') || document.querySelector('meta[name="csrf-token"]').content;

            // Periksa dan ambil outlet_id dengan lebih teliti
            // Coba dapatkan dari objek transaksi terlebih dahulu
            let outletId = null;
            
            if (transaksi.outlet && transaksi.outlet.id) {
                // Jika ada objek outlet dengan id
                outletId = transaksi.outlet.id;
            } else if (transaksi.outlet_id) {
                // Jika outlet_id tersedia langsung
                outletId = transaksi.outlet_id;
            } else {
                // Fallback ke localStorage jika tidak ada di transaksi
                outletId = localStorage.getItem('outlet_id');
            }

            console.log('DEBUG outletId yang digunakan:', outletId);

            if (!outletId) {
                throw new Error('Outlet ID tidak ditemukan. Pastikan Anda telah memilih outlet.');
            }

            // Ambil data template cetak dari endpoint
            const response = await fetch(`/api/print-template/${outletId}`, {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) {
                throw new Error(`Gagal mengambil template cetak: ${response.status}`);
            }

            const responseData = await response.json();
            
            if (!responseData.success) {
                throw new Error(responseData.message || 'Gagal memuat template cetak');
            }

            const templateData = responseData.data;

            // Buka jendela cetak
            const printWindow = window.open('', '_blank', 'width=400,height=600');

            if (printWindow) {
                const receiptContent = generateReceiptContent(transaksi, templateData);
                
                printWindow.document.open();
                printWindow.document.write(receiptContent);
                printWindow.document.close();

                printWindow.onload = function() {
                    printWindow.print();
                    // printWindow.close(); // Opsional: tutup setelah cetak
                };
            } else {
                throw new Error('Gagal membuka jendela cetak. Periksa pengaturan popup browser Anda.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`Gagal mencetak struk: ${error.message}`);
        }
    }

    // Fungsi untuk generate konten struk (dengan perbaikan)
    function generateReceiptContent(transaction, templateData) {
        // Format tanggal lebih baik
        const formatDate = (dateString) => {
            if (!dateString) return '';
            const options = { 
                day: '2-digit', 
                month: 'long', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        };

        // Helper function untuk menangani nilai yang mungkin undefined
        const safeNumber = (value) => {
            // Memastikan nilai adalah angka yang valid
            return typeof value === 'number' && !isNaN(value) ? value : 0;
        };

        // Helper function untuk format uang dengan penanganan nilai undefined
        const formatCurrency = (value) => {
            return safeNumber(value).toLocaleString('id-ID');
        };

        // Pastikan properti-properti yang dibutuhkan ada, atau beri nilai default
        const subtotal = safeNumber(transaction.subtotal);
        const discount = safeNumber(transaction.discount);
        const tax = safeNumber(transaction.tax);
        const total = safeNumber(transaction.total);
        const total_paid = safeNumber(transaction.total_paid);
        const change = safeNumber(transaction.change);

        console.log("DEBUG nilai-nilai transaksi:", {
            subtotal, discount, tax, total, total_paid, change,
            items: transaction.items
        });

        return `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Struk Transaksi #${transaction.invoice}</title>
                <style>
                    body {
                        font-family: 'Courier New', monospace;
                        margin: 0;
                        padding: 20px;
                        max-width: 300px;
                    }
                    .header {
                        display: flex;
                        align-items: center;
                        gap: 15px;
                        margin-bottom: 20px;
                    }
                    .header-text {
                        flex: 1;
                        text-align: right;
                    }
                    .logo-container {
                        display: flex;
                        align-items: center;
                    }
                    .logo {
                        max-width: 50px;
                        height: auto;
                    }
                    .title {
                        font-size: 16px;
                        font-weight: bold;
                        margin-bottom: 4px;
                    }
                    .info {
                        font-size: 12px;
                        margin: 5px 0;
                    }
                    .divider {
                        border-top: 1px dashed #000;
                        margin: 10px 0;
                    }
                    .item {
                        display: flex;
                        justify-content: space-between;
                        font-size: 12px;
                        margin: 5px 0;
                    }
                    .total {
                        font-weight: bold;
                        margin-top: 10px;
                        text-align: right;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        font-size: 12px;
                    }
                    .text-center {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    ${templateData.logo_url ? `
                    <div class="logo-container">
                        <img src="${templateData.logo_url || 'logo'}" 
                            alt="Logo Outlet" 
                            class="logo"
                            onerror="this.style.display='none'"/>
                    </div>
                    ` : ''}
                    <div class="header-text">
                        <div class="title">${templateData.company_name || 'Toko Saya'}</div>
                        ${templateData.company_slogan ? `<div class="info">${templateData.company_slogan}</div>` : ''}
                        ${templateData.outlet ? `
                            <div class="info">${templateData.outlet.name || ''}</div>
                            <div class="info">Alamat: ${templateData.outlet.address || ''}</div>
                            <div class="info">Telp: ${templateData.outlet.phone || ''}</div>
                        ` : ''}
                    </div>
                </div>

                <div class="divider"></div>
                <div class="text-center">
                    <div class="info">STRUK PEMBAYARAN</div>
                </div>
                <div class="divider"></div>
                
                <div class="info">No. Invoice: ${transaction.invoice}</div>
                <div class="info">Tanggal: ${formatDate(transaction.waktu)}</div>
                <div class="info">Kasir: ${transaction.kasir}</div>
                <div class="divider"></div>
                
                <div>
                    ${transaction.items && transaction.items.length > 0 ? transaction.items.map(item => {
                        // Pastikan setiap properti item ada dan valid
                        const quantity = safeNumber(item.quantity);
                        const price = safeNumber(item.price);
                        const itemDiscount = safeNumber(item.discount);
                        
                        return `
                            <div class="item">
                                <div>${quantity}x ${item.product || 'Produk'}</div>
                                <div>
                                    Rp ${formatCurrency(price * quantity)}
                                    ${itemDiscount > 0 ? ` (-${formatCurrency(itemDiscount)})` : ''}
                                </div>
                            </div>
                        `;
                    }).join('') : '<div class="item">Tidak ada item</div>'}
                    
                    <div class="divider"></div>
                    <div class="item">
                        <div>Subtotal:</div>
                        <div>Rp ${formatCurrency(subtotal)}</div>
                    </div>
                    
                    ${discount > 0 ? `
                    <div class="item">
                        <div>Diskon:</div>
                        <div>Rp -${formatCurrency(discount)}</div>
                    </div>
                    ` : ''}
                    
                    ${tax > 0 ? `
                    <div class="item">
                        <div>Pajak:</div>
                        <div>Rp ${formatCurrency(tax)}</div>
                    </div>
                    ` : ''}
                    
                    <div class="item">
                        <div>Total:</div>
                        <div>Rp ${formatCurrency(total)}</div>
                    </div>
                    
                    <div class="item">
                        <div>Metode Pembayaran:</div>
                        <div>${transaction.pembayaran === "cash" ? "TUNAI" : 
                            transaction.pembayaran === "qris" ? "QRIS" : 
                            (transaction.pembayaran || 'TIDAK DIKETAHUI').toUpperCase()}</div>
                    </div>
                    
                    ${transaction.pembayaran === 'cash' ? `
                    <div class="item">
                        <div>Bayar:</div>
                        <div>Rp ${formatCurrency(total_paid)}</div>
                    </div>
                    <div class="item">
                        <div>Kembalian:</div>
                        <div>Rp ${formatCurrency(change)}</div>
                    </div>
                    ` : ''}
                </div>
                
                <div class="divider"></div>
                ${transaction.member ? `
                    <div class="info">
                        Member: ${transaction.member.name || ''} (${transaction.member.member_code || ''})
                    </div>
                ` : ''}
                
                <div class="footer">
                    ${templateData.footer_message || 'Terima kasih atas kunjungan Anda'}
                </div>
            </body>
            </html>
        `;
    }

    // Fungsi untuk memperbarui ringkasan
    function perbaruiRingkasan(r) {
        document.getElementById("totalAmount")
            .textContent = "Rp " + formatUang(r.total_revenue);
        
        let teksTanggal = "Semua Transaksi";
        if (r.date_from && r.date_to) {
            teksTanggal = `${r.date_from} – ${r.date_to}`;
        }

        document.getElementById("summaryText").innerHTML = `
            <span class="font-semibold text-lg">Total Transaksi ${teksTanggal}</span><br>
            <span class="text-gray-500 text-sm">${r.total_orders} transaksi</span>
        `;
    }

    function bukaModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
        
    function tutupModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function lihatDetail(nomorInvoice) {
        const t = semuaTransaksi.find(x => x.invoice === nomorInvoice);
        console.log('DEBUG bukaModalDetail t =', t);
        if (!t) return alert('Transaksi tidak ditemukan');

        // Sebelum mengakses properti, pastikan nilai numerik aman dengan helper function
        const safeNumber = (value) => {
            // Jika nilai adalah string dengan format angka, konversi ke float
            if (typeof value === 'string' && !isNaN(value)) {
                return parseFloat(value);
            }
            // Jika nilai sudah berupa angka, langsung kembalikan
            else if (typeof value === 'number' && !isNaN(value)) {
                return value;
            }
            // Untuk nilai lain (undefined, null, NaN, dll), kembalikan 0
            return 0;
        };

        // Header
        document.getElementById('modalInvoice').textContent = t.invoice || t.order_number || '-';
        document.getElementById('modalDate').textContent = formatWaktu(t.waktu || t.created_at || '');
        
        const statusEl = document.getElementById('modalStatus');
        statusEl.textContent = t.status || '-';
        statusEl.className = `inline-block px-3 py-1 rounded-full text-xs font-medium ${getClassStatus(t.status || '')}`;

        // Items
        const itemsEl = document.getElementById('modalItems');
        if (t.items && t.items.length > 0) {
            itemsEl.innerHTML = t.items.map(i => `
                <tr>
                    <td class="px-3 py-2">${i.product || '-'}</td>
                    <td class="px-3 py-2">${i.quantity || 0}x</td>
                    <td class="px-3 py-2">Rp ${formatUang(safeNumber(i.price))}</td>
                    <td class="px-3 py-2">Rp ${formatUang(safeNumber(i.price) * safeNumber(i.quantity))}</td>
                </tr>
            `).join('');
        } else {
            itemsEl.innerHTML = `
                <tr>
                    <td colspan="4" class="px-3 py-2 text-center text-gray-500">Tidak ada item</td>
                </tr>
            `;
        }

        // **Ringkasan Harga**
        // Pastikan nilai numeric diproses dengan benar
        document.getElementById('modalSubtotal').textContent = `Rp ${formatUang(safeNumber(t.subtotal))}`;
        document.getElementById('modalTax').textContent = `Rp ${formatUang(safeNumber(t.tax))}`;
        document.getElementById('modalDiscount').textContent = `Rp ${formatUang(safeNumber(t.discount))}`;

        // **Total**
        document.getElementById('modalTotal').textContent = `Rp ${formatUang(safeNumber(t.total))}`;

        // **Pembayaran & Kembalian**
        // Periksa metode pembayaran dan tampilkan total_paid/change sesuai
        const pembayaranEl = document.getElementById('modalPaymentMethod');
        if (pembayaranEl) {
            pembayaranEl.textContent = (t.pembayaran || t.payment_method || '-').toUpperCase();
        }
        
        const totalPaidEl = document.getElementById('modalTotalPaid');
        const changeEl = document.getElementById('modalChange');
        
        if (totalPaidEl) {
            totalPaidEl.textContent = `Rp ${formatUang(safeNumber(t.total_paid))}`;
        }
        
        if (changeEl) {
            changeEl.textContent = `Rp ${formatUang(safeNumber(t.change))}`;
        }

        bukaModal('transactionModal');
    }
    
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