<div id="editMemberModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div
      class="bg-white rounded-md shadow-lg w-[360px] p-6 relative font-sans"
      role="dialog"
      aria-modal="true"
      aria-labelledby="modal-title"
    >
      <button
        onclick="closeModal('editMemberModal')"
        aria-label="Close"
        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none"
      >
        <i class="fas fa-times text-sm"></i>
      </button>
      <h2
        id="modal-title"
        class="font-semibold text-black text-base leading-5 mb-1"
      >
        Edit Member
      </h2>
      <p class="text-gray-500 text-xs leading-4 mb-5">
        Edit detail member di bawah ini.
      </p>
      <form class="space-y-3">
        <div class="flex items-center">
          <label
            for="edit-nama"
            class="w-24 text-xs text-black font-normal leading-4"
            >Nama</label
          >
          <input
            id="edit-nama"
            type="text"
            placeholder="Nama member"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="edit-telp"
            class="w-24 text-xs text-black font-normal leading-4"
            >Telp</label
          >
          <input
            id="edit-telp"
            type="text"
            placeholder="No. telp member"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="edit-email"
            class="w-24 text-xs text-black font-normal leading-4"
            >Email</label
          >
          <input
            id="edit-email"
            type="email"
            placeholder="Email member (opsional)"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="edit-alamat"
            class="w-24 text-xs text-black font-normal leading-4"
            >Alamat</label
          >
          <input
            id="edit-alamat"
            type="text"
            placeholder="Alamat member (opsional)"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="edit-gender"
            class="w-24 text-xs text-black font-normal leading-4"
            >Jenis Kelamin</label
          >
          <select
            id="edit-gender"
            class="flex-1 border border-orange-500 rounded-md text-xs text-black px-3 py-2 focus:outline-none"
          >
            <option selected disabled>Pilih gender</option>
            <option>Laki-laki</option>
            <option>Perempuan</option>
          </select>
        </div>
        <div class="flex justify-end space-x-3 mt-5">
          <button
            type="button"
            onclick="closeModal('editMemberModal')"
            class="text-xs text-black font-normal leading-4 px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 focus:outline-none"
          >
            Batal
          </button>
          <button
            type="submit"
            class="text-xs font-semibold leading-4 px-4 py-2 rounded-md bg-orange-500 text-white hover:bg-orange-600 focus:outline-none"
          >
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>