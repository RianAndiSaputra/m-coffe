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
                <div id="incomeDataContainer">
                    <!-- Data akan diisi oleh JavaScript -->
                    <p class="text-center py-4">Memuat data...</p>
                </div>
            </div>
            <div class="flex justify-end pt-2">
                <button onclick="closeModal('incomeModal')" class="px-4 py-2 text-sm bg-gray-300 rounded">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
// Format tanggal ke format Indonesia (dd/mm/yyyy)
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID');
}

// Format currency ke Rupiah
function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

// Function untuk menampilkan modal pendapatan
async function showIncomeModal(outletId, startDate = null, endDate = null) {
    // Tampilkan modal
    const modal = document.getElementById('incomeModal');
    modal.classList.remove('hidden');
    
    // Tampilkan loading state
    const container = document.getElementById('incomeDataContainer');
    container.innerHTML = '<p class="text-center py-4">Memuat data...</p>';

    try {
        // Fetch data dari endpoint yang sudah ada
        const response = await fetch(`/cash-registers/${outletId}`);
        const result = await response.json();

        if (!result.success) {
            throw new Error(result.message || 'Gagal memuat data');
        }

        const cashRegister = result.data;
        
        // Hitung total pendapatan dari transaksi
        let totalIncome = 0;
        let transactionCount = 0;
        let firstDate = null;
        let lastDate = null;

        if (cashRegister.cash_register_transactions && cashRegister.cash_register_transactions.length > 0) {
            // Filter transaksi berdasarkan tanggal jika ada parameter
            const transactions = cashRegister.cash_register_transactions.filter(trans => {
                if (!startDate || !endDate) return true;
                const transDate = new Date(trans.created_at);
                return transDate >= new Date(startDate) && transDate <= new Date(endDate);
            });

            transactionCount = transactions.length;
            
            transactions.forEach(trans => {
                totalIncome += parseFloat(trans.amount) || 0;
                
                // Cari tanggal pertama dan terakhir
                const transDate = new Date(trans.created_at);
                if (!firstDate || transDate < firstDate) firstDate = transDate;
                if (!lastDate || transDate > lastDate) lastDate = transDate;
            });
        }

        // Tampilkan data di modal
        container.innerHTML = `
            <p>Total pendapatan: <strong>${formatRupiah(totalIncome)}</strong></p>
            <p class="mt-2">Periode: <strong>${firstDate ? formatDate(firstDate) : '-'}</strong> sampai <strong>${lastDate ? formatDate(lastDate) : '-'}</strong></p>
            <p class="mt-2">Jumlah transaksi: <strong>${transactionCount}</strong></p>
            
            ${startDate && endDate ? `
            <p class="mt-2 text-sm text-gray-600">
                (Difilter berdasarkan periode: ${formatDate(startDate)} - ${formatDate(endDate)})
            </p>
            ` : ''}
        `;

    } catch (error) {
        console.error('Error:', error);
        container.innerHTML = `
            <p class="text-red-500">Gagal memuat data pendapatan: ${error.message}</p>
        `;
    }
}

// Function untuk menutup modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>