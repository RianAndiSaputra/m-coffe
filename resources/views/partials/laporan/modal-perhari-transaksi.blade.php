<div id="transactionDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="border-b px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800">Detail Transaksi</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6">
            <!-- Transaction Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Nomor Invoice</p>
                    <p class="font-medium">INV-20230511-001</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal/Waktu</p>
                    <p class="font-medium">11 Mei 2023, 08:15 WIB</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kasir</p>
                    <p class="font-medium">Ahmad Fauzi</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Metode Pembayaran</p>
                    <p class="font-medium">
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Tunai</span>
                    </p>
                </div>
            </div>
            
            <!-- Items Table -->
            <div class="border rounded-lg overflow-hidden mb-6">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Produk</th>
                            <th class="py-3 px-4 text-right">Harga</th>
                            <th class="py-3 px-4 text-right">Qty</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <!-- Item 1 -->
                        <tr>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-md bg-orange-100 flex items-center justify-center">
                                        <i data-lucide="croissant" class="w-4 h-4 text-orange-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium block">Roti Coklat Keju</span>
                                        <span class="text-xs text-gray-500">KFB-001</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right">Rp 15.000</td>
                            <td class="py-3 px-4 text-right">2</td>
                            <td class="py-3 px-4 text-right font-medium">Rp 30.000</td>
                        </tr>
                        
                        <!-- Item 2 -->
                        <tr>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-md bg-orange-100 flex items-center justify-center">
                                        <i data-lucide="cake" class="w-4 h-4 text-orange-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium block">Black Forest</span>
                                        <span class="text-xs text-gray-500">KFB-002</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right">Rp 45.000</td>
                            <td class="py-3 px-4 text-right">1</td>
                            <td class="py-3 px-4 text-right font-medium">Rp 45.000</td>
                        </tr>
                        
                        <!-- Item 3 -->
                        <tr>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-md bg-orange-100 flex items-center justify-center">
                                        <i data-lucide="coffee" class="w-4 h-4 text-orange-500"></i>
                                    </div>
                                    <div>
                                        <span class="font-medium block">Kopi Susu</span>
                                        <span class="text-xs text-gray-500">KFB-010</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right">Rp 12.000</td>
                            <td class="py-3 px-4 text-right">2</td>
                            <td class="py-3 px-4 text-right font-medium">Rp 24.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Summary -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">Catatan Transaksi</h4>
                        <p class="text-sm text-gray-600">Tidak ada catatan</p>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp 99.000</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-600">Pajak</span>
                            <span class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between border-t pt-2 mt-2">
                            <span class="text-gray-800 font-bold">Total</span>
                            <span class="text-orange-600 font-bold">Rp 99.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="border-t px-6 py-4 flex justify-end gap-3">
            <button onclick="closeModal()" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                Tutup
            </button>
            <button class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 flex items-center gap-2">
                <i data-lucide="printer" class="w-5 h-5"></i>
                Cetak Ulang
            </button>
        </div>
    </div>
</div>

<script>
    // Close modal when clicking outside
    document.getElementById('transactionDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>