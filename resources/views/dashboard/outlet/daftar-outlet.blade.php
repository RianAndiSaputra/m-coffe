@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manajemen Member</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  />
</head>
<body class="bg-white text-gray-900 font-sans">
  <!-- Modal Tambah Member -->
  <div id="tambahMemberModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div
      class="bg-white rounded-md shadow-lg w-[360px] p-6 relative font-sans"
      role="dialog"
      aria-modal="true"
      aria-labelledby="modal-title"
    >
      <button
        onclick="closeModal('tambahMemberModal')"
        aria-label="Close"
        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none"
      >
        <i class="fas fa-times text-sm"></i>
      </button>
      <h2
        id="modal-title"
        class="font-semibold text-black text-base leading-5 mb-1"
      >
        Tambah Member Baru
      </h2>
      <p class="text-gray-500 text-xs leading-4 mb-5">
        Tambahkan member baru dengan mengisi detail di bawah ini.
      </p>
      <form class="space-y-3">
        <div class="flex items-center">
          <label
            for="nama"
            class="w-24 text-xs text-black font-normal leading-4"
            >Nama</label
          >
          <input
            id="nama"
            type="text"
            placeholder="Nama member"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="telp"
            class="w-24 text-xs text-black font-normal leading-4"
            >Telp</label
          >
          <input
            id="telp"
            type="text"
            placeholder="No. telp member"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="email"
            class="w-24 text-xs text-black font-normal leading-4"
            >Email</label
          >
          <input
            id="email"
            type="email"
            placeholder="Email member (opsional)"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="alamat"
            class="w-24 text-xs text-black font-normal leading-4"
            >Alamat</label
          >
          <input
            id="alamat"
            type="text"
            placeholder="Alamat member (opsional)"
            class="flex-1 border border-gray-300 rounded-md text-xs text-gray-400 placeholder-gray-400 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-orange-500"
          />
        </div>
        <div class="flex items-center">
          <label
            for="gender"
            class="w-24 text-xs text-black font-normal leading-4"
            >Jenis Kelamin</label
          >
          <select
            id="gender"
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
            onclick="closeModal('tambahMemberModal')"
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

  <!-- Modal Edit Member -->
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

  <div class="max-w-full p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-xl font-extrabold leading-tight">Manajemen Member</h1>
      <button
        type="button"
        onclick="openModal('tambahMemberModal')"
        class="flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold px-4 py-2 rounded transition"
      >
        <i class="fas fa-plus"></i>
        Tambah Member
      </button>
    </div>

    <div class="border border-gray-200 rounded-md p-5 bg-white">
      <h2 class="text-lg font-bold mb-1">Daftar Member</h2>
      <p class="text-xs text-gray-500 mb-4">Kelola member</p>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-gray-700 text-xs sm:text-sm">
          <thead>
            <tr class="border-b border-gray-300">
              <th class="pb-3 pr-6 pt-1 font-normal" style="min-width: 140px;">
                Nama
              </th>
              <th class="pb-3 pr-6 pt-1 font-normal" style="min-width: 90px;">
                Kode<br />Member
              </th>
              <th class="pb-3 pr-6 pt-1 font-normal" style="min-width: 160px;">
                Email
              </th>
              <th class="pb-3 pr-6 pt-1 font-normal" style="min-width: 200px;">
                Alamat
              </th>
              <th class="pb-3 pr-6 pt-1 font-normal" style="min-width: 90px;">
                Jenis<br />Kelamin
              </th>
              <th class="pb-3 pr-6 pt-1 font-normal" style="min-width: 90px;">
                Total<br />transaksi
              </th>
              <th class="pb-3 pt-1 font-normal text-center" style="min-width: 40px;">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-gray-200">
              <td class="py-3 pr-6 align-top">
                <p class="font-semibold text-[13px] leading-tight">Dr. Buck Stracke I</p>
                <p class="text-[10px] text-gray-500 leading-tight mt-0.5">347-807-8340</p>
              </td>
              <td class="py-3 pr-6 align-top font-mono text-[13px] leading-tight">MEM-EOHDH5</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">xpacocha@example.com</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">
                42422 Reynolds Brook Suite 172 Lake Shanny, ID 26497
              </td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">Laki-laki</td>
              <td class="py-3 pr-6 align-top font-semibold text-[13px] leading-tight">2</td>
              <td class="py-3 align-top text-center relative">
                <div class="dropdown-container inline-block">
                  <button onclick="toggleDropdown(this)" class="text-[20px] cursor-pointer select-none">...</button>
                  <div class="dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200" 
                       style="bottom: full">
                    <button onclick="openModal('editMemberModal')" class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">Edit</button>
                    <button class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-gray-100">Hapus</button>
                  </div>
                </div>
              </td>
            </tr>

            <tr class="border-b border-gray-200">
              <td class="py-3 pr-6 align-top">
                <p class="font-semibold text-[13px] leading-tight">Ms. Lacey Crona PhD</p>
                <p class="text-[10px] text-gray-500 leading-tight mt-0.5">+1-815-249-1548</p>
              </td>
              <td class="py-3 pr-6 align-top font-mono text-[13px] leading-tight">MEM-IPWEYN</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">cdietrich@example.com</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">
                967 Neoma Wells Suite 360 Janiceport, OR 25723
              </td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">Perempuan</td>
              <td class="py-3 pr-6 align-top font-semibold text-[13px] leading-tight">1</td>
              <td class="py-3 align-top text-center relative">
                <div class="dropdown-container inline-block">
                  <button onclick="toggleDropdown(this)" class="text-[20px] cursor-pointer select-none">...</button>
                  <div class="dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200" 
                       style="bottom: full">
                    <button onclick="openModal('editMemberModal')" class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">Edit</button>
                    <button class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-gray-100">Hapus</button>
                  </div>
                </div>
              </td>
            </tr>

            <tr class="border-b border-gray-200">
              <td class="py-3 pr-6 align-top">
                <p class="font-semibold text-[13px] leading-tight">Zena Ondricka DDS</p>
                <p class="text-[10px] text-gray-500 leading-tight mt-0.5">(423) 834-2351</p>
              </td>
              <td class="py-3 pr-6 align-top font-mono text-[13px] leading-tight">MEM-CLPXLD</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">kconnelly@example.net</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">
                48900 Bauch Forge Hammesmouth, ME 58939
              </td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">Perempuan</td>
              <td class="py-3 pr-6 align-top font-semibold text-[13px] leading-tight">1</td>
              <td class="py-3 align-top text-center relative">
                <div class="dropdown-container inline-block">
                  <button onclick="toggleDropdown(this)" class="text-[20px] cursor-pointer select-none">...</button>
                  <div class="dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200" 
                       style="bottom: full">
                    <button onclick="openModal('editMemberModal')" class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">Edit</button>
                    <button class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-gray-100">Hapus</button>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td class="py-3 pr-6 align-top">
                <p class="font-semibold text-[13px] leading-tight">Katherine McDermott</p>
                <p class="text-[10px] text-gray-500 leading-tight mt-0.5">(951) 664-0233</p>
              </td>
              <td class="py-3 pr-6 align-top font-mono text-[13px] leading-tight">MEM-G4UFTK</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">arno27@example.org</td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">
                211 Vern Isle South Princessfort, AR 59258-5476
              </td>
              <td class="py-3 pr-6 align-top text-[13px] leading-tight">Perempuan</td>
              <td class="py-3 pr-6 align-top font-semibold text-[13px] leading-tight">1</td>
              <td class="py-3 align-top text-center relative">
                <div class="dropdown-container inline-block">
                  <button onclick="toggleDropdown(this)" class="text-[20px] cursor-pointer select-none">...</button>
                  <div class="dropdown-menu hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200" 
                       style="bottom: full">
                    <button onclick="openModal('editMemberModal')" class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">Edit</button>
                    <button class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-gray-100">Hapus</button>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Fungsi untuk membuka modal
    function openModal(modalId) {
      document.getElementById(modalId).classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
      document.getElementById(modalId).classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    // Fungsi untuk toggle dropdown aksi
    function toggleDropdown(button) {
    const dropdownMenu = button.nextElementSibling;
    const isOpen = !dropdownMenu.classList.contains('hidden');
    
    // Tutup semua dropdown yang terbuka
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
    });
    
    if (!isOpen) {
        // Cek posisi relatif terhadap viewport
        const rect = button.getBoundingClientRect();
        const spaceBelow = window.innerHeight - rect.bottom;
        const dropdownHeight = 64; // Tinggi dropdown (2 item x 32px)
        
        // Jika tidak cukup space di bawah, tampilkan ke atas
        if (spaceBelow < dropdownHeight) {
        dropdownMenu.style.bottom = '-100%';
        // dropdownMenu.style.top = 'auto';
        dropdownMenu.style.mt = '0';
        dropdownMenu.style.mb = '2';
        } else {
        dropdownMenu.style.top = '-100%';
        // dropdownMenu.style.bottom = 'auto';
        dropdownMenu.style.mt = '2';
        dropdownMenu.style.mb = '0';
        }
        
        dropdownMenu.classList.remove('hidden');
    }
    }

    // Tutup dropdown ketika klik di luar
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.dropdown-container')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          menu.classList.add('hidden');
        });
      }
    });
  </script>
</body>
</html>

@endsection