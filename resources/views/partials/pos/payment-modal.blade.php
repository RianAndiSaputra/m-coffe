<!-- Tambahkan Tailwind CSS dan Font Awesome jika belum -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

<div id="paymentModal" class="modal fixed inset-0 z-50 hidden">
  <div class="modal-overlay absolute w-full h-full bg-black opacity-50"></div>
  <div class="modal-container bg-white w-full max-w-md mx-auto rounded-xl shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
    <div class="modal-content p-6 text-left">
      <div class="flex justify-between items-center pb-4">
        <h3 class="text-xl font-bold">Pembayaran</h3>
        <button onclick="closeModal('paymentModal')" class="text-gray-400 hover:text-red-500"><i class="fas fa-times"></i></button>
      </div>

      <p class="text-sm mb-4 text-gray-600">Selesaikan transaksi dengan memilih metode pembayaran</p>

      <div class="bg-orange-100 text-orange-600 p-4 rounded-lg mb-4">
        <p class="text-sm">Total Pembayaran</p>
        <p id="totalPayment" class="text-lg font-semibold">Rp 3.509</p>
        <p class="text-xs text-gray-500">1 item dalam transaksi</p>
      </div>

      <!-- Metode Pembayaran dengan Border -->
      <div class="mb-4">
        <label class="font-semibold mb-2 block">Metode Pembayaran</label>
        <div class="space-y-2">
            <label class="flex items-center space-x-2 border border-gray-300 p-2 rounded-lg">
            <input type="radio" name="paymentMethod" value="tunai" class="accent-black" checked onchange="toggleCashInput()">
            <i class="fas fa-money-bill-wave text-orange-500"></i>
            <span class="w-full">Tunai</span>
            </label>
            <label class="flex items-center space-x-2 border border-gray-300 p-2 rounded-lg">
            <input type="radio" name="paymentMethod" value="transfer" class="accent-black" onchange="toggleCashInput()">
            <i class="fas fa-exchange-alt text-orange-500"></i>
            <span class="w-full">Transfer</span>
            </label>
            <label class="flex items-center space-x-2 border border-gray-300 p-2 rounded-lg">
            <input type="radio" name="paymentMethod" value="qris" class="accent-black" onchange="toggleCashInput()">
            <i class="fas fa-qrcode text-orange-500"></i>
            <span class="w-full">QRIS</span>
            </label>
        </div>
        </div>


      <!-- Jumlah Uang (Hanya muncul saat metode tunai dipilih) -->
<div id="cashInputSection" class="mb-4">
  <label class="font-semibold block mb-2">Jumlah Uang Diterima</label>
  <div class="relative">
    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">Rp</span>
    <input type="number" id="cashReceived" placeholder="0"
           class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
           oninput="calculateChange()">
  </div>

  <!-- Tampilkan Kembalian -->
  <div id="changeSection" class="mt-2 hidden">
    <div class="flex justify-between items-center bg-green-100 text-green-700 p-2 rounded">
      <span class="text-sm">Kembalian:</span>
      <span id="changeAmount" class="font-semibold">Rp 0</span>
    </div>
  </div>
</div>

<!-- Simulasikan total bayar -->
<input type="hidden" id="totalAmount" value="50000"> <!-- Contoh total Rp 50.000 -->


      <!-- Member with Search -->
      <div class="mb-4 relative">
        <label class="font-semibold block mb-2">Member</label>
        <div class="relative">
          <button id="memberDropdownButton" onclick="toggleMemberDropdown()" class="w-full px-3 py-2 border rounded-lg text-left flex justify-between items-center">
            <span id="selectedMemberText">Pilih Member</span>
            <i class="fas fa-chevron-down text-gray-400"></i>
          </button>
          
          <div id="memberDropdown" class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
            <div class="p-2 border-b sticky top-0 bg-white">
              <div class="relative">
                <input type="text" id="memberSearchInput" placeholder="Cari member..." class="w-full pl-8 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-400">
                <i class="fas fa-search absolute left-2 top-3 text-gray-400"></i>
              </div>
            </div>
            <ul id="memberList" class="py-1">
              <li onclick="selectMember('M001', 'Andi Pratama')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                <p class="font-medium">Andi Pratama</p>
                <p class="text-xs text-gray-500">M001</p>
              </li>
              <li onclick="selectMember('M002', 'Budi Santoso')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                <p class="font-medium">Budi Santoso</p>
                <p class="text-xs text-gray-500">M002</p>
              </li>
              <li onclick="selectMember('M003', 'Citra Dewi')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                <p class="font-medium">Citra Dewi</p>
                <p class="text-xs text-gray-500">M003</p>
              </li>
              <li onclick="selectMember('M004', 'Dian Sari')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                <p class="font-medium">Dian Sari</p>
                <p class="text-xs text-gray-500">M004</p>
              </li>
              <li onclick="selectMember('M005', 'Eko Wahyudi')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                <p class="font-medium">Eko Wahyudi</p>
                <p class="text-xs text-gray-500">M005</p>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex justify-end space-x-3 pt-4">
        <button onclick="closeModal('paymentModal')" class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</button>
        <button onclick="processPayment()" class="px-4 py-2 text-sm bg-orange-500 text-white hover:bg-orange-600 rounded-lg">Bayar</button>
      </div>
    </div>
  </div>
