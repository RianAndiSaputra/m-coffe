<!-- Modal Edit Staff -->
<div id="modalEditStaff" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalEditStaff()">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg max-h-screen flex flex-col" onclick="event.stopPropagation()">
      
      <!-- Header -->
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Edit Staff</h2>
        <p class="text-sm text-gray-500">Edit informasi staff dan update data wajah untuk Face ID</p>
      </div>
  
      <!-- Scrollable Content -->
      <div class="overflow-y-auto p-6 space-y-6 flex-1">
        <div class="space-y-4">
          <!-- Nama Staff -->
          <div>
            <label class="block font-medium mb-1 text-gray-700">Nama <span class="text-red-500">*</span></label>
            <input type="text" id="editNamaStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="Nama staff" required>
            <p id="errorEditNamaStaff" class="text-red-500 text-xs mt-1 hidden">Nama staff wajib diisi</p>
          </div>
  
          <!-- Email Staff -->
          <div>
            <label class="block font-medium mb-1 text-gray-700">Email <span class="text-red-500">*</span></label>
            <input type="email" id="editEmailStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="Email staff" required>
            <p id="errorEditEmailStaff" class="text-red-500 text-xs mt-1 hidden">Email wajib diisi dan valid</p>
          </div>
  
          <!-- Password -->
          <div>
            <label class="block font-medium mb-1 text-gray-700">Password</label>
            <input type="password" id="editPasswordStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="Kosongkan jika tidak ingin mengubah">
            <p id="errorEditPasswordStaff" class="text-red-500 text-xs mt-1 hidden">Password minimal 8 karakter</p>
          </div>
  
          <!-- Peran -->
          <div>
            <label class="block font-medium mb-1 text-gray-700">Peran <span class="text-red-500">*</span></label>
            <select id="editPeranStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" required>
              <option value="" disabled>Pilih peran</option>
              <option value="kasir">Kasir</option>
              <option value="supervisor">Supervisor</option>
              <option value="admin">Admin</option>
              <option value="manajer">Manajer</option>
            </select>
            <p id="errorEditPeranStaff" class="text-red-500 text-xs mt-1 hidden">Peran wajib dipilih</p>
          </div>
  
          <!-- Shift -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium mb-1 text-gray-700">Waktu Mulai</label>
              <input type="time" id="editWaktuMulai" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="--.--">
            </div>
            <div>
              <label class="block font-medium mb-1 text-gray-700">Waktu Selesai</label>
              <input type="time" id="editWaktuSelesai" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="--.--">
            </div>
          </div>
  
          <!-- Outlet -->
          <div>
            <label class="block font-medium mb-1 text-gray-700">Outlet</label>
            <select id="editOutletStaff" data-url="{{ url('/api/outlets') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
              <option value="" disabled selected>Memuat outlet...</option>
            </select>
            <p id="errorEditOutletStaff" class="text-red-500 text-xs mt-1 hidden">Outlet wajib dipilih</p>
          </div>

          <!-- Face ID Update Section -->
          <div class="border-t pt-6 mt-6">
            <div class="flex items-center justify-between mb-4">
              <div>
                <label class="block font-medium mb-1 text-gray-700">Update Wajah untuk Face ID</label>
                <p class="text-sm text-gray-500">Update foto wajah staff untuk sistem Face ID login</p>
              </div>
              <div class="flex items-center">
                <span id="editFaceRegistrationStatus" class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">Status: Belum diupdate</span>
              </div>
            </div>

            <!-- Current Face Preview -->
            <div id="currentFacePreview" class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200 hidden">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center border-2 border-green-200">
                    <i data-lucide="user" class="w-6 h-6 text-green-600"></i>
                  </div>
                  <div>
                    <p class="font-medium text-gray-800">Wajah Saat Ini</p>
                    <p class="text-xs text-gray-600">Wajah yang terdaftar di sistem</p>
                  </div>
                </div>
                <button type="button" id="btnViewCurrentFace" class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                  Lihat
                </button>
              </div>
            </div>

            <!-- Face Capture Area -->
            <div id="editFaceCaptureSection" class="space-y-4">
              <div class="bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-300">
                <div class="text-center">
                  <!-- Camera Preview -->
                  <div class="relative mx-auto w-full max-w-xs h-48 bg-black rounded-lg overflow-hidden mb-4">
                    <video id="editFacePreview" class="w-full h-full object-cover" autoplay playsinline></video>
                    <canvas id="editFaceCanvas" class="hidden"></canvas>
                    <div id="editFaceScanningOverlay" class="absolute inset-0 bg-gradient-to-b from-green-500/20 to-transparent animate-pulse hidden"></div>
                  </div>

                  <!-- Capture Controls -->
                  <div class="flex justify-center space-x-3">
                    <button type="button" id="editBtnStartCamera" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                      <i data-lucide="camera" class="w-4 h-4"></i>
                      <span>Mulai Kamera</span>
                    </button>
                    <button type="button" id="editBtnCaptureFace" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 hidden">
                      <i data-lucide="aperture" class="w-4 h-4"></i>
                      <span>Ambil Foto Baru</span>
                    </button>
                    <button type="button" id="editBtnRetryCapture" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2 hidden">
                      <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                      <span>Ulangi</span>
                    </button>
                  </div>

                  <!-- Status Message -->
                  <div id="editFaceCaptureStatus" class="mt-3 text-sm">
                    <p class="text-gray-600">Klik "Mulai Kamera" untuk mengambil foto wajah baru</p>
                  </div>
                </div>
              </div>

              <!-- New Face Preview -->
              <div id="editCapturedFacePreview" class="hidden">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                  <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                      <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                      <p class="font-medium text-green-800">Wajah Baru Berhasil Diambil</p>
                      <p class="text-xs text-green-600">Klik simpan untuk update data wajah</p>
                    </div>
                  </div>
                  <button type="button" id="editBtnRemoveFace" class="text-red-600 hover:text-red-700">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Help Text -->
            <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
              <div class="flex items-start space-x-2">
                <i data-lucide="info" class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"></i>
                <div>
                  <p class="text-sm text-blue-800 font-medium">Tips Foto Wajah yang Baik:</p>
                  <ul class="text-xs text-blue-700 mt-1 space-y-1">
                    <li>• Pastikan pencahayaan cukup</li>
                    <li>• Wajah menghadap lurus ke kamera</li>
                    <li>• Hindari menggunakan topi atau kacamata hitam</li>
                    <li>• Ekspresi wajah netral</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Footer -->
      <div class="p-6 border-t flex justify-end gap-3">
        <button id="btnBatalModalEditStaff" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-gray-700">Batal</button>
        <button id="btnSimpanEditStaff" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i>
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </div>
</div>

