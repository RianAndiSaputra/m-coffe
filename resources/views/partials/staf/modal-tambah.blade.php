<!-- Modal Tambah Staff -->
<div id="modalTambahStaff" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" onclick="closeModalTambahStaff()">
  <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg max-h-screen flex flex-col" onclick="event.stopPropagation()">
    
    <!-- Header -->
    <div class="p-6 border-b">
      <h2 class="text-xl font-semibold text-gray-800">Tambah Staff Baru</h2>
      <p class="text-sm text-gray-500">Tambahkan staff baru dengan mengisi detail di bawah ini.</p>
    </div>

    <!-- Scrollable Content -->
    <div class="overflow-y-auto p-6 space-y-6 flex-1">
      <div class="space-y-4">
        
        <!-- Nama Staff -->
        <div>
          <label class="block font-medium mb-1 text-gray-700">Nama <span class="text-red-500">*</span></label>
          <input type="text" id="namaStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Nama staff" required>
          <p id="errorNamaStaff" class="text-red-500 text-xs mt-1 hidden">Nama staff wajib diisi</p>
        </div>

        <!-- Email Staff -->
        <div>
          <label class="block font-medium mb-1 text-gray-700">Email <span class="text-red-500">*</span></label>
          <input type="email" id="emailStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Email staff" required>
          <p id="errorEmailStaff" class="text-red-500 text-xs mt-1 hidden">Email wajib diisi dan valid</p>
        </div>

        <!-- Password -->
        <div>
          <label class="block font-medium mb-1 text-gray-700">Password <span class="text-red-500">*</span></label>
          <input type="password" id="passwordStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" placeholder="Password" required>
          <p id="errorPasswordStaff" class="text-red-500 text-xs mt-1 hidden">Password wajib diisi (min. 8 karakter)</p>
        </div>

        <!-- Peran -->
        <div>
          <label class="block font-medium mb-1 text-gray-700">Peran <span class="text-red-500">*</span></label>
          <select id="peranStaff" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" required>
            <option value="" disabled selected>Pilih peran</option>
            <option value="kasir">Kasir</option>
            <option value="supervisor">Supervisor</option>
            <option value="admin">Admin</option>
            <option value="manajer">Manajer</option>
          </select>
          <p id="errorPeranStaff" class="text-red-500 text-xs mt-1 hidden">Peran wajib dipilih</p>
        </div>

        <!-- Shift -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1 text-gray-700">Waktu Mulai <span class="text-red-500">*</span></label>
            <input type="time" id="waktuMulai" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" required>
            <p id="errorWaktuMulai" class="text-red-500 text-xs mt-1 hidden">Waktu mulai wajib diisi</p>
          </div>
          <div>
            <label class="block font-medium mb-1 text-gray-700">Waktu Selesai <span class="text-red-500">*</span></label>
            <input type="time" id="waktuSelesai" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" required>
            <p id="errorWaktuSelesai" class="text-red-500 text-xs mt-1 hidden">Waktu selesai wajib diisi</p>
          </div>
        </div>

        <!-- Outlet -->
        <div>
          <label class="block font-medium mb-1 text-gray-700">Outlet <span class="text-red-500">*</span></label>
          <select id="outletStaff" data-url="{{ url('/api/outlets') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-1 focus:ring-[#3b6b0d] focus:border-[#3b6b0d] outline-none transition duration-200" required>
            <option value="" disabled selected>Memuat outlet...</option>
          </select>
          <p id="errorOutletStaff" class="text-red-500 text-xs mt-1 hidden">Outlet wajib dipilih</p>
        </div>

        <!-- Face ID Registration -->
        <div class="border-t pt-6 mt-6">
          <div class="flex items-center justify-between mb-4">
            <div>
              <label class="block font-medium mb-1 text-gray-700">Registrasi Wajah untuk Face ID</label>
              <p class="text-sm text-gray-500">Scan wajah staff untuk login dengan Face ID</p>
            </div>
            <div class="flex items-center">
              <span id="faceRegistrationStatus" class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">Belum direkam</span>
            </div>
          </div>

          <!-- Face Capture Area -->
          <div id="faceCaptureSection" class="space-y-4">
            <div class="bg-gray-50 rounded-lg p-4 border-2 border-dashed border-gray-300">
              <div class="text-center">
                <!-- Camera Preview -->
                <div class="relative mx-auto w-full max-w-xs h-48 bg-black rounded-lg overflow-hidden mb-4">
                  <video id="facePreview" class="w-full h-full object-cover" autoplay playsinline></video>
                  <canvas id="faceCanvas" class="hidden"></canvas>
                  <div id="faceScanningOverlay" class="absolute inset-0 bg-gradient-to-b from-green-500/20 to-transparent animate-pulse hidden"></div>
                </div>

                <!-- Capture Controls -->
                <div class="flex justify-center space-x-3">
                  <button type="button" id="btnStartCamera" class="px-4 py-2 bg-[#3b6b0d] text-white rounded-lg hover:bg-[#335e0c] transition-colors flex items-center gap-2">
                    <i data-lucide="camera" class="w-4 h-4"></i>
                    <span>Mulai Kamera</span>
                  </button>
                  <button type="button" id="btnCaptureFace" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 hidden">
                    <i data-lucide="aperture" class="w-4 h-4"></i>
                    <span>Ambil Foto</span>
                  </button>
                  <button type="button" id="btnRetryCapture" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2 hidden">
                    <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                    <span>Ulangi</span>
                  </button>
                </div>

                <!-- Status Message -->
                <div id="faceCaptureStatus" class="mt-3 text-sm">
                  <p class="text-gray-600">Klik "Mulai Kamera" untuk memulai registrasi wajah</p>
                </div>
              </div>
            </div>

            <!-- Captured Face Preview -->
            <div id="capturedFacePreview" class="hidden">
              <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                  </div>
                  <div>
                    <p class="font-medium text-green-800">Wajah berhasil direkam</p>
                    <p class="text-xs text-green-600">Wajah staff sudah siap untuk Face ID login</p>
                  </div>
                </div>
                <button type="button" id="btnRemoveFace" class="text-red-600 hover:text-red-700">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Footer -->
    <div class="p-6 border-t flex justify-end gap-3">
      <button id="btnBatalModalTambahStaff" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-gray-700">Batal</button>
      <button id="btnTambahStaff" class="px-4 py-2 bg-[#3b6b0d] text-white rounded-lg hover:bg-[#335e0c] transition-colors flex items-center gap-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        <span>Simpan Staff</span>
      </button>
    </div>

  </div>
