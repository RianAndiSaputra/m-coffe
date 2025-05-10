<!-- Modal Tambah Produk -->
<div id="modalTambahProduk" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-y-auto max-h-[90vh]" onclick="event.stopPropagation()">
        <div class="p-6 space-y-4">
            <h2 class="text-lg font-semibold">Tambah Produk Baru</h2>

            <!-- Card: Informasi Dasar -->
            <div class="p-4 border rounded shadow">
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Produk</label>
                    <input type="text" class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: Es Kopi Susu">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">SKU Produk</label>
                    <input type="text" class="w-full border rounded px-3 py-2 text-sm" placeholder="Kode unik produk (opsional)">
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">Deskripsi Produk</label>
                    <textarea class="w-full border rounded px-3 py-2 text-sm" placeholder="Deskripsi singkat tentang produk... (opsional)"></textarea>
                </div>
            </div>

            <!-- Card: Harga & Kategori -->
            <div class="p-4 border rounded shadow">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Harga Jual</label>
                        <input type="text" class="w-full border rounded px-3 py-2 text-sm" placeholder="Rp">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Kategori</label>
                        <select class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Card: Manajemen Stok -->
            <div class="p-4 border rounded shadow">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Stok</label>
                        <input type="number" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Stok Minimum</label>
                        <input type="number" class="w-full border rounded px-3 py-2 text-sm">
                    </div>
                </div>
            </div>

            <!-- Card: Distribusi Outlet -->
            <div class="p-4 border rounded shadow">
                <h3 class="font-semibold mb-2">Distribusi Outlet</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox">
                        <span>Kifa Bakery Pusat - Jl. Merdeka No. 1</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox">
                        <span>Kifa Bakery Cabang 1 - Jl. Mangga No. 12</span>
                    </label>
                </div>
            </div>

            <!-- Card: Gambar Produk -->
            <div class="p-4 border rounded shadow">
                <label class="block font-medium mb-1">Gambar Produk</label>
                <input type="file" class="w-full text-sm">
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-2">
                <button id="btnBatalModal" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
                <button class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">+ Tambah Produk</button>
            </div>
        </div>
    </div>
</div>
