<div id="modalTambahStok" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md mx-4" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">Tambah Stok</h3>
            <button type="button" onclick="closeModal('modalTambahStok')" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
            <h4 class="font-medium text-gray-900" id="modalBahanNama"></h4>
            <div class="grid grid-cols-2 gap-4 mt-2 text-sm">
                <div>
                    <span class="text-gray-600">Stok Saat Ini:</span>
                    <span class="font-medium" id="currentStock"></span>
                </div>
                <div>
                    <span class="text-gray-600">Harga Rata-rata:</span>
                    <span class="font-medium" id="currentAvgPrice"></span>
                </div>
            </div>
        </div>
        <form id="tambahStokForm">
            <input type="hidden" name="bahan_baku_id" id="tambahStokBahanId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok</label>
                    <input type="number" name="jumlah" step="0.01" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli</label>
                    <input type="number" name="harga_beli" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal('modalTambahStok')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </button>
                <button type="button" onclick="simpanTambahStok()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    Simpan Stok
                </button>
            </div>
        </form>
    </div>
</div>