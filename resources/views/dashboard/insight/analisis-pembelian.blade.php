@extends('layouts.app')

@section('title', 'Identifikasi Pola Pembelian')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-4xl font-bold text-gray-800">Identifikasi Pola Pembelian</h1>
        <div class="flex gap-2">
            <button onclick="refreshAnalysis()" class="px-4 py-2 bg-[#3b6b0d] text-white rounded-lg hover:bg-[#2d550a] flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                Refresh Analisis
            </button>
            <button onclick="exportAnalysis()" class="px-4 py-2 bg-white text-green-500 border border-green-500 rounded-lg hover:bg-green-50 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Ekspor
            </button>
        </div>
    </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-md p-4 shadow-md mb-6">
    <div class="flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: MCoffee - Pusat</h4>
            <p class="text-sm text-gray-600">Analisis pola pembelian berdasarkan data transaksi 3 bulan terakhir</p>
        </div>
    </div>
</div>

<!-- Analisis Keranjang Belanja -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">🛒 Analisis Keranjang Belanja</h2>
            <p class="text-sm text-gray-600">Kombinasi menu yang sering dibeli bersama dalam satu transaksi</p>
        </div>
        
        <!-- Filter Controls -->
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative">
                <select id="confidenceFilter" class="pl-10 pr-8 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6b0d] appearance-none bg-white">
                    <option value="high">Tingkat Kepercayaan Tinggi</option>
                    <option value="medium">Tingkat Kepercayaan Sedang</option>
                    <option value="low">Tingkat Kepercayaan Rendah</option>
                </select>
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="filter" class="w-4 h-4 text-gray-400"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Tabel Aturan Asosiasi -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Menu Pertama</th>
                    <th class="py-3 font-bold">Menu Kedua</th>
                    <th class="py-3 font-bold text-center">Dukungan</th>
                    <th class="py-3 font-bold text-center">Tingkat Kepercayaan</th>
                    <th class="py-3 font-bold text-center">Tingkat Pengaruh</th>
                    <th class="py-3 font-bold text-center">Rekomendasi Paket</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Ice Coffee Latte</td>
                    <td class="py-4">Croissant</td>
                    <td class="py-4 text-center">22.5%</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">85%</span>
                    </td>
                    <td class="py-4 text-center">3.2</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Paket Sarapan</span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Americano</td>
                    <td class="py-4">Chocolate Cake</td>
                    <td class="py-4 text-center">18.3%</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">78%</span>
                    </td>
                    <td class="py-4 text-center">2.8</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Kopi & Dessert</span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Cappuccino</td>
                    <td class="py-4">Sandwich</td>
                    <td class="py-4 text-center">15.7%</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">65%</span>
                    </td>
                    <td class="py-4 text-center">2.1</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Paket Makan Siang</span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Matcha Latte</td>
                    <td class="py-4">Cookies</td>
                    <td class="py-4 text-center">12.4%</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">58%</span>
                    </td>
                    <td class="py-4 text-center">1.9</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Waktu Snack</span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Caramel Macchiato</td>
                    <td class="py-4">Muffin</td>
                    <td class="py-4 text-center">10.8%</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">45%</span>
                    </td>
                    <td class="py-4 text-center">1.4</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Combo Manis</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Analisis Pola Waktu -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Pola per Jam -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">⏰ Pola Pembelian per Jam</h3>
        <p class="text-sm text-gray-600 mb-4">Distribusi transaksi dalam satu hari</p>
        <div class="h-80 bg-gray-50 rounded-lg p-4">
            <canvas id="hourlyPatternChart"></canvas>
        </div>
    </div>

    <!-- Pola per Hari -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📅 Pola Pembelian per Hari</h3>
        <p class="text-sm text-gray-600 mb-4">Rata-rata transaksi harian dalam seminggu</p>
        <div class="h-80 bg-gray-50 rounded-lg p-4">
            <canvas id="dailyPatternChart"></canvas>
        </div>
    </div>
</div>

<!-- Segmentasi Pelanggan -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">👥 Segmentasi Pola Pelanggan</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="coffee" class="w-5 h-5 text-blue-600"></i>
                <h4 class="font-semibold text-blue-800">Pecinta Kopi</h4>
            </div>
            <p class="text-2xl font-bold text-blue-600 mb-1">42%</p>
            <p class="text-xs text-blue-700">Sering membeli minuman kopi</p>
        </div>
        
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="utensils" class="w-5 h-5 text-green-600"></i>
                <h4 class="font-semibold text-green-800">Penyuka Makanan</h4>
            </div>
            <p class="text-2xl font-bold text-green-600 mb-1">28%</p>
            <p class="text-xs text-green-700">Suka makanan & snack</p>
        </div>
        
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="users" class="w-5 h-5 text-orange-600"></i>
                <h4 class="font-semibold text-orange-800">Pelanggan Sosial</h4>
            </div>
            <p class="text-2xl font-bold text-orange-600 mb-1">18%</p>
            <p class="text-xs text-orange-700">Datang berkelompok</p>
        </div>
        
        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="briefcase" class="w-5 h-5 text-purple-600"></i>
                <h4 class="font-semibold text-purple-800">Profesional</h4>
            </div>
            <p class="text-2xl font-bold text-purple-600 mb-1">12%</p>
            <p class="text-xs text-purple-700">Bekerja & meeting</p>
        </div>
    </div>

    <!-- Chart Segmentasi -->
    <div class="h-80 bg-gray-50 rounded-lg p-4">
        <canvas id="segmentationChart"></canvas>
    </div>