<script>
// Edit Staff Face ID Functionality
let editFaceStream = null;
let editCapturedFaceData = null;
let currentStaffId = null;

// Function to open edit modal with staff data
function openEditStaffModal(staffData) {
    currentStaffId = staffData.id;
    
    // Fill form with existing data
    document.getElementById('editNamaStaff').value = staffData.name || '';
    document.getElementById('editEmailStaff').value = staffData.email || '';
    document.getElementById('editPeranStaff').value = staffData.role || '';
    document.getElementById('editWaktuMulai').value = staffData.shift_start || '';
    document.getElementById('editWaktuSelesai').value = staffData.shift_end || '';
    document.getElementById('editOutletStaff').value = staffData.outlet_id || '';
    
    // Handle face data status
    const faceStatus = document.getElementById('editFaceRegistrationStatus');
    const currentFacePreview = document.getElementById('currentFacePreview');
    
    if (staffData.has_face_data) {
        faceStatus.textContent = 'Status: Sudah terdaftar';
        faceStatus.className = 'text-xs px-2 py-1 rounded-full bg-green-100 text-green-600';
        currentFacePreview.classList.remove('hidden');
    } else {
        faceStatus.textContent = 'Status: Belum terdaftar';
        faceStatus.className = 'text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-600';
        currentFacePreview.classList.add('hidden');
    }
    
    // Reset face capture section
    resetEditFaceCapture();
    
    // Show modal
    document.getElementById('modalEditStaff').classList.remove('hidden');
}

// Reset face capture section
function resetEditFaceCapture() {
    editCapturedFaceData = null;
    document.getElementById('editBtnStartCamera').classList.remove('hidden');
    document.getElementById('editBtnCaptureFace').classList.add('hidden');
    document.getElementById('editBtnRetryCapture').classList.add('hidden');
    document.getElementById('editCapturedFacePreview').classList.add('hidden');
    document.getElementById('editFaceCaptureStatus').innerHTML = '<p class="text-gray-600">Klik "Mulai Kamera" untuk mengambil foto wajah baru</p>';
    
    // Stop camera if running
    if (editFaceStream) {
        editFaceStream.getTracks().forEach(track => track.stop());
        editFaceStream = null;
    }
}

