<!-- Modal Tambah Produk -->
<div id="modalTambahProduk" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModal()">
    <div
        class="bg-white w-full max-w-4xl rounded-xl shadow-lg max-h-screen flex flex-col"
        onclick="event.stopPropagation()"
    >
        <!-- Header -->
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Tambah Produk Baru</h2>
            <p class="text-sm text-gray-500">Lengkapi informasi produk baru dengan detail yang sesuai.</p>
        </div>

        <!-- Scrollable Content -->
        <div class="overflow-y-auto p-6 space-y-6 flex-1">

            <!-- Card: Informasi Dasar -->
            <div class="p-5 border rounded-lg shadow-sm">
                <h3 class="font-semibold mb-4 text-gray-700">Informasi Dasar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Nama Produk</label>
                        <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Contoh: Es Kopi Susu">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">SKU Produk</label>
                        <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Kode unik produk (opsional)">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-medium mb-1">Deskripsi Produk</label>
                        <textarea class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Deskripsi singkat... (opsional)"></textarea>
                    </div>
                </div>
            </div>

            <!-- Card: Harga & Kategori -->
            <div class="p-5 border rounded-lg shadow-sm">
                <h3 class="font-semibold mb-4 text-gray-700">Harga & Kategori</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Harga Jual</label>
                        <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Rp">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Kategori</label>
                        <select class="w-full border rounded-lg px-4 py-2 text-sm">
                            <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Card: Manajemen Stok -->
            <div class="p-5 border rounded-lg shadow-sm">
                <h3 class="font-semibold mb-4 text-gray-700">Manajemen Stok</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Stok</label>
                        <input type="number" class="w-full border rounded-lg px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Stok Minimum</label>
                        <input type="number" class="w-full border rounded-lg px-4 py-2 text-sm">
                    </div>
                </div>
            </div>

            <!-- Card: Distribusi Outlet -->
            <div class="p-5 border rounded-lg shadow-sm">
                <h3 class="font-semibold mb-4 text-gray-700">Distribusi Outlet</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox rounded">
                        <span>Kifa Bakery Pusat - Jl. Merdeka No. 1</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox rounded">
                        <span>Kifa Bakery Cabang 1 - Jl. Mangga No. 12</span>
                    </label>
                </div>
            </div>

            <!-- Card: Gambar Produk -->
            <div class="p-5 border rounded-lg shadow-sm">
                <h3 class="font-semibold mb-4 text-gray-700">Gambar Produk</h3>
                <input type="file" class="w-full text-sm">
                <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
            </div>
        </div>

        <!-- Footer: Tombol Aksi -->
        <div class="p-6 border-t flex justify-end gap-3">
            <button id="btnBatalModal" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
            <button class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">+ Tambah Produk</button>
        </div>
    </div>
</div>