</div>

<!-- Kombinasi Menu Terpopuler -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">🏆 Kombinasi Menu Terpopuler</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                    <i data-lucide="coffee" class="w-5 h-5 text-orange-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Paket Sarapan</h4>
                    <p class="text-xs text-gray-500">Ice Coffee Latte + Croissant</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">287 transaksi</span>
                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">22.5%</span>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="cake" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Pasangan Dessert</h4>
                    <p class="text-xs text-gray-500">Americano + Chocolate Cake</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">234 transaksi</span>
                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">18.3%</span>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i data-lucide="sandwich" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Set Makan Siang</h4>
                    <p class="text-xs text-gray-500">Cappuccino + Sandwich</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">198 transaksi</span>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">15.7%</span>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i data-lucide="cookie" class="w-5 h-5 text-purple-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Waktu Snack</h4>
                    <p class="text-xs text-gray-500">Matcha Latte + Cookies</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">156 transaksi</span>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">12.4%</span>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                    <i data-lucide="cupcake" class="w-5 h-5 text-pink-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Combo Manis</h4>
                    <p class="text-xs text-gray-500">Caramel Macchiato + Muffin</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">136 transaksi</span>
                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">10.8%</span>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                    <i data-lucide="milk" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Minuman Spesial</h4>
                    <p class="text-xs text-gray-500">Vanilla Latte + Brownies</p>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">112 transaksi</span>
                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">8.9%</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        initializeCharts();
        setupEventListeners();
    });

    function initializeCharts() {
        // Pola per Jam Chart
        const hourlyCtx = document.getElementById('hourlyPatternChart').getContext('2d');
        const hourlyChart = new Chart(hourlyCtx, {
            type: 'line',
            data: {
                labels: ['06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'],
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: [15, 45, 120, 185, 165, 140, 155, 130, 110, 95, 85, 105, 145, 120, 75],
                    borderColor: '#3b6b0d',
                    backgroundColor: 'rgba(59, 107, 13, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jam'
                        }
                    }
                }
            }
        });

        // Pola per Hari Chart
        const dailyCtx = document.getElementById('dailyPatternChart').getContext('2d');
        const dailyChart = new Chart(dailyCtx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Rata-rata Transaksi',
                    data: [285, 310, 295, 320, 380, 520, 450],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(16, 185, 129, 0.7)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#3b82f6',
                        '#3b82f6',
                        '#3b82f6',
                        '#10b981',
                        '#f97316',
                        '#10b981'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                        }
                    }
                }
            }
        });

        // Segmentasi Chart
        const segCtx = document.getElementById('segmentationChart').getContext('2d');
        const segChart = new Chart(segCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pecinta Kopi', 'Penyuka Makanan', 'Pelanggan Sosial', 'Profesional'],
                datasets: [{
                    data: [42, 28, 18, 12],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#10b981',
                        '#f97316',
                        '#8b5cf6'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    function setupEventListeners() {
        // Filter tingkat kepercayaan
        const confidenceFilter = document.getElementById('confidenceFilter');
        if (confidenceFilter) {
            confidenceFilter.addEventListener('change', function() {
                showAlert('info', `Menampilkan aturan asosiasi dengan tingkat kepercayaan: ${this.options[this.selectedIndex].text}`);
            });
        }
    }

    function refreshAnalysis() {
        showAlert('info', '🔄 Memperbarui analisis pola pembelian...');
        
        setTimeout(() => {
            showAlert('success', '✅ Analisis pola pembelian berhasil diperbarui!');
        }, 2000);
    }

    function exportAnalysis() {
        showAlert('info', '📊 Menyiapkan ekspor data analisis...');
        
        setTimeout(() => {
            // Ekspor data CSV
            let csv = 'Menu Pertama,Menu Kedua,Dukungan,Tingkat Kepercayaan,Tingkat Pengaruh,Rekomendasi Paket\n';
            csv += 'Ice Coffee Latte,Croissant,22.5%,85%,3.2,Paket Sarapan\n';
            csv += 'Americano,Chocolate Cake,18.3%,78%,2.8,Kopi & Dessert\n';
            csv += 'Cappuccino,Sandwich,15.7%,65%,2.1,Paket Makan Siang\n';
            csv += 'Matcha Latte,Cookies,12.4%,58%,1.9,Waktu Snack\n';
            csv += 'Caramel Macchiato,Muffin,10.8%,45%,1.4,Combo Manis\n';
            
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', 'pola-pembelian-MCoffee-Pusat.csv');
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showAlert('success', '✅ Data analisis pola pembelian berhasil diekspor!');
        }, 1000);
    }

    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md ${
            type === 'error' ? 'bg-red-100 text-red-700' : 
            type === 'success' ? 'bg-green-100 text-green-700' : 
            'bg-orange-100 text-orange-700'
        }`;
        alert.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-70">
                    ×
                </button>
            </div>
        `;
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
</script>

@endsection