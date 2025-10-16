<div id="modalKonfirmasiHapus" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl mx-auto" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Konfirmasi Hapus</h2>
                        <p class="text-sm text-gray-600 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
                <button type="button" onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menghapus bahan baku berikut?</p>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <p class="font-semibold text-red-800 text-lg" id="hapusItemName"></p>
                <p class="text-red-600 text-sm mt-1">Data yang dihapus tidak dapat dikembalikan</p>
            </div>
            <input type="hidden" id="hapusItemId">
        </div>

        <!-- Footer -->
        <div class="p-6 border-t bg-gray-50 rounded-b-2xl flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-6 py-3 border border-gray-300 rounded-xl hover:bg-gray-100 font-medium transition-colors duration-200">Batal</button>
            <button type="button" onclick="konfirmasiHapus()" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 font-medium transition-colors duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
function closeDeleteModal() {
    const modal = document.getElementById('modalKonfirmasiHapus');
    modal.classList.add('hidden');
}

function konfirmasiHapus() {
    const id = document.getElementById('hapusItemId').value;
    
    // Call global function from main page
    if (typeof window.hapusBahanBaku === 'function') {
        window.hapusBahanBaku(id);
    }
    
    closeDeleteModal();
}

// Close modal ketika klik outside
document.getElementById('modalKonfirmasiHapus').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal dengan ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>