// Initialize edit face capture functionality
document.addEventListener('DOMContentLoaded', function() {
    const startCameraBtn = document.getElementById('editBtnStartCamera');
    const captureFaceBtn = document.getElementById('editBtnCaptureFace');
    const retryCaptureBtn = document.getElementById('editBtnRetryCapture');
    const removeFaceBtn = document.getElementById('editBtnRemoveFace');
    const facePreview = document.getElementById('editFacePreview');
    const faceCanvas = document.getElementById('editFaceCanvas');
    const faceScanningOverlay = document.getElementById('editFaceScanningOverlay');
    const faceCaptureStatus = document.getElementById('editFaceCaptureStatus');
    const capturedFacePreview = document.getElementById('editCapturedFacePreview');
    const viewCurrentFaceBtn = document.getElementById('btnViewCurrentFace');

    // Start Camera
    startCameraBtn.addEventListener('click', async function() {
        try {
            editFaceStream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: 640, 
                    height: 480,
                    facingMode: 'user'
                } 
            });
            
            facePreview.srcObject = editFaceStream;
            startCameraBtn.classList.add('hidden');
            captureFaceBtn.classList.remove('hidden');
            faceCaptureStatus.innerHTML = '<p class="text-green-600">Posisikan wajah di dalam frame dan klik "Ambil Foto Baru"</p>';
            
        } catch (error) {
            console.error('Error accessing camera:', error);
            faceCaptureStatus.innerHTML = '<p class="text-red-600">Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.</p>';
        }
    });

    // Capture Face
    captureFaceBtn.addEventListener('click', function() {
        faceScanningOverlay.classList.remove('hidden');
        faceCaptureStatus.innerHTML = '<p class="text-blue-600">Menganalisis wajah...</p>';

        const context = faceCanvas.getContext('2d');
        faceCanvas.width = facePreview.videoWidth;
        faceCanvas.height = facePreview.videoHeight;
        context.drawImage(facePreview, 0, 0, faceCanvas.width, faceCanvas.height);

        setTimeout(() => {
            faceScanningOverlay.classList.add('hidden');
            
            faceCanvas.toBlob(function(blob) {
                editCapturedFaceData = blob;
                
                captureFaceBtn.classList.add('hidden');
                retryCaptureBtn.classList.remove('hidden');
                capturedFacePreview.classList.remove('hidden');
                faceCaptureStatus.innerHTML = '<p class="text-green-600">Wajah baru berhasil diambil dan siap diupdate</p>';
                
                if (editFaceStream) {
                    editFaceStream.getTracks().forEach(track => track.stop());
                }
            }, 'image/jpeg', 0.8);
        }, 2000);
    });

    // Retry Capture
    retryCaptureBtn.addEventListener('click', function() {
        resetEditFaceCapture();
    });

    // Remove New Face
    removeFaceBtn.addEventListener('click', function() {
        resetEditFaceCapture();
    });

    // View Current Face
    viewCurrentFaceBtn.addEventListener('click', function() {
        // In real implementation, fetch and show current face image
        alert('Menampilkan foto wajah saat ini...');
        // You can implement a modal to show the current face image
    });

    // Save Edit Staff
    document.getElementById('btnSimpanEditStaff').addEventListener('click', async function() {
        if (!validateEditForm()) {
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', document.getElementById('editNamaStaff').value);
        formData.append('email', document.getElementById('editEmailStaff').value);
        formData.append('role', document.getElementById('editPeranStaff').value);
        formData.append('shift_start', document.getElementById('editWaktuMulai').value);
        formData.append('shift_end', document.getElementById('editWaktuSelesai').value);
        formData.append('outlet_id', document.getElementById('editOutletStaff').value);
        
        const password = document.getElementById('editPasswordStaff').value;
        if (password) {
            formData.append('password', password);
        }
        
        if (editCapturedFaceData) {
            formData.append('face_image', editCapturedFaceData, 'face.jpg');
            formData.append('update_face', 'true');
        }

        try {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i><span>Menyimpan...</span>';
            btn.disabled = true;

            const response = await fetch(`/api/staff/${currentStaffId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                showNotification('success', 'Data staff berhasil diupdate!');
                closeModalEditStaff();
                window.location.reload();
            } else {
                showNotification('error', data.message || 'Gagal mengupdate staff');
            }

        } catch (error) {
            console.error('Error updating staff:', error);
            showNotification('error', 'Terjadi kesalahan saat mengupdate staff');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
            lucide.createIcons();
        }
    });

    // Cancel button
    document.getElementById('btnBatalModalEditStaff').addEventListener('click', closeModalEditStaff);
});

// Form validation
function validateEditForm() {
    let isValid = true;
    const requiredFields = ['editNamaStaff', 'editEmailStaff', 'editPeranStaff'];
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById(`error${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`);
        
        if (!field.value) {
            errorElement.classList.remove('hidden');
            isValid = false;
        } else {
            errorElement.classList.add('hidden');
        }
    });
    
    return isValid;
}

// Close modal function
function closeModalEditStaff() {
    document.getElementById('modalEditStaff').classList.add('hidden');
    if (editFaceStream) {
        editFaceStream.getTracks().forEach(track => track.stop());
    }
}

function showNotification(type, message) {
    // Your existing notification implementation
    console.log(`${type}: ${message}`);
}
</script>