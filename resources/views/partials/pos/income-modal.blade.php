<!-- Income Modal -->
<div id="incomeModal" class="modal fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-lg font-bold">Pendapatan</p>
                <button onclick="closeModal('incomeModal')" class="modal-close cursor-pointer z-50">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p>Total pendapatan dari <strong>01/05/2025</strong> sampai <strong>31/05/2025</strong> adalah <strong>Rp 12.345.000</strong>.</p>
            </div>
            <div class="flex justify-end pt-2">
                <button onclick="closeModal('incomeModal')" class="px-4 py-2 text-sm bg-gray-300 rounded">Tutup</button>
            </div>
        </div>
    </div>
</div>
