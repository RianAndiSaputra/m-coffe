<div id="modalEditBahanBaku" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl max-h-[90vh] flex flex-col mx-auto" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="p-6 border-b bg-gradient-to-r from-blue-50 to-cyan-50 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Bahan Baku</h2>
                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi bahan baku</p>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="overflow-y-auto p-6 space-y-6 flex-1">
            <form id="editBahanBakuForm">
                <input type="hidden" id="editBahanBakuId" name="id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Bahan -->
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-2 text-gray-700" for="editNama">Nama Bahan Baku <span class="text-red-500">*</span></label>
                        <input type="text" id="editNama" name="name" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
                    </div>

                    <!-- SKU -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="editSku">SKU <span class="text-red-500">*</span></label>
                        <input type="text" id="editSku" name="sku" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="editKategori">Kategori <span class="text-red-500">*</span></label>
                        <select id="editKategori" name="category" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
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
                        <label class="block font-medium mb-2 text-gray-700" for="editStok">Stok <span class="text-red-500">*</span></label>
                        <input type="number" id="editStok" name="stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" step="0.01" required>
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="editSatuan">Satuan <span class="text-red-500">*</span></label>
                        <select id="editSatuan" name="unit" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
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
                        <label class="block font-medium mb-2 text-gray-700" for="editHargaBeli">Harga Beli <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" id="editHargaBeli" name="buy_price" class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" required>
                        </div>
                    </div>

                    <!-- Stok Minimum -->
                    <div>
                        <label class="block font-medium mb-2 text-gray-700" for="editStokMinimum">Stok Minimum</label>
                        <input type="number" id="editStokMinimum" name="min_stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" step="0.01">
                    </div>

                    <!-- Supplier -->
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-2 text-gray-700" for="editSupplier">Supplier</label>
                        <input type="text" id="editSupplier" name="supplier" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-2 text-gray-700" for="editStatus">Status</label>
                        <select id="editStatus" name="is_active" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                            <option value="1">Aktif - Bahan dapat digunakan</option>
                            <option value="0">Nonaktif - Bahan tidak dapat digunakan</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="p-6 border-t bg-gray-50 rounded-b-2xl flex justify-end gap-3">
            <button type="button" onclick="closeEditModal()" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 font-medium transition-colors duration-200">Batal</button>
            <button type="button" onclick="updateBahanBakuData()" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-medium transition-colors duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
