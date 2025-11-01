@extends('layouts.app')

@section('title', 'Prediksi Menu Favorit - AI Analysis')

@section('content')

<!-- Alert Notification -->
<div id="alertContainer" class="fixed top-4 right-4 z-50 space-y-3 w-80">
    <!-- Alert will appear here dynamically -->
</div>

<!-- Page Title + Action -->
<div class="mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-4xl font-bold text-gray-800">Prediksi Menu Favorit</h1>
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

<!-- Card: Outlet Info + AI Status -->
<div class="bg-white rounded-md p-4 shadow-md mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
    <!-- Kiri: Outlet Info -->
    <div class="mb-3 md:mb-0 flex items-start gap-2">
        <i data-lucide="store" class="w-5 h-5 text-gray-600 mt-1"></i>
        <div>
            <h4 class="text-lg font-semibold text-gray-800">Menampilkan laporan untuk: <span id="outletName">MCoffee - Pusat</span></h4>
            <p class="text-sm text-gray-600">Data yang ditampilkan adalah khusus untuk outlet <span id="outletNameSub">MCoffee - Pusat</span>.</p>
        </div>
    </div>
    
    <!-- Kanan: AI Status -->
    <div class="flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg border">
        <i data-lucide="brain" class="w-5 h-5 text-[#3b6b0d]"></i>
        <span class="text-sm font-medium">AI Analysis Active</span>
        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
    </div>
</div>


<!-- Main Content -->
<div class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Header + Filter -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">🏆 Ranking Prediksi Menu Favorit</h2>
            <p class="text-sm text-gray-600">Analisis AI berdasarkan data penjualan 3 bulan terakhir</p>
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

            <!-- Category Filter -->
            <div class="relative">
                <select id="categoryFilter" class="pl-10 pr-8 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6b0d] appearance-none bg-white">
                    <option value="all">Semua Kategori</option>
                    <option value="minuman">Minuman</option>
                    <option value="makanan">Makanan</option>
                    <option value="dessert">Dessert</option>
                </select>
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-lucide="tag" class="w-4 h-4 text-gray-400"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Ranking Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-700 border-b-2">
                <tr>
                    <th class="py-3 font-bold text-center w-16">Rank</th>
                    <th class="py-3 font-bold">Menu</th>
                    <th class="py-3 font-bold">Kategori</th>
                    <th class="py-3 font-bold text-right">Penjualan Aktual</th>
                    <th class="py-3 font-bold text-right">Prediksi Bulan Depan</th>
                    <th class="py-3 font-bold text-center">Tren</th>
                    <th class="py-3 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y" id="predictionTableBody">
                <!-- Data will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Recommendation Section -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">💡 Rekomendasi Berdasarkan AI</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="package" class="w-5 h-5 text-green-600"></i>
                <h4 class="font-semibold text-green-800">Manajemen Stok</h4>
            </div>
            <p class="text-sm text-green-700">
                Tingkatkan stok <strong>espresso</strong> dan <strong>susu segar</strong> untuk antisipasi peningkatan penjualan minuman kopi.
            </p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center gap-2 mb-2">
                <i data-lucide="megaphone" class="w-5 h-5 text-blue-600"></i>
                <h4 class="font-semibold text-blue-800">Promosi</h4>
            </div>
            <p class="text-sm text-blue-700">
                Fokus promosi pada <strong>Caramel Macchiato</strong> dan <strong>Ice Coffee Latte</strong> untuk maksimalkan penjualan.
            </p>
        </div>
    </div>
</div>

