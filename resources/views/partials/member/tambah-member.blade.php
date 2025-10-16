<div id="modalTambahMember" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalTambah()">
  <div class="bg-white w-full max-w-md rounded-xl shadow-lg max-h-screen flex flex-col" onclick="event.stopPropagation()">
    
    <!-- Header -->
    <div class="p-6 border-b">
      <h2 class="text-xl font-semibold">Tambah Member Baru</h2>
      <p class="text-sm text-gray-500">Tambahkan member baru dengan mengisi detail di bawah ini.</p>
    </div>

    <!-- Scrollable Content -->
    <div class="overflow-y-auto p-6 space-y-4 flex-1">
      <form id="formTambahMember">
        <!-- Kode Member -->
        <div>
          <label class="block font-medium mb-1">Kode Member <span class="text-red-500">*</span></label>
          <input type="text" id="kodeMember" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Kode member" required>
          <p id="errorKode" class="text-red-500 text-xs mt-1 hidden">Kode member wajib diisi</p>
        </div>

        <!-- Nama -->
        <div>
          <label class="block font-medium mb-1">Nama <span class="text-red-500">*</span></label>
          <input type="text" id="namaMember" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Nama member" required>
          <p id="errorNama" class="text-red-500 text-xs mt-1 hidden">Nama member wajib diisi</p>
        </div>

        <!-- Telepon -->
        <div>
          <label class="block font-medium mb-1">Telp <span class="text-red-500">*</span></label>
          <input type="text" id="teleponMember" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="No. telp member" required>
          <p id="errorTelepon" class="text-red-500 text-xs mt-1 hidden">Nomor telepon wajib diisi</p>
        </div>

        <!-- Email -->
        <div>
          <label class="block font-medium mb-1">Email</label>
          <input type="email" id="emailMember" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Email member (opsional)">
          <p id="errorEmail" class="text-red-500 text-xs mt-1 hidden">Format email tidak valid</p>
        </div>

        <!-- Alamat -->
        <div>
          <label class="block font-medium mb-1">Alamat</label>
          <textarea id="alamatMember" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Alamat member (opsional)"></textarea>
        </div>

        <!-- Jenis Kelamin -->
        <div>
          <label class="block font-medium mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
          <select id="jenisKelamin" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" required>
            <option value="">Pilih gender</option>
            <option value="male">Laki-laki</option>
            <option value="female">Perempuan</option>
          </select>
          <p id="errorJenisKelamin" class="text-red-500 text-xs mt-1 hidden">Jenis kelamin wajib dipilih</p>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="p-6 border-t flex justify-end gap-3">
      <button id="btnBatalModalTambah" type="button" class="px-4 py-2 border rounded hover:bg-gray-100 transition duration-200">Batal</button>
      <button id="btnTambahMember" type="button" class="px-4 py-2 bg-[#3b6b0d] text-white rounded hover:bg-[#335e0c] flex items-center gap-2 transition duration-200">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Simpan</span>
      </button>
    </div>
  </div>
</div>

