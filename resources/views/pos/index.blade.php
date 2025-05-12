<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kifa Bakery Pusat - POS System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lucide Icons -->
    <link rel="stylesheet" href="https://unpkg.com/lucide@latest/dist/font/lucide.css">
    <style>
        body {
            background-color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 10px 20px;
            border-bottom: 1px solid #fd7e14;
        }
        .main-container {
            display: flex;
            height: calc(100vh - 61px);
            margin: 0;
            overflow: hidden;
        }
        .products-section {
            flex: 1;
            background-color: white;
            border-radius: 0;
            box-shadow: none;
            padding: 0;
            margin: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #f0f0f0;
        }
        .cart-section {
            width: 33.333%;
            background-color: white;
            border-radius: 0;
            box-shadow: none;
            margin: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .divider {
            border-top: 1px solid #fd7e14;
            margin: 0;
            opacity: 0.3;
        }
        .category-container {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .category-pills {
            display: inline-flex;
            flex-wrap: nowrap;
        }
        .category-pills .nav-link {
            border-radius: 16px;
            margin-right: 6px;
            font-size: 12px;
            padding: 5px 12px;
            font-weight: 500;
            color: #555;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
        }
        .category-pills .nav-link.active {
            background-color: #fd7e14;
            color: white;
            border-color: #fd7e14;
        }
        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            background-color: white;
            transition: all 0.2s ease;
        }
        .product-card:hover {
            box-shadow: 0 3px 8px rgba(0,0,0,.05);
        }
        .product-name {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 4px;
        }
        .product-price {
            color: #fd7e14;
            font-weight: 600;
            font-size: 15px;
        }
        .product-category {
            font-size: 12px;
            background-color: #f0f0f0;
            color: #666;
            padding: 3px 10px;
            border-radius: 10px;
        }
        .btn-tambah {
            background-color: #fd7e14;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
        }
        .btn-tambah i {
            font-size: 14px;
            margin-right: 3px;
        }
        .btn-tidak-tersedia {
            background-color: #f8f9fa;
            color: #999;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 5px 10px;
            font-size: 12px;
            width: 80px;
        }
        .cart-header {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            background-color: #fafafa;
        }
        .cart-header h4 {
            font-size: 16px;
            margin: 0;
            display: flex;
            align-items: center;
        }
        .cart-header h4 i {
            margin-right: 8px;
            color: #fd7e14;
        }
        .cart-products {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }
        .cart-column-headers {
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }
        .cart-item {
            padding: 14px 15px;
            border-bottom: 1px solid #f5f5f5;
        }
        .cart-item:hover {
            background-color: #fafafa;
        }
        .qty-control {
            display: flex;
            align-items: center;
        }
        .qty-control button {
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 4px;
            font-size: 14px;
        }
        .qty-control input {
            width: 40px;
            text-align: center;
            border: 1px solid #e0e0e0;
            height: 28px;
            font-size: 14px;
            margin: 0 5px;
            border-radius: 4px;
        }
        .payment-section {
            border-top: 1px solid #f0f0f0;
            padding: 15px;
            background-color: #fafafa;
        }
        .btn-bayar {
            background-color: #fd7e14;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: 600;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 12px;
        }
        .btn-history {
            border: 1px solid #e0e0e0;
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border-radius: 6px;
            background-color: white;
        }
        .low-stock {
            background-color: #fff3cd;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #856404;
            display: inline-block;
            margin-top: 4px;
            font-weight: 500;
        }
        .products-container {
            flex: 1;
            overflow-y: auto;
            padding: 0 15px 15px 15px;
        }
        .search-bar {
            margin-bottom: 12px;
        }
        .search-bar input {
            border-radius: 6px;
            font-size: 13px;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
        }
        .cart-item-name {
            font-size: 15px;
            font-weight: 500;
        }
        .cart-item-price {
            font-size: 14px;
            color: #666;
            margin-top: 2px;
        }
        .discount-input {
            width: 50px;
            font-size: 14px;
            padding: 2px 4px;
            text-align: center;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
            height: 28px;
        }
        .subtotal-price {
            font-size: 15px;
            font-weight: 600;
            white-space: nowrap;
            color: #333;
        }
        .delete-btn {
            color: #999;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 4px;
        }
        .delete-btn:hover {
            background-color: #f8f9fa;
            color: #dc3545;
        }
        .summary-item {
            font-size: 15px;
            color: #444;
        }
        .total-price {
            font-size: 17px;
            font-weight: 700;
            color: #fd7e14;
        }
        .search-and-categories {
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <span style="color: #fd7e14; font-weight: bold; font-size: 20px;">Kifa Bakery Pusat</span>
                </a>
                <div class="d-flex">
                    <button class="btn me-2" style="font-size: 14px; padding: 6px 12px; border: 1px solid #fd7e14; color: #fd7e14;">
                        <i class="fas fa-box"></i> Stok
                    </button>
                    <button class="btn me-2" style="font-size: 14px; padding: 6px 12px; border: 1px solid #fd7e14; color: #fd7e14;">
                        <i class="fas fa-money-bill"></i> Rp 0
                    </button>
                    <button class="btn me-2" style="font-size: 14px; padding: 6px 12px; border: 1px solid #fd7e14; color: #fd7e14;">
                        <i class="fas fa-cash-register"></i> Kas kasir
                    </button>
                    <button class="btn me-2" style="font-size: 14px; padding: 6px 12px; border: 1px solid #fd7e14; color: #fd7e14;">
                        <i class="fas fa-user"></i> Kasir (kasir)
                    </button>
                    <button class="btn" style="font-size: 14px; padding: 6px 12px; border: 1px solid #fd7e14; color: #fd7e14;">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </nav>

        <div class="main-container">
            <!-- Products Section -->
            <div class="products-section">
                <!-- Search and Categories Section -->
                <div class="search-and-categories">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="Cari produk...">
                    </div>

                    <div class="category-container">
                        <ul class="nav nav-pills category-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Semua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CAKE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">ROTI</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">TART</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">UMUM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">KEMASAN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">PERLENGKAPAN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">MINUMAN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">KNS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">PAKET</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">SPESIAL</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr class="divider">

                <!-- Products List -->
                <div class="products-container">
                    <!-- Produk Bolu Pisang -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Bolu Pisang (20)</div>
                                <div class="product-price">Rp 17.500</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">CAKE</span>
                                <button class="btn-tambah">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Meses -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Bolu Meses (1)</div>
                                <div class="product-price">Rp 16.500</div>
                                <span class="low-stock">Produk menipis</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">CAKE</span>
                                <button class="btn-tambah">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Kismis -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Bolu Kismis (0)</div>
                                <div class="product-price">Rp 20.000</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">CAKE</span>
                                <button class="btn-tidak-tersedia">Habis</button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Keju Meses -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Bolu Keju Meses (0)</div>
                                <div class="product-price">Rp 25.000</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">CAKE</span>
                                <button class="btn-tidak-tersedia">Habis</button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Bolu Lapis Talas -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Bolu Lapis Talas (0)</div>
                                <div class="product-price">Rp 30.000</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">CAKE</span>
                                <button class="btn-tidak-tersedia">Habis</button>
                            </div>
                        </div>
                    </div>

                    <!-- Produk Cake Harmoni -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Cake Harmoni (0)</div>
                                <div class="product-price">Rp 23.500</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">CAKE</span>
                                <button class="btn-tidak-tersedia">Habis</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional products -->
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Roti Tawar (15)</div>
                                <div class="product-price">Rp 12.000</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">ROTI</span>
                                <button class="btn-tambah">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="product-card d-flex justify-content-between align-items-center">
                            <div>
                                <div class="product-name">Roti Coklat (8)</div>
                                <div class="product-price">Rp 15.000</div>
                                <span class="low-stock">Produk menipis</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="product-category me-2">ROTI</span>
                                <button class="btn-tambah">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="cart-section">
                <div class="cart-header">
                    <h4><i class="fas fa-shopping-cart"></i> Keranjang</h4>
                </div>

                <div class="cart-column-headers">
                    <div class="row">
                        <div class="col-5">Produk</div>
                        <div class="col-3 text-center">Qty</div>
                        <div class="col-2 text-center">Diskon</div>
                        <div class="col-2 text-end">Subtotal</div>
                    </div>
                </div>

                <div class="cart-products">
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <div class="cart-item-name">Bolu Pisang</div>
                                <div class="cart-item-price">Rp 17.500</div>
                            </div>
                            <div class="col-3">
                                <div class="qty-control">
                                    <button>-</button>
                                    <input type="text" value="2">
                                    <button>+</button>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <input type="text" class="discount-input" value="0">
                            </div>
                            <div class="col-1 text-end px-0">
                                <div class="subtotal-price">35K</div>
                            </div>
                            <div class="col-1 text-end">
                                <button class="delete-btn"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <div class="cart-item-name">Bolu Meses</div>
                                <div class="cart-item-price">Rp 16.500</div>
                            </div>
                            <div class="col-3">
                                <div class="qty-control">
                                    <button>-</button>
                                    <input type="text" value="1">
                                    <button>+</button>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <input type="text" class="discount-input" value="0">
                            </div>
                            <div class="col-1 text-end px-0">
                                <div class="subtotal-price">16.5K</div>
                            </div>
                            <div class="col-1 text-end">
                                <button class="delete-btn"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <div class="cart-item-name">Roti Tawar</div>
                                <div class="cart-item-price">Rp 12.000</div>
                            </div>
                            <div class="col-3">
                                <div class="qty-control">
                                    <button>-</button>
                                    <input type="text" value="1">
                                    <button>+</button>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <input type="text" class="discount-input" value="0">
                            </div>
                            <div class="col-1 text-end px-0">
                                <div class="subtotal-price">12K</div>
                            </div>
                            <div class="col-1 text-end">
                                <button class="delete-btn"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="summary-item">Subtotal</div>
                        <div class="summary-item">Rp 63.500</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="summary-item">Pajak (0%)</div>
                        <div class="summary-item">Rp 0</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="summary-item" style="font-weight: 500;">Total</div>
                        <div class="total-price">Rp 63.500</div>
                    </div>

                    <button class="btn btn-bayar">
                        <i class="fas fa-money-bill-wave me-2"></i> Pembayaran
                    </button>

                    <button class="btn btn-history">
                        <i class="fas fa-history me-2"></i> Riwayat Transaksi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>