<script>
    // Dummy data for predictions
    const dummyPredictionData = {
        summary: {
            outlet_name: "MCoffee - Pusat",
            today_transactions: 47,
            today_comparison: "+12%",
            monthly_sales: "Rp 12,8 Jt",
            monthly_comparison: "+8%",
            weekly_favorite: "Ice Coffee Latte",
            weekly_favorite_sales: 89,
            next_month_prediction: "Caramel Macchiato",
            prediction_confidence: "85%"
        },
        menu_rankings: [
            {
                rank: 1,
                menu_name: 'Ice Coffee Latte',
                category: 'Minuman',
                actual_sales: 350,
                predicted_sales: 380,
                trend: 'up',
                trend_percentage: 8.6,
                description: 'Konsisten menjadi favorit'
            },
            {
                rank: 2,
                menu_name: 'Americano',
                category: 'Minuman',
                actual_sales: 290,
                predicted_sales: 250,
                trend: 'down',
                trend_percentage: -13.8,
                description: 'Sedikit penurunan tren'
            },
            {
                rank: 3,
                menu_name: 'Cappuccino',
                category: 'Minuman',
                actual_sales: 240,
                predicted_sales: 240,
                trend: 'stable',
                trend_percentage: 0,
                description: 'Stabil'
            },
            {
                rank: 4,
                menu_name: 'Caramel Macchiato',
                category: 'Minuman',
                actual_sales: 220,
                predicted_sales: 260,
                trend: 'up',
                trend_percentage: 18.2,
                description: 'Tren naik signifikan'
            },
            {
                rank: 5,
                menu_name: 'Matcha Latte',
                category: 'Minuman',
                actual_sales: 200,
                predicted_sales: 180,
                trend: 'down',
                trend_percentage: -10.0,
                description: 'Musiman turun'
            },
            {
                rank: 6,
                menu_name: 'Croissant',
                category: 'Makanan',
                actual_sales: 180,
                predicted_sales: 200,
                trend: 'up',
                trend_percentage: 11.1,
                description: 'Tren breakfast naik'
            },
            {
                rank: 7,
                menu_name: 'Chocolate Cake',
                category: 'Dessert',
                actual_sales: 150,
                predicted_sales: 170,
                trend: 'up',
                trend_percentage: 13.3,
                description: 'Permintaan meningkat'
            },
            {
                rank: 8,
                menu_name: 'Sandwich',
                category: 'Makanan',
                actual_sales: 120,
                predicted_sales: 110,
                trend: 'down',
                trend_percentage: -8.3,
                description: 'Kompetisi menu baru'
            }
        ],
        ai_insight: "Ice Coffee Latte menunjukkan pertumbuhan konsisten 15% per bulan selama 3 bulan terakhir. Caramel Macchiato diprediksi naik 18% bulan depan. Disarankan menambah stok bahan baku espresso dan susu segar."
    };

    // Global variables
    let predictionData = dummyPredictionData;
    let currentTimeRange = 'monthly';
    let currentCategory = 'all';

    document.addEventListener('DOMContentLoaded', function() {
        initializePage();
        setupEventListeners();
    });

    function initializePage() {
        updateOutletInfo();
        updatePredictionTable(predictionData.menu_rankings);
    }

    function setupEventListeners() {
        // Time range filter
        document.getElementById('timeRange').addEventListener('change', function(e) {
            currentTimeRange = e.target.value;
            filterPredictionData();
            showAlert('info', `Filter periode diubah ke: ${getTimeRangeText(currentTimeRange)}`);
        });

        // Category filter
        document.getElementById('categoryFilter').addEventListener('change', function(e) {
            currentCategory = e.target.value;
            filterPredictionData();
            showAlert('info', `Filter kategori diubah ke: ${getCategoryText(currentCategory)}`);
        });
    }

    function updateOutletInfo() {
        // In real app, this would come from API
        document.getElementById('outletName').textContent = predictionData.summary.outlet_name;
        document.getElementById('outletNameSub').textContent = predictionData.summary.outlet_name;
    }

    function updatePredictionTable(rankings) {
        const tableBody = document.getElementById('predictionTableBody');
        tableBody.innerHTML = '';

        if (rankings.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-500">
                        <i data-lucide="search" class="w-12 h-12 mx-auto mb-2 text-gray-300"></i>
                        <p>Tidak ada data prediksi untuk filter yang dipilih</p>
                    </td>
                </tr>
            `;
            return;
        }

        rankings.forEach(item => {
            const trendIcon = getTrendIcon(item.trend);
            const trendColor = getTrendColor(item.trend);
            const medal = getRankMedal(item.rank);

            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            row.innerHTML = `
                <td class="py-4 text-center">
                    <div class="flex items-center justify-center">
                        ${medal}
                        <span class="font-bold ${medal ? 'text-white text-sm' : 'text-gray-700'}">${item.rank}</span>
                    </div>
                </td>
                <td class="py-4">
                    <div class="font-medium">${item.menu_name}</div>
                    <div class="text-xs text-gray-500">${item.description}</div>
                </td>
                <td class="py-4">
                    <span class="px-2 py-1 text-xs rounded-full ${getCategoryColor(item.category)}">
                        ${item.category}
                    </span>
                </td>
                <td class="py-4 text-right font-semibold">${item.actual_sales}</td>
                <td class="py-4 text-right font-semibold">${item.predicted_sales}</td>
                <td class="py-4 text-center">
                    <div class="flex items-center justify-center gap-1 ${trendColor}">
                        ${trendIcon}
                        <span class="text-xs font-medium">${item.trend_percentage > 0 ? '+' : ''}${item.trend_percentage}%</span>
                    </div>
                </td>
                <td class="py-4 text-center">
                    <button onclick="viewMenuDetails('${item.menu_name}')" 
                            class="px-3 py-1 text-xs bg-[#3b6b0d] text-white rounded-lg hover:bg-[#2d550a] transition-colors flex items-center gap-1">
                        <i data-lucide="bar-chart-3" class="w-3 h-3"></i>
                        Detail
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize Lucide icons for new content
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function filterPredictionData() {
        let filteredData = [...predictionData.menu_rankings];

        // Apply category filter
        if (currentCategory !== 'all') {
            filteredData = filteredData.filter(item => 
                item.category.toLowerCase() === currentCategory.toLowerCase()
            );
        }

        // Apply time range adjustments (simplified for demo)
        if (currentTimeRange === 'weekly') {
            filteredData = filteredData.map(item => ({
                ...item,
                actual_sales: Math.round(item.actual_sales / 4),
                predicted_sales: Math.round(item.predicted_sales / 4)
            }));
        } else if (currentTimeRange === 'quarterly') {
            filteredData = filteredData.map(item => ({
                ...item,
                actual_sales: Math.round(item.actual_sales * 3),
                predicted_sales: Math.round(item.predicted_sales * 3)
            }));
        }

        updatePredictionTable(filteredData);
    }

    function getTrendIcon(trend) {
        switch(trend) {
            case 'up': return '<i data-lucide="trending-up" class="w-4 h-4"></i>';
            case 'down': return '<i data-lucide="trending-down" class="w-4 h-4"></i>';
            default: return '<i data-lucide="minus" class="w-4 h-4"></i>';
        }
    }

    function getTrendColor(trend) {
        switch(trend) {
            case 'up': return 'text-green-500';
            case 'down': return 'text-red-500';
            default: return 'text-gray-500';
        }
    }

    function getCategoryColor(category) {
        switch(category.toLowerCase()) {
            case 'minuman': return 'bg-blue-100 text-blue-700';
            case 'makanan': return 'bg-orange-100 text-orange-700';
            case 'dessert': return 'bg-purple-100 text-purple-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    }

    function getRankMedal(rank) {
        switch(rank) {
            case 1: return '<div class="bg-yellow-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-1 text-xs">🥇</div>';
            case 2: return '<div class="bg-gray-400 text-white rounded-full w-6 h-6 flex items-center justify-center mr-1 text-xs">🥈</div>';
            case 3: return '<div class="bg-orange-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-1 text-xs">🥉</div>';
            default: return '';
        }
    }

    function getTimeRangeText(range) {
        switch(range) {
            case 'weekly': return 'Mingguan';
            case 'monthly': return 'Bulanan';
            case 'quarterly': return '3 Bulanan';
            default: return range;
        }
    }

    function getCategoryText(category) {
        switch(category) {
            case 'all': return 'Semua Kategori';
            case 'minuman': return 'Minuman';
            case 'makanan': return 'Makanan';
            case 'dessert': return 'Dessert';
            default: return category;
        }
    }

    function refreshPredictions() {
        showAlert('info', '🔄 Memperbarui analisis prediksi AI...');
        
        // Simulate API call delay
        setTimeout(() => {
            // In real app, this would fetch new data from API
            showAlert('success', '✅ Prediksi berhasil diperbarui dengan data terbaru!');
            
            // Add some random variation to simulate fresh data
            predictionData.menu_rankings.forEach(item => {
                const variation = Math.random() * 20 - 10; // -10% to +10%
                item.actual_sales = Math.max(50, Math.round(item.actual_sales * (1 + variation/100)));
                item.predicted_sales = Math.max(50, Math.round(item.predicted_sales * (1 + variation/100)));
            });
            
            updatePredictionTable(predictionData.menu_rankings);
        }, 2000);
    }

    function exportPredictions() {
        showAlert('info', '📊 Menyiapkan ekspor data prediksi...');
        
        setTimeout(() => {
            const outletName = document.getElementById('outletName').textContent;
            const date = new Date().toLocaleDateString('id-ID');
            
            // Simple CSV export simulation
            const csvContent = generateCSVContent();
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', `prediksi-menu-${outletName.replace(/\s+/g, '-')}-${date}.csv`);
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showAlert('success', '✅ Data prediksi berhasil diekspor!');
        }, 1000);
    }

    function generateCSVContent() {
        let csv = 'Rank,Menu,Kategori,Penjualan Aktual,Prediksi Bulan Depan,Tren,Persentase Tren\n';
        
        predictionData.menu_rankings.forEach(item => {
            csv += `${item.rank},"${item.menu_name}","${item.category}",${item.actual_sales},${item.predicted_sales},${item.trend},${item.trend_percentage}%\n`;
        });
        
        return csv;
    }

    function viewMenuDetails(menuName) {
        showAlert('info', `📈 Membuka analisis detail untuk: ${menuName}`);
        
        // Simulate opening a detail modal
        setTimeout(() => {
            const menu = predictionData.menu_rankings.find(m => m.menu_name === menuName);
            if (menu) {
                showAlert('success', 
                    `Analisis ${menuName}: ${menu.actual_sales} terjual (Prediksi: ${menu.predicted_sales}). ${menu.description}`
                );
            }
        }, 500);
    }

    function showAlert(type, message) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `px-4 py-3 rounded-lg shadow-md transform transition-all duration-300 ${
            type === 'error' ? 'bg-red-100 text-red-700 border-l-4 border-red-500' : 
            type === 'success' ? 'bg-green-100 text-[#3b6b0d] border-l-4 border-green-500' : 
            'bg-orange-100 text-orange-700 border-l-4 border-orange-500'
        }`;
        alert.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : 
                                    type === 'success' ? 'check-circle' : 'info'}" 
                       class="w-5 h-5"></i>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-70 transition-opacity">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        `;
        alertContainer.appendChild(alert);
        
        if (window.lucide) {
            window.lucide.createIcons();
        }
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
</script>

<style>
    /* Smooth animations */
    .transition-colors {
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    
    .transform {
        transform: translateX(0);
    }
    
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Hover effects */
    .hover\\:bg-gray-50:hover {
        transition: background-color 0.2s ease;
    }
</style>

@endsection