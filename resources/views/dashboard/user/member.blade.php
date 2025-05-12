@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Member Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            orange: {
              500: '#f97316',
              600: '#ea580c',
            }
          }
        }
      }
    }
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/2.0.0/lucide.min.css" rel="stylesheet">
</head>
<body class="bg-white">
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col space-y-4">
      <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold">Manajemen Member</h2>
        <button id="addMemberBtn" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md flex items-center">
          <i data-lucide="plus" class="mr-2 h-4 w-4"></i> Tambah Member
        </button>
      </div>

      <!-- Add/Edit Dialog -->
      <div id="memberDialog" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 p-6">
          <h3 id="dialogTitle" class="text-xl font-bold mb-2">Tambah Member Baru</h3>
          <p id="dialogDescription" class="text-gray-600 mb-4">Tambahkan member baru dengan mengisi detail di bawah ini.</p>
          
          <form id="memberForm" class="space-y-4">
            <div class="grid grid-cols-4 gap-4 items-center">
              <label class="text-right">Nama</label>
              <input id="name" name="name" required class="col-span-3 border rounded px-3 py-2">
            </div>
            
            <div id="memberCodeField" class="grid grid-cols-4 gap-4 items-center hidden">
              <label class="text-right">Kode</label>
              <input id="member_code" disabled class="col-span-3 border rounded px-3 py-2 bg-gray-100">
            </div>
            
            <div class="grid grid-cols-4 gap-4 items-center">
              <label class="text-right">Telp</label>
              <input id="phone" name="phone" required type="tel" class="col-span-3 border rounded px-3 py-2">
            </div>
            
            <div class="grid grid-cols-4 gap-4 items-center">
              <label class="text-right">Email</label>
              <input id="email" name="email" type="email" class="col-span-3 border rounded px-3 py-2">
            </div>
            
            <div class="grid grid-cols-4 gap-4 items-center">
              <label class="text-right">Alamat</label>
              <input id="address" name="address" class="col-span-3 border rounded px-3 py-2">
            </div>
            
            <div class="grid grid-cols-4 gap-4 items-center">
              <label class="text-right">Jenis Kelamin</label>
              <select id="gender" required class="col-span-3 border rounded px-3 py-2">
                <option value="" disabled selected>Pilih gender</option>
                <option value="male">Laki-laki</option>
                <option value="female">Perempuan</option>
              </select>
            </div>
            
            <div class="flex justify-end space-x-2 pt-4">
              <button type="button" id="cancelBtn" class="px-4 py-2 border rounded-md">Batal</button>
              <button type="submit" id="submitBtn" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Delete Dialog -->
      <div id="deleteDialog" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4 p-6">
          <h3 class="text-xl font-bold mb-2">Konfirmasi Hapus</h3>
          <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menghapus member ini? Tindakan ini tidak dapat dibatalkan.</p>
          
          <div id="memberToDelete" class="hidden mb-4 flex items-center gap-3">
            <div>
              <div id="deleteMemberName" class="font-medium"></div>
              <div id="deleteMemberEmail" class="text-sm text-gray-500"></div>
            </div>
          </div>
          
          <div class="flex justify-end space-x-2">
            <button id="cancelDeleteBtn" class="px-4 py-2 border rounded-md">Batal</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
              Hapus Member
            </button>
          </div>
        </div>
      </div>

      <!-- Member Table -->
      <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
          <h3 class="text-2xl font-bold">Daftar Member</h3>
          <p class="text-gray-600">Kelola member</p>
        </div>
        
        <div class="px-6 pb-6">
          <div class="overflow-visibl">
            <table class="w-full">
              <thead>
                <tr class="border-b text-left">
                  <th class="p-4">Nama</th>
                  <th class="p-4">Kode Member</th>
                  <th class="p-4">Email</th>
                  <th class="p-4">Alamat</th>
                  <th class="p-4">Jenis Kelamin</th>
                  <th class="p-4">Total transaksi</th>
                  <th class="p-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody id="memberTableBody">
                <!-- Data Member 1 -->
                <tr class="border-b hover:bg-gray-50" data-member-id="1">
                  <td class="p-4">
                    <div class="font-medium">John Doe</div>
                    <div class="text-sm text-gray-500">08123456789</div>
                  </td>
                  <td class="p-4">MEM001</td>
                  <td class="p-4">john@example.com</td>
                  <td class="p-4">Jl. Contoh No. 123</td>
                  <td class="p-4">Laki-laki</td>
                  <td class="p-4">5</td>
                  <td class="py-4 relative">
                    <div class="relative inline-block">
                      <button onclick="toggleDropdown(this)" class="p-2 hover:bg-gray-100 rounded-lg">
                        <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                      </button>
                      <div class="absolute top-full right-0 mt-2 z-50 hidden w-40 bg-white border border-gray-200 rounded-md shadow-lg" data-dropdown="1">
                        <div class="py-1">
                        <h1 class="font-bold text-left px-4 py-2">Aksi</h1>
                        <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                            <i data-lucide="history" class="inline mr-2 w-4 h-4"></i> History
                        </button>
                        <button data-edit="1" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                            <i data-lucide="edit" class="inline mr-2 w-4 h-4"></i> Edit
                        </button>
                        <div class="border-t border-gray-200 my-1"></div>
                        <button data-delete="1" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i data-lucide="trash-2" class="inline mr-2 w-4 h-4"></i> Hapus
                        </button>
                        </div>
                    </div>
                    </div>
                  </td>
                </tr>
                
                <!-- Data Member 2 -->
                {{-- <tr class="border-b hover:bg-gray-50" data-member-id="2">
                  <td class="p-4">
                    <div class="font-medium">Jane Smith</div>
                    <div class="text-sm text-gray-500">08234567890</div>
                  </td>
                  <td class="p-4">MEM002</td>
                  <td class="p-4">jane@example.com</td>
                  <td class="p-4">Jl. Sample No. 456</td>
                  <td class="p-4">Perempuan</td>
                  <td class="p-4">3</td>
                  <td class="p-4 text-right">
                    <div class="relative inline-block">
                      <button class="p-1 rounded hover:bg-gray-200" data-member-id="2">
                        <i data-lucide="more-horizontal"></i>
                      </button>
                      <div class="absolute right-0 z-10 hidden w-40 mt-1 bg-white border rounded shadow-lg" data-dropdown="2">
                        <div class="py-1">
                          <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                            <i data-lucide="history" class="inline mr-2 w-4 h-4"></i> Transaksi
                          </a>
                          <button data-edit="2" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                            <i data-lucide="edit" class="inline mr-2 w-4 h-4"></i> Edit
                          </button>
                          <div class="border-t my-1"></div>
                          <button data-delete="2" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i data-lucide="trash-2" class="inline mr-2 w-4 h-4"></i> Hapus
                          </button>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr> --}}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!e.target.closest('.dropdown-menu') && !e.target.closest('button')) {
      document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.add('hidden');
      });
    }
      // Inisialisasi ikon Lucide
      lucide.createIcons();
      
      // Elemen DOM
      const memberDialog = document.getElementById('memberDialog');
      const deleteDialog = document.getElementById('deleteDialog');
      const memberForm = document.getElementById('memberForm');
      const nameField = document.getElementById('name');
      const memberCodeField = document.getElementById('memberCodeField');
      const memberCodeInput = document.getElementById('member_code');
      const phoneField = document.getElementById('phone');
      const emailField = document.getElementById('email');
      const addressField = document.getElementById('address');
      const genderField = document.getElementById('gender');
      const deleteMemberName = document.getElementById('deleteMemberName');
      const deleteMemberEmail = document.getElementById('deleteMemberEmail');
      
      let currentMemberId = null;
      let isEditMode = false;

      // Event listener untuk tombol tambah member
      document.getElementById('addMemberBtn').addEventListener('click', () => {
        isEditMode = false;
        currentMemberId = null;
        resetForm();
        document.getElementById('dialogTitle').textContent = 'Tambah Member Baru';
        document.getElementById('dialogDescription').textContent = 'Tambahkan member baru dengan mengisi detail di bawah ini.';
        memberCodeField.classList.add('hidden');
        document.getElementById('submitBtn').textContent = 'Simpan';
        memberDialog.classList.remove('hidden');
      });

      // Event listener untuk tombol edit
      document.querySelectorAll('[data-edit]').forEach(btn => {
        btn.addEventListener('click', function() {
          const memberId = parseInt(this.getAttribute('data-edit'));
          const memberRow = document.querySelector(`[data-member-id="${memberId}"]`);
          
          // Ambil data dari row tabel
          const memberData = {
            id: memberId,
            name: memberRow.querySelector('td:nth-child(1) div.font-medium').textContent,
            member_code: memberRow.querySelector('td:nth-child(2)').textContent,
            phone: memberRow.querySelector('td:nth-child(1) div.text-sm').textContent,
            email: memberRow.querySelector('td:nth-child(3)').textContent,
            address: memberRow.querySelector('td:nth-child(4)').textContent,
            gender: memberRow.querySelector('td:nth-child(5)').textContent === 'Laki-laki' ? 'male' : 'female'
          };
          
          isEditMode = true;
          currentMemberId = memberId;
          populateForm(memberData);
          document.getElementById('dialogTitle').textContent = 'Edit Member';
          document.getElementById('dialogDescription').textContent = 'Edit informasi member';
          memberCodeField.classList.remove('hidden');
          document.getElementById('submitBtn').textContent = 'Simpan Perubahan';
          memberDialog.classList.remove('hidden');
        });
      });

      // Event listener untuk tombol hapus
      document.querySelectorAll('[data-delete]').forEach(btn => {
        btn.addEventListener('click', function() {
          const memberId = parseInt(this.getAttribute('data-delete'));
          const memberRow = document.querySelector(`[data-member-id="${memberId}"]`);
          
          const memberData = {
            name: memberRow.querySelector('td:nth-child(1) div.font-medium').textContent,
            email: memberRow.querySelector('td:nth-child(3)').textContent
          };
          
          currentMemberId = memberId;
          deleteMemberName.textContent = memberData.name;
          deleteMemberEmail.textContent = memberData.email;
          document.getElementById('memberToDelete').classList.remove('hidden');
          deleteDialog.classList.remove('hidden');
        });
      });

      function toggleDropdown(button) {
    // Tutup dropdown lain dulu
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      if (!menu.contains(button)) menu.classList.add('hidden');
    });

    // Toggle dropdown saat ini
    const dropdown = button.nextElementSibling;
    dropdown.classList.toggle('hidden');
  }


      // Fungsi isi form
      function populateForm(member) {
        nameField.value = member.name || '';
        memberCodeInput.value = member.member_code || '';
        phoneField.value = member.phone || '';
        emailField.value = member.email || '';
        addressField.value = member.address || '';
        genderField.value = member.gender || '';
      }

      // Fungsi reset form
      function resetForm() {
        nameField.value = '';
        memberCodeInput.value = '';
        phoneField.value = '';
        emailField.value = '';
        addressField.value = '';
        genderField.value = '';
      }

      // Submit form
      memberForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert(isEditMode ? 'Perubahan disimpan' : 'Member baru ditambahkan');
        memberDialog.classList.add('hidden');
      });

      // Konfirmasi hapus
      document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        alert('Member berhasil dihapus');
        deleteDialog.classList.add('hidden');
      });

      // Tombol batal
      document.getElementById('cancelBtn').addEventListener('click', () => memberDialog.classList.add('hidden'));
      document.getElementById('cancelDeleteBtn').addEventListener('click', () => deleteDialog.classList.add('hidden'));

      // Tutup dropdown saat klik di luar
      document.addEventListener('click', () => {
        document.querySelectorAll('[data-dropdown]').forEach(d => d.classList.add('hidden'));
      });

      // Toggle dropdown
      document.querySelectorAll('[data-member-id]').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.stopPropagation();
          const memberId = this.getAttribute('data-member-id');
          const dropdown = document.querySelector(`[data-dropdown="${memberId}"]`);
          dropdown.classList.toggle('hidden');
        });
      });
    });
  </script>
</body>
</html>
@endsection