@extends('layouts.app')

@section('title', 'Prediksi Tren Penjualan')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-4xl font-bold text-gray-800">Prediksi Tren Penjualan</h1>
        <div class="flex gap-2">
            <button onclick="refreshPredictions()" class="px-4 py-2 bg-[#3b6b0d] text-white rounded-lg hover:bg-[#2d550a] flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                Refresh Prediksi
            </button>
            <button onclick="exportPredictions()" class="px-4 py-2 bg-white text-green-500 border border-green-500 rounded-lg hover:bg-green-50 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Ekspor
            </button>
        </div>
    </div>
</div>

<!-- Card: Outlet Info -->
<div class="bg-white rounded-md p-4 shadow-md mb-4">
    <div class="flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: MCoffee - Pusat</h4>
            <p class="text-sm text-gray-600">Data yang ditampilkan adalah khusus untuk outlet MCoffee - Pusat.</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header + Filter -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">📊 Grafik Prediksi Tren Penjualan</h2>
            <p class="text-sm text-gray-600">Berdasarkan analisis data penjualan 6 bulan terakhir</p>
        </div>
        
        <!-- Filter Controls -->
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Time Range Filter -->
            <div class="relative">
                <select id="timeRange" class="pl-10 pr-8 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6b0d] appearance-none bg-white">
                    <option value="weekly">Mingguan</option>
                    <option value="monthly" selected>Bulanan</option>
                    <option value="quarterly">3 Bulanan</option>
                </select>
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Chart Container -->
    <div class="h-96 bg-gray-50 rounded-lg p-4 mb-6">
        <canvas id="salesTrendChart"></canvas>
    </div>

    <!-- Prediction Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold">Periode</th>
                    <th class="py-3 font-bold text-right">Penjualan Aktual</th>
                    <th class="py-3 font-bold text-right">Prediksi</th>
                    <th class="py-3 font-bold text-right">Pertumbuhan</th>
                    <th class="py-3 font-bold text-center">Tren</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Jan 2024</td>
                    <td class="py-4 text-right font-semibold">Rp 118.2 Jt</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right text-green-500">+4.1%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Feb 2024</td>
                    <td class="py-4 text-right font-semibold">Rp 122.5 Jt</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right text-green-500">+3.6%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Mar 2024</td>
                    <td class="py-4 text-right font-semibold">Rp 125.8 Jt</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right text-green-500">+2.7%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Apr 2024</td>
                    <td class="py-4 text-right font-semibold">Rp 121.3 Jt</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right text-red-500">-3.6%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-red-500">
                            <i data-lucide="trending-down" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="py-4 font-medium">Mei 2024</td>
                    <td class="py-4 text-right font-semibold">Rp 128.5 Jt</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right text-green-500">+5.9%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200 bg-green-50">
                    <td class="py-4 font-medium">Jun 2024</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right font-semibold">Rp 132.8 Jt</td>
                    <td class="py-4 text-right text-green-500">+3.3%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200 bg-green-50">
                    <td class="py-4 font-medium">Jul 2024</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right font-semibold">Rp 138.2 Jt</td>
                    <td class="py-4 text-right text-green-500">+4.1%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors duration-200 bg-green-50">
                    <td class="py-4 font-medium">Agu 2024</td>
                    <td class="py-4 text-right font-semibold">-</td>
                    <td class="py-4 text-right font-semibold">Rp 144.2 Jt</td>
                    <td class="py-4 text-right text-green-500">+4.3%</td>
                    <td class="py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-green-500">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Seasonal Pattern -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">🔄 Pola Penjualan Harian</h3>
    <div class="h-96 bg-gray-50 rounded-lg p-4">
        <canvas id="seasonalChart"></canvas>
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
        // Sales Trend Chart
        const trendCtx = document.getElementById('salesTrendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                datasets: [
                    {
                        label: 'Penjualan Aktual',
                        data: [118.2, 122.5, 125.8, 121.3, 128.5, null, null, null],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Prediksi',
                        data: [null, null, null, null, null, 132.8, 138.2, 144.2],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        borderDash: [5, 5],
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += `Rp ${context.parsed.y} Jt`;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Penjualan (Juta Rupiah)'
                        },
                        ticks: {
                            callback: function(value) {
                                return `Rp ${value} Jt`;
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });

        // Seasonal Pattern Chart
        const seasonalCtx = document.getElementById('seasonalChart').getContext('2d');
        const seasonalChart = new Chart(seasonalCtx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Persentase dari Rata-rata',
                    data: [85, 88, 92, 95, 105, 125, 115],
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
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y}% dari rata-rata`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Persentase (%)'
                        },
                        max: 140,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    function setupEventListeners() {
        // Time range filter
        const timeRangeSelect = document.getElementById('timeRange');
        if (timeRangeSelect) {
            timeRangeSelect.addEventListener('change', function() {
                showAlert('info', `Menampilkan data periode: ${this.options[this.selectedIndex].text}`);
            });
        }
    }

    function refreshPredictions() {
        showAlert('info', '🔄 Memperbarui analisis prediksi...');
        
        setTimeout(() => {
            showAlert('success', '✅ Prediksi berhasil diperbarui dengan data terbaru!');
        }, 2000);
    }

    function exportPredictions() {
        showAlert('info', '📊 Menyiapkan ekspor data prediksi...');
        
        setTimeout(() => {
            // Simple CSV export
            let csv = 'Periode,Penjualan Aktual,Prediksi,Pertumbuhan,Tren\n';
            csv += 'Jan 2024,118200000,,"+4.1%",up\n';
            csv += 'Feb 2024,122500000,,"+3.6%",up\n';
            csv += 'Mar 2024,125800000,,"+2.7%",up\n';
            csv += 'Apr 2024,121300000,,"-3.6%",down\n';
            csv += 'Mei 2024,128500000,,"+5.9%",up\n';
            csv += 'Jun 2024,,132800000,"+3.3%",up\n';
            csv += 'Jul 2024,,138200000,"+4.1%",up\n';
            csv += 'Agu 2024,,144200000,"+4.3%",up\n';
            
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', 'prediksi-tren-MCoffee-Pusat.csv');
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showAlert('success', '✅ Data prediksi tren berhasil diekspor!');
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