<div id="modalTambahBahanBaku" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="p-6 border-b bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Bahan Baku Baru</h2>
                    <p class="text-sm text-gray-600 mt-1">Lengkapi informasi bahan baku baru</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="overflow-y-auto p-6 space-y-6 flex-1">
            <form id="tambahBahanBakuForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Bahan -->
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-2 text-gray-700" for="nama">Nama Bahan Baku <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="name" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="Contoh: Biji Kopi Arabica" required>
                    </div>

                    <!-- SKU -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="sku">SKU <span class="text-red-500">*</span></label>
                        <input type="text" id="sku" name="sku" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="Kode unik bahan baku" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="kategori">Kategori <span class="text-red-500">*</span></label>
                        <select id="kategori" name="category" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
                            <option value="">Pilih Kategori</option>
                            <option value="kopi">Biji Kopi</option>
                            <option value="susu">Produk Susu</option>
                            <option value="gula">Pemanis</option>
                            <option value="sirup">Sirup & Flavor</option>
                            <option value="topping">Topping</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="stok">Stok Awal <span class="text-red-500">*</span></label>
                        <input type="number" id="stok" name="stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="0.00" step="0.01" required>
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="satuan">Satuan <span class="text-red-500">*</span></label>
                        <select id="satuan" name="unit" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
                            <option value="">Pilih Satuan</option>
                            <option value="kg">Kilogram (kg)</option>
                            <option value="g">Gram (g)</option>
                            <option value="mg">Miligram (mg)</option>
                            <option value="l">Liter (l)</option>
                            <option value="ml">Mililiter (ml)</option>
                            <option value="pcs">Pieces (pcs)</option>
                            <option value="pack">Pack</option>
                            <option value="sachet">Sachet</option>
                        </select>
                    </div>

                    <!-- Harga Beli -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="hargaBeli">Harga Beli <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" id="hargaBeli" name="buy_price" class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="0" required>
                        </div>
                    </div>

                    <!-- Stok Minimum -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="stokMinimum">Stok Minimum</label>
                        <input type="number" id="stokMinimum" name="min_stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <!-- Supplier -->
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-2 text-gray-700" for="supplier">Supplier</label>
                        <input type="text" id="supplier" name="supplier" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="Nama supplier bahan baku">
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-2 text-gray-700" for="status">Status</label>
                        <select id="status" name="is_active" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                            <option value="1" selected>Aktif - Bahan dapat digunakan</option>
                            <option value="0">Nonaktif - Bahan tidak dapat digunakan</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="p-6 border-t bg-gray-50 rounded-b-2xl flex justify-end gap-3">
            <button type="button" onclick="closeTambahModal()" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 font-medium transition-colors duration-200">Batal</button>
            <button type="button" onclick="simpanBahanBakuBaru()" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-medium transition-colors duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Bahan Baku
            </button>
        </div>
    </div>
</div>

<script>
function closeTambahModal() {
    document.getElementById('modalTambahBahanBaku').classList.add('hidden');
    document.getElementById('tambahBahanBakuForm').reset();
}

function simpanBahanBakuBaru() {
    const form = document.getElementById('tambahBahanBakuForm');
    const formData = new FormData(form);
    
    // Convert FormData to object
    const data = Object.fromEntries(formData.entries());
    
    // Basic validation
    if (!data.name || !data.sku || !data.category || !data.stock || !data.unit || !data.buy_price) {
        alert('Harap lengkapi semua field yang wajib diisi!');
        return;
    }
    
    // Call global function from main page
    if (typeof window.simpanBahanBaku === 'function') {
        window.simpanBahanBaku(data);
    }
    
    closeTambahModal();
}

// Close modal when clicking outside
document.getElementById('modalTambahBahanBaku').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTambahModal();
    }
});
</script>