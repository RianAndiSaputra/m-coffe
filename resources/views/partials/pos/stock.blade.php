<!-- Stock Adjustment Modal -->
<div id="stockModal" class="modal fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-3xl mx-auto rounded-lg shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-xl font-bold">Sesuaikan Stok</p>
                <button onclick="closeModal('stockModal')" class="modal-close cursor-pointer z-50 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <p class="text-base text-gray-600 mb-4">Sesuaikan stok produk. Perubahan memerlukan persetujuan admin</p>

            <!-- Tabs -->
            <div class="flex bg-gray-100 rounded-lg p-1 mb-6 w-fit">
                <button id="adjustTab" class="tab-button active px-6 py-2 rounded-lg font-medium text-base text-orange-500 bg-white shadow">Sesuaikan</button>
                <button id="historyTab" class="tab-button px-6 py-2 rounded-lg font-medium text-base text-gray-500 hover:text-gray-700">Riwayat</button>
            </div>

            <!-- Adjust Content -->
            <div id="adjustContent" class="tab-content">
                <div class="mb-6">
                    <div class="mb-4">
                        <label class="block text-base font-medium text-gray-700 mb-2">Nama Produk</label>
                        <select class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                            <option>Pilih produk</option>
                        </select>
                    </div>

                    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-2">Nilai + / -</label>
                            <input type="number" class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" placeholder="Masukkan nilai">
                        </div>
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-2">Tipe</label>
                            <select class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                                <option>Pilih tipe</option>
                                <option>Kiriman</option>
                                <option>Pabrik</option>
                                <option>Pembelian</option>
                                <option>Penjualan</option>
                                <option>Penyesuaian</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea class="w-full px-4 py-2 text-base border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500" rows="3" placeholder="Masukkan keterangan (opsional)"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-2 space-x-4">
                    <button onclick="closeModal('stockModal')" class="px-6 py-2 text-base bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                    <button class="px-6 py-2 text-base bg-orange-500 text-white rounded-lg hover:bg-orange-600">Sesuaikan Stok</button>
                </div>
            </div>

            <!-- History Content -->
            <div id="historyContent" class="tab-content hidden">
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-700">12 Mei 2025</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="border-b">
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Nama Produk</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Perubahan</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Tipe</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Keterangan</th>
                                <th class="px-4 py-3 text-left text-base font-medium text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                    Tidak ada permintaan penyesuaian pada tanggal ini.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

      function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Tab switching functionality
    document.getElementById('adjustTab').addEventListener('click', function () {
        this.classList.add('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('historyTab').classList.remove('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('historyTab').classList.add('text-gray-500');
        document.getElementById('adjustContent').classList.remove('hidden');
        document.getElementById('historyContent').classList.add('hidden');
    });

    document.getElementById('historyTab').addEventListener('click', function () {
        this.classList.add('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('adjustTab').classList.remove('active', 'text-orange-500', 'bg-white', 'shadow');
        document.getElementById('adjustTab').classList.add('text-gray-500');
        document.getElementById('historyContent').classList.remove('hidden');
        document.getElementById('adjustContent').classList.add('hidden');
    });
</script>

<style>
    .tab-button.active {
        background-color: white;
        color: #f97316;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tab-button:not(.active):hover {
        background-color: #f3f4f6;
    }
</style>
