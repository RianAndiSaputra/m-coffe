<!-- Modal Edit Outlet -->
<div id="modalEditOutlet" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalEdit()">
  <div
    class="bg-white w-full max-w-4xl rounded-xl shadow-lg max-h-screen flex flex-col"
    onclick="event.stopPropagation()"
  >
    <!-- Header -->
    <div class="p-6 border-b">
      <h2 class="text-xl font-semibold">Edit Outlet</h2>
      <p class="text-sm text-gray-500">Perbarui informasi outlet sesuai kebutuhan.</p>
    </div>

    <!-- Scrollable Content -->
    <div class="overflow-y-auto p-6 space-y-6 flex-1">

      <!-- Hidden ID field -->
      <input type="hidden" id="outletIdToEdit" value="">

      <!-- Informasi Dasar -->
      <div class="p-5 border rounded-lg shadow-sm bg-gray-50">
        <h3 class="font-semibold mb-4 text-gray-700">Informasi Dasar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Nama Outlet</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" id="editNamaOutlet" placeholder="Masukkan nama outlet">
          </div>
          <div>
            <label class="block font-medium mb-1">Nomor Telepon</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" id="editNomorTelepon" placeholder="Masukkan nomor telepon">
          </div>
          <div class="md:col-span-2">
            <label class="block font-medium mb-1">Alamat Lengkap</label>
            <textarea class="w-full border rounded-lg px-4 py-2 text-sm" id="editAlamatLengkap" placeholder="Masukkan alamat lengkap"></textarea>
          </div>
        </div>
      </div>

      <!-- Informasi Tambahan -->
      <div class="p-5 border rounded-lg shadow-sm bg-gray-50">
        <h3 class="font-semibold mb-4 text-gray-700">Informasi Tambahan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Email</label>
            <input type="email" class="w-full border rounded-lg px-4 py-2 text-sm" id="editEmail" placeholder="Masukkan email">
          </div>
          <div>
            <label class="block font-medium mb-1">Persentase Pajak (%)</label>
            <input type="number" class="w-full border rounded-lg px-4 py-2 text-sm" id="editPersentasePajak" placeholder="0%">
          </div>
        </div>
      </div>

      <!-- Nomor Transaksi -->
      <div class="p-5 border rounded-lg shadow-sm bg-gray-50">
        <h3 class="font-semibold mb-4 text-gray-700">Nomor Transaksi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Nomor Transaksi Default</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" id="editNoTransaksi" placeholder="Contoh: 001">
          </div>
          <div>
            <label class="block font-medium mb-1">Nama Bank</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" id="editNamaBank" placeholder="Contoh: BCA">
          </div>
          <div class="md:col-span-2">
            <label class="block font-medium mb-1">Atas Nama</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm" id="editAtasNama" placeholder="Nama pemilik rekening">
          </div>
        </div>
      </div>

      <!-- Foto Outlet -->
      <div class="p-5 border rounded-lg shadow-sm bg-gray-50">
        <label class="block font-medium mb-1">Foto Outlet</label>
        <div class="mb-2">
          <p class="text-sm text-gray-600 mb-1">Foto saat ini:</p>
          <div class="h-24 w-24 bg-gray-200 rounded flex items-center justify-center">
            <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
          </div>
        </div>
        <label class="block font-medium mb-1">Ganti Foto</label>
        <input type="file" class="w-full text-sm">
        <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG. Ukuran maksimal: 2MB</p>
      </div>

      <!-- Status Aktif -->
      <div class="p-5 border rounded-lg shadow-sm bg-gray-50">
        <h3 class="font-semibold mb-4 text-gray-700">Status Aktif</h3>
        <div class="flex items-center gap-3">
          <label class="font-medium text-gray-700">Aktifkan Outlet</label>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer" id="editStatusAktif">
            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-orange-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:left-[calc(100%-1.25rem)]"></div>
          </label>
          <span class="text-sm text-gray-500">Outlet muncul jika aktif</span>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="p-6 border-t flex justify-end gap-3">
      <button id="btnBatalModalEdit" class="px-4 py-2 border rounded hover:bg-gray-100">Batal</button>
      <button class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Simpan Perubahan</button>
    </div>
  </div>
</div>
