<div id="modalEditMember" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalEdit()">
  <div class="bg-white w-full max-w-md rounded-xl shadow-lg max-h-screen flex flex-col" onclick="event.stopPropagation()">
    
    <!-- Header -->
    <div class="p-6 border-b">
      <h2 class="text-xl font-semibold">Edit Member</h2>
      <p class="text-sm text-gray-500">Perbarui informasi member dengan detail yang sesuai.</p>
    </div>

    <!-- Scrollable Content -->
    <div class="overflow-y-auto p-6 space-y-4 flex-1">
      <form id="formEditMember">
        <input type="hidden" id="memberIdToEdit">
        
        <!-- Nama -->
        <div>
          <label class="block font-medium mb-1">Nama <span class="text-red-500">*</span></label>
          <input type="text" id="editNamaMember" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Nama member" required>
          <p id="errorEditNama" class="text-red-500 text-xs mt-1 hidden">Nama member wajib diisi</p>
        </div>

        <!-- Telepon -->
        <div>
          <label class="block font-medium mb-1">Telp <span class="text-red-500">*</span></label>
          <input type="text" id="editTeleponMember" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="No. telp member" required>
          <p id="errorEditTelepon" class="text-red-500 text-xs mt-1 hidden">Nomor telepon wajib diisi</p>
        </div>

        <!-- Email -->
        <div>
          <label class="block font-medium mb-1">Email</label>
          <input type="email" id="editEmailMember" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Email member (opsional)">
          <p id="errorEditEmail" class="text-red-500 text-xs mt-1 hidden">Format email tidak valid</p>
        </div>

        <!-- Alamat -->
        <div>
          <label class="block font-medium mb-1">Alamat</label>
          <textarea id="editAlamatMember" class="w-full border rounded-lg px-4 py-2 text-sm" placeholder="Alamat member (opsional)"></textarea>
        </div>

        <!-- Jenis Kelamin -->
        <div>
          <label class="block font-medium mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
          <select id="editJenisKelamin" class="w-full border rounded-lg px-4 py-2 text-sm" required>
            <option value="">Pilih gender</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          <p id="errorEditJenisKelamin" class="text-red-500 text-xs mt-1 hidden">Jenis kelamin wajib dipilih</p>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="p-6 border-t flex justify-end gap-3">
      <button id="btnBatalModalEdit" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
      <button id="btnEditMember" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 flex items-center gap-2">
        <i data-lucide="save" class="w-4 h-4"></i>
        <span>Simpan Perubahan</span>
      </button>
    </div>
  </div>
</div>

<script>
// Fungsi untuk validasi form edit
function validateEditForm() {
  let isValid = true;
  
  // Validasi nama member
  const namaMember = document.getElementById('editNamaMember');
  const errorNama = document.getElementById('errorEditNama');
  if (!namaMember.value.trim()) {
    errorNama.classList.remove('hidden');
    namaMember.classList.add('border-red-500');
    isValid = false;
  } else {
    errorNama.classList.add('hidden');
    namaMember.classList.remove('border-red-500');
  }
  
  // Validasi telepon
  const teleponMember = document.getElementById('editTeleponMember');
  const errorTelepon = document.getElementById('errorEditTelepon');
  if (!teleponMember.value.trim()) {
    errorTelepon.classList.remove('hidden');
    teleponMember.classList.add('border-red-500');
    isValid = false;
  } else {
    errorTelepon.classList.add('hidden');
    teleponMember.classList.remove('border-red-500');
  }
  
  // Validasi email (jika diisi)
  const emailMember = document.getElementById('editEmailMember');
  const errorEmail = document.getElementById('errorEditEmail');
  if (emailMember.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailMember.value)) {
    errorEmail.classList.remove('hidden');
    emailMember.classList.add('border-red-500');
    isValid = false;
  } else {
    errorEmail.classList.add('hidden');
    emailMember.classList.remove('border-red-500');
  }
  
  // Validasi jenis kelamin
  const jenisKelamin = document.getElementById('editJenisKelamin');
  const errorJenisKelamin = document.getElementById('errorEditJenisKelamin');
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

// Fungsi untuk submit form edit
function submitEditForm() {
  if (!validateEditForm()) {
    return;
  }
  
  // Simulasi loading
  const btnEdit = document.getElementById('btnEditMember');
  const originalText = btnEdit.innerHTML;
  btnEdit.innerHTML = `
    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    Menyimpan...
  `;
  btnEdit.disabled = true;
  
  // Simulasi AJAX request (di production, ganti dengan fetch/axios)
  setTimeout(() => {
    // Ambil nilai dari form
    const formData = {
      id: document.getElementById('memberIdToEdit').value,
      nama: document.getElementById('editNamaMember').value,
      telepon: document.getElementById('editTeleponMember').value,
      email: document.getElementById('editEmailMember').value,
      alamat: document.getElementById('editAlamatMember').value,
      jenis_kelamin: document.getElementById('editJenisKelamin').value
    };
    
    console.log('Data member yang akan diupdate:', formData);
    
    // Tutup modal
    closeModalEdit();
    
    // Tampilkan alert sukses
    showAlert('success', 'Data member berhasil diperbarui!');
    
    // Kembalikan tombol ke state semula
    btnEdit.innerHTML = originalText;
    btnEdit.disabled = false;
  }, 1500);
}

// Event listener untuk tombol edit
document.getElementById('btnEditMember').addEventListener('click', submitEditForm);

// Event listener untuk form (submit saat tekan enter)
document.querySelectorAll('#modalEditMember input').forEach(input => {
  input.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
      submitEditForm();
    }
  });
});
</script>