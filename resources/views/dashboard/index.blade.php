@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Outlet Info -->
<div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-800">Kifa Bakery Pusat</h2>
    <p class="text-sm text-gray-600">Data yang ditampilkan adalah untuk outlet Kifa Bakery Pusat.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Total Penjualan -->
    <div class="bg-white rounded-lg p-4 card-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Total Penjualan</p>
                <p class="text-xl font-bold">Rp 167.500</p>
            </div>
            <div class="bg-orange-100 p-2 rounded-lg">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-orange-500"></i>
            </div>
        </div>
    </div>
    
    <!-- Transaksi -->
    <div class="bg-white rounded-lg p-4 card-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Transaksi</p>
                <p class="text-xl font-bold">5</p>
            </div>
            <div class="bg-blue-100 p-2 rounded-lg">
                <i data-lucide="credit-card" class="w-5 h-5 text-blue-500"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Item Terjual -->
    <div class="bg-white rounded-lg p-4 card-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Total Item Terjual</p>
                <p class="text-xl font-bold">20 Item</p>
            </div>
            <div class="bg-green-100 p-2 rounded-lg">
                <i data-lucide="package" class="w-5 h-5 text-green-500"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Kas Kasir -->
    <div class="bg-white rounded-lg p-4 card-shadow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-gray-500">Total Kas Kasir</p>
                <p class="text-xl font-bold">Rp 167.500</p>
            </div>
            <div class="bg-purple-100 p-2 rounded-lg">
                <i data-lucide="dollar-sign" class="w-5 h-5 text-purple-500"></i>
            </div>
        </div>
    </div>
</div>

<!-- Two Columns -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-2">
        <!-- Overview -->
        <div class="bg-white rounded-lg p-4 card-shadow mb-6">
            <h3 class="font-semibold text-gray-800 mb-4">Overview</h3>
            <p class="text-sm text-gray-600 mb-2">Data penjualan untuk Kifa Bakery Pusat</p>
            <p class="text-xl font-bold text-orange-500">Rp 160k</p>
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="lg:col-span-1">
        <!-- Penjualan Terlaris -->
        <div class="bg-white rounded-lg p-4 card-shadow">
            <h3 class="font-semibold text-gray-800 mb-4">Penjualan Terlaris</h3>
            <p class="text-sm text-gray-600 mb-2">5 produk terlaris</p>
            
            <div class="space-y-3">
                <!-- Product 1 -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">Roti Unyil</p>
                        <p class="text-sm text-gray-500">Qty: 5</p>
                    </div>
                    <p class="font-bold text-orange-500">Rp 10.000</p>
                </div>
                
                <!-- Product 2 -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">Roti Tawar Original</p>
                        <p class="text-sm text-gray-500">Qty: 4</p>
                    </div>
                    <p class="font-bold text-orange-500">Rp 26.000</p>
                </div>
                
                <!-- Product 3 -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">Bolu Gulung Pandan Ekonomis</p>
                        <p class="text-sm text-gray-500">Qty: 3</p>
                    </div>
                    <p class="font-bold text-orange-500">Rp 45.000</p>
                </div>
                
                <!-- Product 4 -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">Bolu Gulung Coklat Ekonomis</p>
                        <p class="text-sm text-gray-500">Qty: 2</p>
                    </div>
                    <p class="font-bold text-orange-500">Rp 30.000</p>
                </div>
                
                <!-- Product 5 -->
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">Bolu Gulung Tiramisu Ekonomis</p>
                        <p class="text-sm text-gray-500">Qty: 6</p>
                    </div>
                    <p class="font-bold text-orange-500">Rp 30.000</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection