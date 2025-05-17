    <!-- Payment Modal -->
    <div id="paymentModal" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-white w-full max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto relative my-16">
            <div class="modal-content py-4 text-left px-6">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-xl font-bold text-gray-800">Pembayaran</h3>
                    <button class="modal-close cursor-pointer z-50" onclick="closeModal('paymentModal')">
                        <i class="fas fa-times text-gray-500 hover:text-gray-700"></i>
                    </button>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Subtotal:</span>
                        <span id="paymentSubtotal" class="font-bold">Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Diskon:</span>
                        <span id="paymentDiscount" class="font-bold">Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700">Pajak:</span>
                        <span id="paymentTax" class="text-gray-700">Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-700">Total Pembayaran:</span>
                        <span id="paymentGrandTotal" class="text-orange-500 font-bold text-lg">Rp 0</span>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="paymentMethod">
                            Metode Pembayaran
                        </label>
                        <div id="paymentMethods">
                            <!-- Payment methods will be added here -->
                        </div>
                    </div>
                    
                    <div id="cashPaymentSection" class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="amountReceived">
                            Jumlah Uang Diterima
                        </label>
                        <input type="text" id="amountReceived" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500" placeholder="Rp 0">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="changeAmount">
                            Kembalian
                        </label>
                        <input type="text" id="changeAmount" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                            Catatan (Opsional)
                        </label>
                        <textarea id="notes" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500" rows="2"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end pt-2">
                    <button id="btnProcessPayment" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>