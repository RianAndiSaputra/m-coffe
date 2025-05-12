 <!-- Payment Modal -->
    <div id="paymentModal" class="modal fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-lg font-bold">Pembayaran</p>
                    <button onclick="closeModal('paymentModal')" class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mb-4">
                    <p>Ini adalah modal untuk proses pembayaran.</p>
                </div>
                <div class="flex justify-end pt-2 space-x-3">
                    <button onclick="closeModal('paymentModal')" class="px-4 py-2 text-sm bg-gray-300 rounded">Tutup</button>
                    <button class="px-4 py-2 text-sm bg-blue-500 text-white rounded">Proses Pembayaran</button>
                </div>
            </div>
        </div>
    </div>