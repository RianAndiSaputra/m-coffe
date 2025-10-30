<!-- Modal Edit Produk -->
<div id="modalEditProduk" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="p-6 border-b bg-gradient-to-r from-green-50 to-amber-50 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Produk</h2>
                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi produk dengan detail yang sesuai</p>
                    <p class="text-xs text-gray-500 mt-1">ID Produk: <span id="editProdukId">-</span></p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#3b6b0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="overflow-y-auto p-6 space-y-6 flex-1">
            <form id="editProdukForm" enctype="multipart/form-data">
                <!-- Card: Tipe Produk -->
                <div class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Tipe Produk <span class="text-red-500 ml-1">*</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="edit_product_type" value="minuman" class="sr-only peer">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-[#3b6b0d] peer-checked:bg-green-50 transition-all duration-200 hover:border-[#335e0c]">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-[#3b6b0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Minuman</h4>
                                        <p class="text-sm text-gray-600">Menggunakan sistem bahan baku</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="edit_product_type" value="makanan" class="sr-only peer">
                            <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-[#3b6b0d] peer-checked:bg-green-50 transition-all duration-200 hover:border-[#335e0c]">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-6 h-6 text-[#3b6b0d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Makanan</h4>
                                        <p class="text-sm text-gray-600">Menggunakan sistem stok langsung</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Card: Informasi Dasar -->
                <div class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Dasar
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editNama">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" id="editNama" name="name" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" placeholder="Contoh: Espresso / Croissant" required>
                        </div>
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editSku">SKU Produk <span class="text-red-500">*</span></label>
                            <input type="text" id="editSku" name="sku" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" placeholder="Kode unik produk" required>
                        </div>
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editBarcode">Barcode</label>
                            <div class="flex gap-2">
                                <input type="text" id="editBarcode" name="barcode" class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" placeholder="Kode barcode">
                                <button type="button" id="generateBarcodeBtnEdit" class="px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl hover:bg-gray-200 text-sm whitespace-nowrap transition-colors duration-200">
                                    Generate
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Biarkan kosong untuk generate otomatis</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium mb-2 text-gray-700" for="editDeskripsi">Deskripsi Produk</label>
                            <textarea id="editDeskripsi" name="description" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" placeholder="Deskripsi singkat tentang produk..." rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Card: Harga & Kategori -->
                <div class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Harga & Kategori
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editHarga">Harga Jual <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" id="editHarga" name="price" class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" placeholder="0" required>
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editKategori">Kategori <span class="text-red-500">*</span></label>
                            <select id="editKategori" name="category_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" required>
                                <option value="">Pilih Kategori</option>
                                <!-- Options akan diisi via JavaScript -->
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Card: Manajemen Bahan Baku (Hanya untuk Minuman) -->
                <div id="editBahanBakuSection" class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm transition-all duration-300 hidden">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Manajemen Bahan Baku
                    </h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block font-medium mb-2 text-gray-700" for="editBahanBaku">Bahan Baku</label>
                                <select id="editBahanBaku" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200">
                                    <option value="">Pilih Bahan Baku</option>
                                    <!-- Options akan diisi via JavaScript -->
                                </select>
                            </div>
                            <div>
                                <label class="block font-medium mb-2 text-gray-700" for="editJumlahBahan">Jumlah</label>
                                <input type="number" id="editJumlahBahan" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" placeholder="0.00" step="0.01">
                            </div>
                            <div>
                                <label class="block font-medium mb-2 text-gray-700" for="editSatuanBahan">Satuan</label>
                                <select id="editSatuanBahan" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200">
                                    <option value="">Pilih Satuan</option>
                                    <!-- Options akan diisi via JavaScript -->
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="editTambahBahanBtn" class="px-4 py-3 bg-[#3b6b0d] text-white rounded-xl hover:bg-[#335e0c] text-sm w-full transition-colors duration-200 font-medium">
                                    + Tambah
                                </button>
                            </div>
                        </div>
                        
                        <!-- Daftar Bahan Baku yang Ditambahkan -->
                        <div id="editDaftarBahanBaku" class="border border-gray-200 rounded-xl p-4 max-h-48 overflow-y-auto bg-gray-50">
                            <p class="text-gray-500 text-sm italic text-center py-4">Belum ada bahan baku yang ditambahkan</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Manajemen Stok (Hanya untuk Makanan) -->
                <div id="editStokSection" class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm transition-all duration-300 hidden">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        Manajemen Stok
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editStok">Stok <span class="text-red-500">*</span></label>
                            <input type="number" id="editStok" name="stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" value="0">
                            <p class="text-xs text-gray-500 mt-2">Jumlah stok produk makanan</p>
                        </div>
                        <div>
                            <label class="block font-medium mb-2 text-gray-700" for="editStokMinimum">Stok Minimum</label>
                            <input type="number" id="editStokMinimum" name="min_stock" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200" value="0">
                            <p class="text-xs text-gray-500 mt-2">Peringatan ketika stok mencapai batas ini</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Distribusi Outlet -->
                <div class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Distribusi Outlet <span class="text-red-500 ml-1">*</span>
                    </h3>
                    <div id="editOutletCheckboxes" class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <!-- Checkboxes will be added dynamically -->
                        <div class="flex items-center p-3 border border-gray-200 rounded-xl bg-gray-50">
                            <div class="animate-pulse flex space-x-4 w-full">
                                <div class="rounded-full bg-gray-300 h-4 w-4"></div>
                                <div class="flex-1 space-y-2 py-1">
                                    <div class="h-2 bg-gray-300 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Gambar Produk -->
                <div class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Gambar Produk
                    </h3>
                    <div class="mb-3">
                        <img id="editGambarPreview" src="" alt="Preview Gambar" class="max-w-full h-32 object-contain border rounded hidden mx-auto">
                    </div>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#3b6b0d] transition-colors duration-200">
                        <input type="file" id="editGambar" name="image" class="hidden" accept="image/*">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm text-gray-600 mb-2">Klik untuk upload gambar produk baru</p>
                            <p class="text-xs text-gray-500">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
                        </div>
                    </div>
                    <input type="hidden" id="editGambarCurrent" name="current_image">
                </div>

                <!-- Status Produk -->
                <div class="p-6 border border-gray-200 rounded-xl bg-white shadow-sm">
                    <h3 class="font-semibold mb-4 text-gray-800 flex items-center">
                        <svg class="w-5 h-5 text-[#3b6b0d] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status Produk
                    </h3>
                    <select id="editStatus" name="is_active" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition-all duration-200">
                        <option value="1">Aktif - Produk dapat dijual</option>
                        <option value="0">Nonaktif - Produk tidak dapat dijual</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Footer: Tombol Aksi -->
        <div class="p-6 border-t bg-gray-50 rounded-b-2xl flex justify-between items-center">
            <div class="text-sm text-gray-600">
                <span class="text-red-500">*</span> Menandakan field wajib diisi
            </div>
            <div class="flex gap-3">
                <button id="btnBatalEdit" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 font-medium transition-colors duration-200">Batal</button>
                <button type="button" id="btnSimpanEdit" class="px-6 py-3 bg-[#3b6b0d] text-white rounded-xl hover:bg-[#335e0c] font-medium transition-colors duration-200 shadow-sm">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Gaya tambahan untuk animasi dan warna */
.bg-orange-600 {
    background-color: #ea580c;
}

.hover\:bg-orange-700:hover {
    background-color: #c2410c;
}

/* Gaya untuk file upload area */
#editGambar + div:hover {
    border-color: #ea580c;
    background-color: #f9fafb;
}

/* Gaya untuk radio buttons yang dipilih */
input[name="edit_product_type"]:checked + div {
    border-color: #ea580c;
    background-color: #fff7ed;
}
</style>