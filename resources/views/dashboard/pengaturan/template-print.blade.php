@extends('layouts.app')

@section('title', 'Atur Template Print')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
       <h1 class="text-4xl font-bold text-gray-800">Atur Template Print</h1>
    </div>
</div>

<!-- Card: Info Outlet -->
<div class="bg-white rounded-md p-4 shadow-md mb-4">
    <div class="flex items-start gap-2">
        <i data-lucide="printer" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan template untuk: Kifa Bakery Pusat</h4>
            <p class="text-sm text-gray-600">Template print yang ditampilkan khusus untuk outlet ini.</p>
        </div>
    </div>
</div>

<!-- Print Template Settings Form -->
<!-- Form Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form id="printTemplateForm">

        <!-- Nama & Slogan dan Logo dalam satu baris -->
        <div class="flex flex-col md:flex-row gap-6 mb-6">
            <!-- Kiri: Nama dan Slogan -->
            <div class="flex-1">
                <!-- Nama Perusahaan -->
                <div class="mb-4">
                    <label for="companyName" class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                    <input type="text" id="companyName" value="KIFA BAKERY"
                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                
                <!-- Slogan Perusahaan -->
                <div>
                    <label for="companySlogan" class="block text-sm font-medium text-gray-700 mb-2">Slogan Perusahaan</label>
                    <input type="text" id="companySlogan" value="Rajanya Roti Hajatan"
                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <!-- Kanan: Logo -->
            <div class="w-full md:w-1/2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Perusahaan</label>
                <div class="border rounded-lg p-4 flex flex-col items-center">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Preview Logo</h3>
                    <div class="w-40 h-40 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                        <img id="logoPreview" src="https://via.placeholder.com/160" alt="Logo Preview" class="max-w-full max-h-full">
                    </div>
                    <p class="text-xs text-gray-500 mt-2 mb-4">Format: PNG/JPG (Maks. 10MB)</p>
                    
                    <div class="flex gap-3">
                        <label for="logoUpload" class="px-4 py-2 bg-white text-orange-500 border border-orange-500 rounded-lg hover:bg-orange-50 flex items-center gap-2 cursor-pointer">
                            <i data-lucide="upload" class="w-5 h-5"></i>
                            Unggah
                            <input type="file" id="logoUpload" accept="image/png,image/jpeg" class="hidden">
                        </label>
                        <button type="button" onclick="removeLogo()" class="px-4 py-2 bg-white text-red-500 border border-red-500 rounded-lg hover:bg-red-50 flex items-center gap-2">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesan Footer -->
        <div class="mb-8">
            <label for="footerMessage" class="block text-sm font-medium text-gray-700 mb-2">Pesan Footer</label>
            <textarea id="footerMessage" rows="3"
                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">Terima kasih sudah berbelanja</textarea>
        </div>
        
        <!-- Preview Section -->
        <div class="border-t pt-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Preview Struk</h2>
            <div class="bg-white border rounded-lg p-6 w-full max-w-xs mx-auto shadow-sm">
                <!-- Header -->
                <div class="text-center mb-4">
                    <img id="printLogoPreview" src="https://via.placeholder.com/160" alt="Logo" class="w-16 h-16 mx-auto mb-2">
                    <h3 id="printCompanyName" class="text-lg font-bold">KIFA BAKERY</h3>
                    <p id="printCompanySlogan" class="text-sm text-gray-600">Rajanya Roti Hajatan</p>
                </div>
                
                <!-- Transaction Info -->
                <div class="border-t border-b py-3 my-3 text-xs">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Tanggal:</span>
                        <span>11 Mei 2025 14:30</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Kasir:</span>
                        <span>Mona</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Transaksi:</span>
                        <span>INV-20250511-001</span>
                    </div>
                </div>
                
                <!-- Items -->
                <div class="mb-3 text-xs">
                    <div class="grid grid-cols-12 gap-1 font-medium mb-1">
                        <div class="col-span-6">Produk</div>
                        <div class="col-span-2 text-right">Qty</div>
                        <div class="col-span-2 text-right">Harga</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>
                    
                    <div class="grid grid-cols-12 gap-1 border-b pb-1 mb-1">
                        <div class="col-span-6">Roti Tawar Gandum</div>
                        <div class="col-span-2 text-right">2</div>
                        <div class="col-span-2 text-right">25.000</div>
                        <div class="col-span-2 text-right">50.000</div>
                    </div>
                    
                    <div class="grid grid-cols-12 gap-1 border-b pb-1 mb-1">
                        <div class="col-span-6">Brownies Coklat</div>
                        <div class="col-span-2 text-right">1</div>
                        <div class="col-span-2 text-right">15.000</div>
                        <div class="col-span-2 text-right">15.000</div>
                    </div>
                </div>
                
                <!-- Summary -->
                <div class="text-xs mb-4">
                    <div class="flex justify-between font-medium">
                        <span>Subtotal:</span>
                        <span>65.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Diskon:</span>
                        <span>-5.000</span>
                    </div>
                    <div class="flex justify-between font-bold border-t mt-1 pt-1">
                        <span>Total:</span>
                        <span>60.000</span>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center text-xs text-gray-600 border-t pt-2">
                    <p id="printFooterMessage">Terima kasih sudah berbelanja</p>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-end gap-3">
            <button type="button" onclick="resetForm()" class="px-6 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center gap-2">
                <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                Reset
            </button>
            <button type="button" onclick="saveTemplate()" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

<script>
    // Handle logo upload
    document.getElementById('logoUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 10 * 1024 * 1024) {
                showAlert('error', 'Ukuran file terlalu besar. Maksimal 10MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('logoPreview').src = event.target.result;
                document.getElementById('printLogoPreview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Remove logo
    function removeLogo() {
        document.getElementById('logoPreview').src = 'https://via.placeholder.com/160';
        document.getElementById('printLogoPreview').src = 'https://via.placeholder.com/160';
        document.getElementById('logoUpload').value = '';
    }
    
    // Reset form
    function resetForm() {
        document.getElementById('companyName').value = 'KIFA BAKERY';
        document.getElementById('companySlogan').value = 'Rajanya Roti Hajatan';
        document.getElementById('footerMessage').value = 'Terima kasih sudah berbelanja';
        removeLogo();
        updatePreview();
        showAlert('info', 'Form telah direset ke nilai default');
    }
    
    // Save template
    function saveTemplate() {
        // In a real app, this would send data to server
        showAlert('success', 'Template print berhasil disimpan');
    }
    
    // Update preview in real-time
    document.getElementById('companyName').addEventListener('input', function() {
        document.getElementById('printCompanyName').textContent = this.value;
    });
    
    document.getElementById('companySlogan').addEventListener('input', function() {
        document.getElementById('printCompanySlogan').textContent = this.value;
    });
    
    document.getElementById('footerMessage').addEventListener('input', function() {
        document.getElementById('printFooterMessage').textContent = this.value;
    });
    
    // Show alert function
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md ${type === 'error' ? 'bg-red-100 text-red-700' : 
                         type === 'success' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700'}`;
        alert.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : 
                                    type === 'success' ? 'check-circle' : 'info'}" 
                       class="w-5 h-5"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        `;
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
</script>

@endsection