</div>

<script>
// Face ID Registration Functionality
let faceStream = null;
let capturedFaceData = null;

document.addEventListener('DOMContentLoaded', function() {
    const startCameraBtn = document.getElementById('btnStartCamera');
    const captureFaceBtn = document.getElementById('btnCaptureFace');
    const retryCaptureBtn = document.getElementById('btnRetryCapture');
    const removeFaceBtn = document.getElementById('btnRemoveFace');
    const facePreview = document.getElementById('facePreview');
    const faceCanvas = document.getElementById('faceCanvas');
    const faceScanningOverlay = document.getElementById('faceScanningOverlay');
    const faceCaptureStatus = document.getElementById('faceCaptureStatus');
    const capturedFacePreview = document.getElementById('capturedFacePreview');
    const faceRegistrationStatus = document.getElementById('faceRegistrationStatus');

    // Start Camera
    startCameraBtn.addEventListener('click', async function() {
        try {
            faceStream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: 640, 
                    height: 480,
                    facingMode: 'user'
                } 
            });
            
            facePreview.srcObject = faceStream;
            startCameraBtn.classList.add('hidden');
            captureFaceBtn.classList.remove('hidden');
            faceCaptureStatus.innerHTML = '<p class="text-green-600">Posisikan wajah di dalam frame dan klik "Ambil Foto"</p>';
            
        } catch (error) {
            console.error('Error accessing camera:', error);
            faceCaptureStatus.innerHTML = '<p class="text-red-600">Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.</p>';
        }
    });

    // Capture Face
    captureFaceBtn.addEventListener('click', function() {
        // Show scanning animation
        faceScanningOverlay.classList.remove('hidden');
        faceCaptureStatus.innerHTML = '<p class="text-blue-600">Menganalisis wajah...</p>';

        // Capture frame
        const context = faceCanvas.getContext('2d');
        faceCanvas.width = facePreview.videoWidth;
        faceCanvas.height = facePreview.videoHeight;
        context.drawImage(facePreview, 0, 0, faceCanvas.width, faceCanvas.height);

        // Simulate face detection (in real implementation, send to backend)
        setTimeout(() => {
            faceScanningOverlay.classList.add('hidden');
            
            // Convert canvas to blob
            faceCanvas.toBlob(function(blob) {
                capturedFaceData = blob;
                
                // Show success state
                captureFaceBtn.classList.add('hidden');
                retryCaptureBtn.classList.remove('hidden');
                capturedFacePreview.classList.remove('hidden');
                faceRegistrationStatus.textContent = 'Telah direkam';
                faceRegistrationStatus.className = 'text-xs px-2 py-1 rounded-full bg-green-100 text-green-600';
                faceCaptureStatus.innerHTML = '<p class="text-green-600">Wajah berhasil direkam dan siap digunakan untuk Face ID login</p>';
                
                // Stop camera
                if (faceStream) {
                    faceStream.getTracks().forEach(track => track.stop());
                }
            }, 'image/jpeg', 0.8);
        }, 2000);
    });

    // Retry Capture
    retryCaptureBtn.addEventListener('click', function() {
        capturedFaceData = null;
        retryCaptureBtn.classList.add('hidden');
        capturedFacePreview.classList.add('hidden');
        startCameraBtn.classList.remove('hidden');
        faceRegistrationStatus.textContent = 'Belum direkam';
        faceRegistrationStatus.className = 'text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600';
        faceCaptureStatus.innerHTML = '<p class="text-gray-600">Klik "Mulai Kamera" untuk memulai registrasi wajah</p>';
    });

    // Remove Face
    removeFaceBtn.addEventListener('click', function() {
        capturedFaceData = null;
        capturedFacePreview.classList.add('hidden');
        startCameraBtn.classList.remove('hidden');
        faceRegistrationStatus.textContent = 'Belum direkam';
        faceRegistrationStatus.className = 'text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600';
        faceCaptureStatus.innerHTML = '<p class="text-gray-600">Klik "Mulai Kamera" untuk memulai registrasi wajah</p>';
    });

    // Form Submission
    document.getElementById('btnTambahStaff').addEventListener('click', async function() {
        // Validate form
        if (!validateForm()) {
            return;
        }

        // Prepare form data
        const formData = new FormData();
        formData.append('name', document.getElementById('namaStaff').value);
        formData.append('email', document.getElementById('emailStaff').value);
        formData.append('password', document.getElementById('passwordStaff').value);
        formData.append('role', document.getElementById('peranStaff').value);
        formData.append('shift_start', document.getElementById('waktuMulai').value);
        formData.append('shift_end', document.getElementById('waktuSelesai').value);
        formData.append('outlet_id', document.getElementById('outletStaff').value);
        
        // Add face data if captured
        if (capturedFaceData) {
            formData.append('face_image', capturedFaceData, 'face.jpg');
        }

        try {
            // Show loading state
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i><span>Menyimpan...</span>';
            btn.disabled = true;

            // Send to backend
            const response = await fetch('/api/staff', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Success
                showNotification('success', 'Staff berhasil ditambahkan!');
                closeModalTambahStaff();
                // Refresh staff list or redirect
                window.location.reload();
            } else {
                // Error
                showNotification('error', data.message || 'Gagal menambahkan staff');
            }

        } catch (error) {
            console.error('Error adding staff:', error);
            showNotification('error', 'Terjadi kesalahan saat menambahkan staff');
        } finally {
            // Reset button state
            btn.innerHTML = originalText;
            btn.disabled = false;
            lucide.createIcons();
        }
    });

    // Form validation function
    function validateForm() {
        let isValid = true;
        
        // Add your form validation logic here
        const requiredFields = [
            'namaStaff', 'emailStaff', 'passwordStaff', 
            'peranStaff', 'waktuMulai', 'waktuSelesai', 'outletStaff'
        ];
        
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
});

// Close modal function
function closeModalTambahStaff() {
    document.getElementById('modalTambahStaff').classList.add('hidden');
    // Clean up camera
    if (faceStream) {
        faceStream.getTracks().forEach(track => track.stop());
    }
}

// Notification function (you can reuse from your existing code)
function showNotification(type, message) {
    // Your existing notification implementation
    console.log(`${type}: ${message}`);
}
</script>