<script>
    // Flag untuk mencegah multiple submission
    let isSubmitting = false;
    let eventListenersInitialized = false;

    // Fungsi untuk validasi form
    function validateForm() {
      let isValid = true;

      // Validasi kode member
      const kodeMember = document.getElementById('kodeMember');
      const errorKode = document.getElementById('errorKode');
      if (!kodeMember.value.trim()) {
        errorKode.classList.remove('hidden');
        kodeMember.classList.add('border-red-500');
        isValid = false;
      } else {
        errorKode.classList.add('hidden');
        kodeMember.classList.remove('border-red-500');
      }

      // Validasi nama member 
      const namaMember = document.getElementById('namaMember');
      const errorNama = document.getElementById('errorNama');
      if (!namaMember.value.trim()) {
        errorNama.classList.remove('hidden');
        namaMember.classList.add('border-red-500');
        isValid = false;
      } else {
        errorNama.classList.add('hidden');
        namaMember.classList.remove('border-red-500');
      }

      // Validasi telepon
      const teleponMember = document.getElementById('teleponMember');
      const errorTelepon = document.getElementById('errorTelepon');
      if (!teleponMember.value.trim()) {
        errorTelepon.classList.remove('hidden');
        teleponMember.classList.add('border-red-500');
        isValid = false;
      } else {
        errorTelepon.classList.add('hidden');
        teleponMember.classList.remove('border-red-500');
      }

      // Validasi email (jika diisi)
      const emailMember = document.getElementById('emailMember');
      const errorEmail = document.getElementById('errorEmail');
      if (emailMember.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailMember.value)) {
        errorEmail.classList.remove('hidden');
        emailMember.classList.add('border-red-500');
        isValid = false;
      } else {
        errorEmail.classList.add('hidden');
        emailMember.classList.remove('border-red-500');
      }

      // Validasi jenis kelamin
      const jenisKelamin = document.getElementById('jenisKelamin');
      const errorJenisKelamin = document.getElementById('errorJenisKelamin');
      if (!jenisKelamin.value) {
        errorJenisKelamin.classList.remove('hidden');
        jenisKelamin.classList.add('border-red-500');
        isValid = false;
      } else {
        errorJenisKelamin.classList.add('hidden');
        jenisKelamin.classList.remove('border-red-500');
      }

      return isValid;
    }

    // Fungsi untuk reset form
    function resetForm() {
      document.getElementById('kodeMember').value = '';
      document.getElementById('namaMember').value = '';
      document.getElementById('teleponMember').value = '';
      document.getElementById('emailMember').value = '';
      document.getElementById('alamatMember').value = '';
      document.getElementById('jenisKelamin').value = '';

      // Reset error messages dan styling
      document.querySelectorAll('[id^="error"]').forEach(el => el.classList.add('hidden'));
      document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
      
      // Reset submit flag
      isSubmitting = false;
    }

    // Fungsi untuk submit form
    async function submitForm() {
      // Cegah multiple submission dengan flag yang lebih ketat
      if (isSubmitting) {
        console.log('⏹️ Submit dicegah - sedang dalam proses');
        return;
      }
      
      console.log('🟡 Submit dimulai');
      
      if (!validateForm()) {
        console.log('❌ Validasi gagal');
        return;
      }

      isSubmitting = true;
      const btnTambah = document.getElementById('btnTambahMember');
      const originalText = btnTambah.innerHTML;

      try {
        // Tampilkan loading state
        btnTambah.innerHTML = `
          <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Menyimpan...
        `;
        btnTambah.disabled = true;

        const formData = {
          member_code: document.getElementById('kodeMember').value,
          nama: document.getElementById('namaMember').value,
          telepon: document.getElementById('teleponMember').value,
          email: document.getElementById('emailMember').value || null,
          alamat: document.getElementById('alamatMember').value || null,
          jenis_kelamin: document.getElementById('jenisKelamin').value
        };

        console.log('📤 Mengirim data:', formData);

        // Kirim data ke API
        const token = localStorage.getItem('token');
        const response = await fetch('/api/members', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(formData)
        });

        const data = await response.json();
        console.log('📥 Response:', data);

        if (!response.ok) {
          throw new Error(data.message || 'Gagal menambahkan member');
        }

        // Jika sukses
        console.log('✅ Berhasil menambahkan member');
        showAlert('success', 'Member berhasil ditambahkan');
        resetForm();
        closeModalTambah();

        // Refresh data member jika diperlukan
        if (typeof loadMembers === 'function') {
          loadMembers();
        }

      } catch (error) {
        console.error('❌ Error:', error);
        showAlert('error', error.message);
      } finally {
        // Kembalikan tombol ke state awal
        console.log('🔄 Reset tombol');
        isSubmitting = false;
        btnTambah.innerHTML = originalText;
        btnTambah.disabled = false;
      }
    }

    // Handler untuk submit dengan prevention
    function handleSubmit(event) {
      console.log('🖱️ Tombol Simpan diklik');
      event.preventDefault();
      event.stopPropagation();
      event.stopImmediatePropagation();
      
      submitForm();
      return false;
    }

    // Handler untuk enter key
    function handleEnterKey(event) {
      if (event.key === 'Enter') {
        console.log('⌨️ Enter key ditekan');
        event.preventDefault();
        event.stopPropagation();
        submitForm();
      }
    }

    // Setup event listeners dengan cleanup yang lebih thorough
    function setupEventListeners() {
      // Jika sudah diinisialisasi, jangan setup ulang
      if (eventListenersInitialized) {
        console.log('ℹ️ Event listeners sudah diinisialisasi');
        return;
      }

      console.log('🔄 Setup event listeners');
      
      const btnTambah = document.getElementById('btnTambahMember');
      const btnBatal = document.getElementById('btnBatalModalTambah');
      
      // Clone dan replace tombol untuk menghilangkan event listeners lama
      const newBtnTambah = btnTambah.cloneNode(true);
      const newBtnBatal = btnBatal.cloneNode(true);
      
      btnTambah.parentNode.replaceChild(newBtnTambah, btnTambah);
      btnBatal.parentNode.replaceChild(newBtnBatal, btnBatal);
      
      // Tambah event listeners baru
      newBtnTambah.addEventListener('click', handleSubmit, { once: false });
      newBtnBatal.addEventListener('click', closeModalTambah, { once: false });

      // Event listeners untuk input
      document.querySelectorAll('#modalTambahMember input').forEach(input => {
        input.addEventListener('keypress', handleEnterKey);
      });

      eventListenersInitialized = true;
    }

    // Cleanup event listeners
    function cleanupEventListeners() {
      console.log('🧹 Cleanup event listeners');
      
      const btnTambah = document.getElementById('btnTambahMember');
      const btnBatal = document.getElementById('btnBatalModalTambah');
      
      // Remove event listeners dengan function reference yang sama
      btnTambah.removeEventListener('click', handleSubmit);
      btnBatal.removeEventListener('click', closeModalTambah);
      
      document.querySelectorAll('#modalTambahMember input').forEach(input => {
        input.removeEventListener('keypress', handleEnterKey);
      });
      
      eventListenersInitialized = false;
    }

    // Fungsi untuk menutup modal
    function closeModalTambah() {
      console.log('🚪 Menutup modal');
      document.getElementById('modalTambahMember').classList.add('hidden');
      cleanupEventListeners();
      resetForm();
    }

    // Fungsi untuk membuka modal
    function openModalTambah() {
      console.log('🚀 Membuka modal');
      document.getElementById('modalTambahMember').classList.remove('hidden');
      setupEventListeners();
    }

    // Inisialisasi sekali saja
    document.addEventListener('DOMContentLoaded', function() {
      console.log('📄 DOM loaded');
      // Jangan setup event listeners di sini, nanti saat modal dibuka
    });
</script>