</div>


<!-- Success Modal -->
<div id="successModal" class="modal fixed inset-0 z-50 hidden">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2">
        <div class="modal-content py-6 text-left px-6">
            <!-- Header -->
            <div class="flex justify-between items-center pb-2">
                <p class="text-base font-semibold">Pembayaran</p>
                <button onclick="closeModal('successModal')" class="modal-close cursor-pointer z-50">
                    <i data-lucide="x" class="w-5 h-5 text-gray-600"></i>
                </button>
            </div>

            <!-- Description -->
            <p class="text-sm text-gray-500 mb-4">Selesaikan transaksi dengan memilih metode pembayaran</p>

            <!-- Success icon and message -->
            <div class="text-center my-6">
                <div class="flex justify-center mb-3">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i data-lucide="check-circle" class="w-8 h-8 text-green-500"></i>
                    </div>
                </div>
                <p class="text-green-600 text-lg font-semibold mb-1">Pembayaran Berhasil!</p>
                <p class="text-sm text-gray-600">Transaksi telah berhasil diselesaikan</p>
            </div>

            <!-- Action buttons -->
            <div class="flex justify-center pt-4 space-x-3">
                <button class="px-5 py-2 text-sm bg-orange-500 text-white rounded hover:bg-orange-600 transition">Cetak Struk</button>
                <button onclick="closeModal('successModal')" class="px-5 py-2 text-sm bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    //fungsi untuk caltulator
     function calculateChange() {
    const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    if (paymentMethod !== "tunai") {
      document.getElementById("cashInputSection").classList.add("hidden");
      return;
    } else {
      document.getElementById("cashInputSection").classList.remove("hidden");
    }

    const cash = parseInt(document.getElementById("cashReceived").value) || 0;
    const total = parseInt(document.getElementById("totalAmount").value);
    const change = cash - total;

    const changeSection = document.getElementById("changeSection");
    const changeAmount = document.getElementById("changeAmount");

    if (change >= 0) {
      changeAmount.textContent = formatRupiah(change);
      changeSection.classList.remove("hidden");
    } else {
      changeSection.classList.add("hidden");
    }
  }

  function formatRupiah(angka) {
    return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  // Fungsi ini akan dipanggil saat metode pembayaran diganti
  function toggleCashInput() {
    const selected = document.querySelector('input[name="paymentMethod"]:checked').value;
    const cashSection = document.getElementById("cashInputSection");
    if (selected === "tunai") {
      cashSection.classList.remove("hidden");
      calculateChange(); // Pastikan kalkulasi langsung jalan
    } else {
      cashSection.classList.add("hidden");
    }
  }

  // Inisialisasi di awal
  document.addEventListener("DOMContentLoaded", () => {
    toggleCashInput();
  });

    // Function to show payment modal
    function showPaymentModal() {
        document.getElementById('paymentModal').classList.remove('hidden');
    }
    
    // Function to close any modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Function to process payment
    function processPayment() {
        // Here you would normally process the payment
        // For demo purposes, we'll just show success
        
        closeModal('paymentModal');
        
        // Show success modal after a short delay
        setTimeout(() => {
            document.getElementById('successModal').classList.remove('hidden');
        }, 300);
        
        // Show success alert
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Pembayaran Berhasil',
            showConfirmButton: false,
            timer: 3000,
            background: '#FFA500',
            iconColor: '#fff',
            toast: true
        });
    }
    
    // Function to show error alert
    function showErrorAlert(message) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: message,
            showConfirmButton: false,
            timer: 3000,
            background: '#FF0000',
            iconColor: '#fff',
            toast: true
        });
    }
    
    // Toggle member dropdown
    function toggleMemberDropdown() {
        const dropdown = document.getElementById('memberDropdown');
        dropdown.classList.toggle('hidden');
        
        // Focus on search input when dropdown is shown
        if (!dropdown.classList.contains('hidden')) {
            document.getElementById('memberSearchInput').focus();
        }
    }
    
    // Select a member
    function selectMember(id, name) {
        document.getElementById('selectedMemberText').textContent = name;
        document.getElementById('memberDropdown').classList.add('hidden');
        // You can store the selected member ID in a hidden field or variable
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('memberDropdown');
        const button = document.getElementById('memberDropdownButton');
        
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Search functionality for members
    document.getElementById('memberSearchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const members = document.querySelectorAll('#memberList li');
        
        members.forEach(member => {
            const name = member.querySelector('p.font-medium').textContent.toLowerCase();
            const id = member.querySelector('p.text-xs').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || id.includes(searchTerm)) {
                member.style.display = 'flex';
            } else {
                member.style.display = 'none';
            }
        });
    });
</script>

<style>
    .modal {
        transition: opacity 0.25s ease;
    }
    
    /* SweetAlert toast styling */
    .swal2-toast {
        width: auto !important;
        padding: 1rem 1.5rem !important;
    }
    
    /* Custom scrollbar for dropdown */
    #memberDropdown::-webkit-scrollbar {
        width: 6px;
    }
    
    #memberDropdown::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 0 0 8px 8px;
    }
    
    #memberDropdown::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    
    #memberDropdown::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>