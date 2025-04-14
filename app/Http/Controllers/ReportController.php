<?php

// namespace App\Http\Controllers\API;
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\MonthlyInventoryReport;
use App\Models\MonthlyReport;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\Shift;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use ApiResponse;
    /**
     * Laporan penjualan harian berdasarkan outlet
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function dailySales(Request $request, Outlet $outlet)
    {
        // $request->validate([
        //     'date' => 'nullable|date_format:Y-m-d',
        // ]);

        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $date = Carbon::today();

        $sales = Order::where('outlet_id', $outlet->id)
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->get();

        $totalSales = $sales->sum('total');
        $totalItems = OrderItem::whereIn('order_id', $sales->pluck('id'))->sum('quantity');
        $totalOrders = $sales->count();
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Penjualan per jam
        $hourlyData = Order::where('outlet_id', $outlet->id)
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('H');
            })
            ->map(function ($items) {
                return [
                    'orders' => $items->count(),
                    'sales' => $items->sum('total'),
                ];
            });

        // Penjualan per kategori produk
        $categorySales = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.subtotal) as total_sales'))
            ->where('orders.outlet_id', $outlet->id)
            ->whereDate('orders.created_at', $date)
            ->where('orders.status', 'completed')
            ->groupBy('categories.name')
            ->get();

        // Penjualan per metode pembayaran
        $paymentMethodSales = $sales->groupBy('payment_method')
            ->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'total' => $items->sum('total'),
                ];
            });

        return response()->json([
            'status' => true,
            'data' => [
                'date' => $date->format('Y-m-d'),
                'outlet' => $outlet->name,
                'summary' => [
                    'total_sales' => $totalSales,
                    'total_orders' => $totalOrders,
                    'total_items' => $totalItems,
                    'average_order_value' => $averageOrderValue,
                ],
                'hourly_sales' => $hourlyData,
                'category_sales' => $categorySales,
                'payment_method_sales' => $paymentMethodSales,
            ]
        ]);
    }

    /**
     * Laporan penjualan bulanan berdasarkan outlet
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function monthlySales(Request $request, Outlet $outlet)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
            'force_refresh' => 'nullable|boolean',
        ]);

        $year = $request->year ?: Carbon::now()->year;
        $month = $request->month ?: Carbon::now()->month;
        $forceRefresh = $request->force_refresh ?: false;

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Ambil data penjualan harian dalam bulan
        $dailySales = Order::where('outlet_id', $outlet->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('date')
            ->get();

        // Get top categories for this month
        $topCategories = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_sales'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->where('orders.outlet_id', $outlet->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();

        // Cek apakah laporan bulanan sudah ada
        $existingReport = MonthlyReport::where('outlet_id', $outlet->id)
            ->where('report_date', $startDate->format('Y-m-01'))
            ->first();

        // Hitung total penjualan dari data harian yang aktual
        $actualTotalSales = $dailySales->sum('total_sales');
        $actualTotalTransactions = $dailySales->sum('total_orders');
        $actualAverageTransaction = $actualTotalTransactions > 0 ? $actualTotalSales / $actualTotalTransactions : 0;

        if ($existingReport && !$forceRefresh) {
            // Periksa apakah data yang disimpan masih cocok dengan data aktual
            if (
                $existingReport->total_sales != $actualTotalSales ||
                $existingReport->total_transactions != $actualTotalTransactions
            ) {

                // Update laporan jika ada perbedaan
                $existingReport->total_sales = $actualTotalSales;
                $existingReport->total_transactions = $actualTotalTransactions;
                $existingReport->average_transaction = $actualAverageTransaction;
                $existingReport->updated_at = now();
                $existingReport->save();
            }

            $reportData = [
                'total_sales' => $existingReport->total_sales,
                'total_transactions' => $existingReport->total_transactions,
                'average_transaction' => $existingReport->average_transaction,
                'report_date' => $existingReport->report_date,
                'last_updated' => $existingReport->updated_at,
            ];
        } else {
            // Generate laporan baru atau refresh laporan
            if ($existingReport) {
                $report = $existingReport;
            } else {
                $report = new MonthlyReport();
                $report->outlet_id = $outlet->id;
                $report->report_date = $startDate->format('Y-m-d');
                $report->generated_by = $request->user()->id;
            }

            $report->total_sales = $actualTotalSales;
            $report->total_transactions = $actualTotalTransactions;
            $report->average_transaction = $actualAverageTransaction;
            $report->save();

            $reportData = [
                'total_sales' => $actualTotalSales,
                'total_transactions' => $actualTotalTransactions,
                'average_transaction' => $actualAverageTransaction,
                'report_date' => $startDate->format('Y-m-d'),
                'last_updated' => $report->updated_at,
            ];
        }

        // Penjualan produk terbaik
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as quantity'),
                DB::raw('SUM(order_items.subtotal) as total_sales')
            )
            ->where('orders.outlet_id', $outlet->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'year' => $year,
                'month' => $month,
                'outlet' => $outlet->name,
                'summary' => $reportData,
                'daily_sales' => $dailySales,
                'top_products' => $topProducts,
                'top_categories' => $topCategories->map(function ($category) {
                    return [
                        'name' => $category->name,
                        'total_quantity' => $category->total_quantity,
                        'total_sales' => $category->total_sales,
                        'total_orders' => $category->total_orders,
                        'average_order_value' => $category->total_orders > 0
                            ? round($category->total_sales / $category->total_orders, 2)
                            : 0
                    ];
                }),
            ]
        ]);
    }

    /**
     * Laporan inventory bulanan berdasarkan outlet
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function monthlyInventory(Request $request, Outlet $outlet)
    {
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:2100',
            'month' => 'nullable|integer|min:1|max:12',
        ]);
    
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
    
        $reportDate = Carbon::create($year, $month, 1)->format('Y-m-d');
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        $previousMonthDate = Carbon::create($year, $month, 1)->subMonth()->format('Y-m-d');
    
        // Cek jika laporan sudah ada
        $existingReports = MonthlyInventoryReport::where('outlet_id', $outlet->id)
            ->whereDate('report_date', $reportDate)
            ->with('product')
            ->get();
    
        if ($existingReports->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'data' => [
                    'year' => $year,
                    'month' => $month,
                    'outlet' => $outlet->name,
                    'inventory_reports' => $existingReports,
                    'total_stock_value' => $existingReports->sum('stock_value'),
                ]
            ]);
        }
    
        // Ambil semua produk dengan inventory yang terkait
        $products = Product::whereHas('inventory', function ($query) use ($outlet) {
            $query->where('outlet_id', $outlet->id);
        })->get();
    
        // Preload semua inventory
        $inventories = Inventory::where('outlet_id', $outlet->id)
            ->whereIn('product_id', $products->pluck('id'))
            ->get()
            ->keyBy('product_id');
    
        $reports = [];
    
        foreach ($products as $product) {
            $productId = $product->id;
    
            $currentStock = $inventories[$productId]->quantity ?? 0;
    
            $sales = DB::table('inventory_histories')
                ->where('outlet_id', $outlet->id)
                ->where('product_id', $productId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 'sale')
                ->sum('quantity_change');
    
            $purchases = DB::table('inventory_histories')
                ->where('outlet_id', $outlet->id)
                ->where('product_id', $productId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 'purchase')
                ->sum('quantity_change');
    
            $adjustments = DB::table('inventory_histories')
                ->where('outlet_id', $outlet->id)
                ->where('product_id', $productId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 'adjustment')
                ->sum('quantity_change');
    
            // Opening stock dari bulan sebelumnya
            $previousReport = MonthlyInventoryReport::where('outlet_id', $outlet->id)
                ->where('product_id', $productId)
                ->whereDate('report_date', $previousMonthDate)
                ->first();
    
            $openingStock = $previousReport->closing_stock ?? 0;
            $closingStock = $currentStock;
            $stockValue = $closingStock * ($product->price ?? 0);
    
            $report = MonthlyInventoryReport::create([
                'outlet_id' => $outlet->id,
                'product_id' => $productId,
                'report_date' => $reportDate,
                'opening_stock' => $openingStock,
                'closing_stock' => $closingStock,
                'sales_quantity' => abs($sales),
                'purchase_quantity' => abs($purchases),
                'adjustment_quantity' => $adjustments,
                'stock_value' => $stockValue,
            ]);
    
            $reports[] = $report->id;
        }
    
        $reports = MonthlyInventoryReport::whereIn('id', $reports)
            ->with('product')
            ->get();
    
        return response()->json([
            'status' => true,
            'data' => [
                'year' => $year,
                'month' => $month,
                'outlet' => $outlet->name,
                'inventory_reports' => $reports,
                'total_stock_value' => $reports->sum('stock_value'),
            ]
        ]);
    }
    

    // public function monthlyInventory(Request $request, Outlet $outlet)
    // {
    //     $request->validate([
    //         'year' => 'nullable|integer|min:2000|max:2100',
    //         'month' => 'nullable|integer|min:1|max:12',
    //         'force_refresh' => 'nullable|boolean', // Parameter untuk paksa pembaruan
    //     ]);

    //     $year = $request->year ?: Carbon::now()->year;
    //     $month = $request->month ?: Carbon::now()->month;
    //     $forceRefresh = $request->force_refresh ?: false;

    //     $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    //     $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

    //     try {
    //         // Cek apakah laporan bulanan sudah ada
    //         $existingReports = MonthlyInventoryReport::where('outlet_id', $outlet->id)
    //             ->where('report_date', $startDate->format('Y-m-01'))
    //             ->with('product')
    //             ->get();

    //         if ($existingReports->count() > 0 && !$forceRefresh) {
    //             $totalStockValue = $existingReports->sum('stock_value');

    //             // Hitung product turnover rates dari data yang ada
    //             $productTurnoverRates = $existingReports->map(function ($report) {
    //                 $averageStock = ($report->opening_stock + $report->closing_stock) / 2;
    //                 $salesQuantity = $report->sales_quantity;

    //                 $turnoverRate = $averageStock > 0 ? $salesQuantity / $averageStock : ($salesQuantity > 0 ? 999 : 0);

    //                 return [
    //                     'product_id' => $report->product_id,
    //                     'product_name' => $report->product->name,
    //                     'turnover_rate' => $turnoverRate,
    //                     'sales_quantity' => $salesQuantity,
    //                     'average_stock' => $averageStock,
    //                     'closing_stock' => $report->closing_stock,
    //                     'stock_value' => $report->stock_value
    //                 ];
    //             })->all();

    //             // Calculate fast and slow moving products
    //             $fastMovingProducts = collect($productTurnoverRates)
    //                 ->filter(function ($item) {
    //                     return $item['sales_quantity'] > 0;
    //                 })
    //                 ->sortByDesc('turnover_rate')
    //                 ->take(5)
    //                 ->values();

    //             $slowMovingProducts = collect($productTurnoverRates)
    //                 ->filter(function ($item) {
    //                     return $item['closing_stock'] > 0 && $item['turnover_rate'] >= 0;
    //                 })
    //                 ->sortBy('turnover_rate')
    //                 ->take(5)
    //                 ->values();

    //             return response()->json([
    //                 'status' => true,
    //                 'data' => [
    //                     'year' => $year,
    //                     'month' => $month,
    //                     'outlet' => $outlet->name,
    //                     'is_cached' => true,
    //                     'report_date' => $startDate->format('Y-m-d'),
    //                     'last_updated' => $existingReports->max('updated_at'),
    //                     'inventory_reports' => $existingReports->map(function ($report) {
    //                         return [
    //                             'name' => $report->product->name,
    //                             'opening_stock' => $report->opening_stock,
    //                             'closing_stock' => $report->closing_stock,
    //                             'sales_quantity' => $report->sales_quantity,
    //                             'purchase_quantity' => $report->purchase_quantity,
    //                             'adjustment_quantity' => $report->adjustment_quantity,
    //                             'stock_value' => $report->stock_value
    //                         ];
    //                     }),
    //                     'total_stock_value' => $totalStockValue,
    //                     'fast_moving_products' => $fastMovingProducts,
    //                     'slow_moving_products' => $slowMovingProducts,
    //                 ]
    //             ]);
    //         }

    //         // Generate laporan baru jika tidak ada atau force refresh
    //         $products = Product::whereHas('inventory', function ($query) use ($outlet) {
    //             $query->where('outlet_id', $outlet->id);
    //         })->get();

    //         $reports = [];
    //         $totalStockValue = 0;
    //         $productTurnoverRates = [];

    //         foreach ($products as $product) {
    //             // Get current inventory
    //             $currentInventory = Inventory::where('outlet_id', $outlet->id)
    //                 ->where('product_id', $product->id)
    //                 ->first();

    //             // Get opening stock
    //             $openingStockHistory = DB::table('inventory_histories')
    //                 ->where('outlet_id', $outlet->id)
    //                 ->where('product_id', $product->id)
    //                 ->where('created_at', '<', $startDate)
    //                 ->orderBy('created_at', 'desc')
    //                 ->first();

    //             $openingStock = $openingStockHistory ? $openingStockHistory->quantity_after : 0;

    //             // Get transactions
    //             $salesTransactions = DB::table('inventory_histories')
    //                 ->where('outlet_id', $outlet->id)
    //                 ->where('product_id', $product->id)
    //                 ->whereBetween('created_at', [$startDate, $endDate])
    //                 ->where('type', 'sale')
    //                 ->sum('quantity_change');

    //             $purchaseTransactions = DB::table('inventory_histories')
    //                 ->where('outlet_id', $outlet->id)
    //                 ->where('product_id', $product->id)
    //                 ->whereBetween('created_at', [$startDate, $endDate])
    //                 ->where('type', 'purchase')
    //                 ->sum('quantity_change');

    //             $adjustmentTransactions = DB::table('inventory_histories')
    //                 ->where('outlet_id', $outlet->id)
    //                 ->where('product_id', $product->id)
    //                 ->whereBetween('created_at', [$startDate, $endDate])
    //                 ->where('type', 'adjustment')
    //                 ->sum('quantity_change');

    //             $closingStock = $currentInventory ? $currentInventory->quantity : 0;
    //             $stockValue = $closingStock * $product->price;
    //             $totalStockValue += $stockValue;

    //             // Create or update report
    //             $report = MonthlyInventoryReport::updateOrCreate(
    //                 [
    //                     'outlet_id' => $outlet->id,
    //                     'product_id' => $product->id,
    //                     'report_date' => $startDate->format('Y-m-01')
    //                 ],
    //                 [
    //                     'opening_stock' => abs($openingStock),
    //                     'closing_stock' => abs($closingStock),
    //                     'sales_quantity' => abs($salesTransactions),
    //                     'purchase_quantity' => abs($purchaseTransactions),
    //                     'adjustment_quantity' => $adjustmentTransactions,
    //                     'stock_value' => $stockValue,
    //                     'generated_by' => $request->user()->id ?? null
    //                 ]
    //             );

    //             // Calculate turnover rate
    //             $averageStock = ($openingStock + $closingStock) / 2;
    //             $salesQuantity = abs($salesTransactions);

    //             $turnoverRate = $averageStock > 0 ? $salesQuantity / $averageStock : ($salesQuantity > 0 ? 999 : 0);

    //             $productTurnoverRates[] = [
    //                 'product_id' => $product->id,
    //                 'product_name' => $product->name,
    //                 'turnover_rate' => $turnoverRate,
    //                 'sales_quantity' => $salesQuantity,
    //                 'average_stock' => $averageStock,
    //                 'closing_stock' => $closingStock,
    //                 'stock_value' => $stockValue
    //             ];

    //             $reports[] = $report;
    //         }

    //         // Reload reports with product information
    //         $reports = MonthlyInventoryReport::where('outlet_id', $outlet->id)
    //             ->where('report_date', $startDate->format('Y-m-01'))
    //             ->with('product')
    //             ->get();

    //         // Calculate fast and slow moving products
    //         $fastMovingProducts = collect($productTurnoverRates)
    //             ->filter(function ($item) {
    //                 return $item['sales_quantity'] > 0;
    //             })
    //             ->sortByDesc('turnover_rate')
    //             ->take(5)
    //             ->values();

    //         $slowMovingProducts = collect($productTurnoverRates)
    //             ->filter(function ($item) {
    //                 return $item['closing_stock'] > 0 && $item['turnover_rate'] >= 0;
    //             })
    //             ->sortBy('turnover_rate')
    //             ->take(5)
    //             ->values();

    //         return response()->json([
    //             'status' => true,
    //             'data' => [
    //                 'year' => $year,
    //                 'month' => $month,
    //                 'outlet' => $outlet->name,
    //                 'is_cached' => false,
    //                 'report_date' => $startDate->format('Y-m-d'),
    //                 'last_updated' => now(),
    //                 'inventory_reports' => $reports->map(function ($report) {
    //                     return [
    //                         'name' => $report->product->name,
    //                         'opening_stock' => $report->opening_stock,
    //                         'closing_stock' => $report->closing_stock,
    //                         'sales_quantity' => $report->sales_quantity,
    //                         'purchase_quantity' => $report->purchase_quantity,
    //                         'adjustment_quantity' => $report->adjustment_quantity,
    //                         'stock_value' => $report->stock_value
    //                     ];
    //                 }),
    //                 'total_stock_value' => $totalStockValue,
    //                 'fast_moving_products' => $fastMovingProducts,
    //                 'slow_moving_products' => $slowMovingProducts,
    //             ]
    //         ]);
    //     } catch (\Exception $e) {
    //         \Log::error('Monthly Inventory Report Error: ' . $e->getMessage());
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Error generating monthly inventory report: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Laporan inventory berdasarkan tanggal
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function inventoryByDate(Request $request, Outlet $outlet)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        try {
            $date = Carbon::parse($request->date);
            $isToday = $date->isToday();

            // dd($date->toDateString(), Carbon::today()->toDateString());
            // dd($re);


            if ($isToday) {
                // Jika ini adalah stok hari ini, langsung ambil dari tabel inventory (realtime)
                $inventoryItems = Inventory::where('outlet_id', $outlet->id)
                    ->with(['product.category']) // Pastikan relasi category dimuat untuk menghindari query N+1
                    ->get();

                $totalValue = 0;
                $formattedItems = $inventoryItems->map(function ($item) use (&$totalValue) {
                    $value = $item->quantity * $item->product->price;
                    $totalValue += $value;

                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'sku' => $item->product->sku,
                        'category' => $item->product->category->name,
                        'quantity' => $item->quantity,
                        'min_stock' => $item->min_stock,
                        'price' => $item->product->price,
                        'value' => $value,
                    ];
                });

                return $this->successResponse([
                    'date' => $date->format('Y-m-d'),
                    'outlet' => $outlet->name,
                    'is_realtime' => true,
                    'inventory_items' => $formattedItems,
                    'total_value' => $totalValue,
                ]);
            } else {
                // Jika ini adalah tanggal lampau, hitung dari riwayat stok
                $products = Product::whereHas('inventory', function ($query) use ($outlet) {
                    $query->where('outlet_id', $outlet->id);
                })->with('category')->get();

                $inventoryItems = [];
                $totalValue = 0;

                foreach ($products as $product) {
                    // Ambil histori inventory sampai tanggal tertentu
                    $lastHistory = DB::table('inventory_histories')
                        ->where('outlet_id', $outlet->id)
                        ->where('product_id', $product->id)
                        ->whereDate('created_at', '<=', $date)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($lastHistory) {
                        $quantity = $lastHistory->quantity_after;
                        $value = $quantity * $product->price;
                        $totalValue += $value;

                        $inventoryItems[] = [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'sku' => $product->sku,
                            'category' => $product->category->name,
                            'quantity' => $quantity,
                            'price' => $product->price,
                            'value' => $value,
                        ];
                    }
                }

                return $this->successResponse([
                    'date' => $date->format('Y-m-d'),
                    'outlet' => $outlet->name,
                    'is_realtime' => false,
                    'inventory_items' => $inventoryItems,
                    'total_value' => $totalValue,
                ]);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    /**
     * Laporan shift berdasarkan outlet
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function shiftReport(Request $request, Outlet $outlet)
    {
        $request->validate([
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'cashier_id' => 'nullable|exists:users,id',
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::today()->subDays(7);
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::today()->endOfDay();

        $query = Shift::where('outlet_id', $outlet->id)
            ->whereBetween('start_time', [$startDate, $endDate])
            ->with(['user']);

        if ($request->cashier_id) {
            $query->where('user_id', $request->cashier_id);
        }

        $shifts = $query->orderBy('start_time', 'desc')->get();

        $totalStartingCash = $shifts->sum('starting_cash');
        $totalEndingCash = $shifts->sum('ending_cash');
        $totalExpectedCash = $shifts->sum('expected_cash');
        $totalDifference = $shifts->sum('cash_difference');

        // Ambil order per shift
        $shiftData = $shifts->map(function ($shift) {
            $orders = Order::where('shift_id', $shift->id)
                ->where('status', 'completed')
                ->get();

            $totalSales = $orders->sum('total');
            $orderCount = $orders->count();

            return [
                'id' => $shift->id,
                'cashier' => $shift->user->name,
                'start_time' => $shift->start_time,
                'end_time' => $shift->end_time,
                'duration' => $shift->end_time ? Carbon::parse($shift->start_time)->diffInHours(Carbon::parse($shift->end_time)) : null,
                'starting_cash' => $shift->starting_cash,
                'ending_cash' => $shift->ending_cash,
                'expected_cash' => $shift->expected_cash,
                'difference' => $shift->cash_difference,
                'status' => $shift->is_closed ? 'Closed' : 'Open',
                'sales' => $totalSales,
                'orders' => $orderCount,
            ];
        });

        return response()->json([
            'status' => true,
            'data' => [
                'outlet' => $outlet->name,
                'period' => [
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                ],
                'summary' => [
                    'total_shifts' => $shifts->count(),
                    'total_starting_cash' => $totalStartingCash,
                    'total_ending_cash' => $totalEndingCash,
                    'total_expected_cash' => $totalExpectedCash,
                    'total_difference' => $totalDifference,
                ],
                'shifts' => $shiftData,
            ]
        ]);
    }

    /**
     * Dashboard summary berdasarkan outlet
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function dashboardSummaryOld(Request $request, Outlet $outlet)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfYesterday = Carbon::yesterday()->endOfDay();

        // Sales hari ini
        $todaySales = Order::where('outlet_id', $outlet->id)
            ->whereBetween('created_at', [$today->startOfDay(), $today->endOfDay()])
            ->where('status', 'completed')
            ->sum('total');

        // Sales kemarin
        $yesterdaySales = Order::where('outlet_id', $outlet->id)
            ->whereBetween('created_at', [$yesterday->startOfDay(), $yesterday->endOfDay()])
            ->where('status', 'completed')
            ->sum('total');

        // Persentase perubahan
        $salesChange = $yesterdaySales > 0
            ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100
            : ($todaySales > 0 ? 100 : 0);

        // Order hari ini
        $todayOrders = Order::where('outlet_id', $outlet->id)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        // Sales bulan ini
        $thisMonthSales = Order::where('outlet_id', $outlet->id)
            ->where('created_at', '>=', $thisMonth)
            ->where('status', 'completed')
            ->sum('total');

        // Sales bulan lalu
        $lastMonthSales = Order::where('outlet_id', $outlet->id)
            ->whereBetween('created_at', [$lastMonth, $thisMonth->copy()->subDay()])
            ->where('status', 'completed')
            ->sum('total');

        // Monthly change
        $monthlySalesChange = $lastMonthSales > 0
            ? (($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100
            : ($thisMonthSales > 0 ? 100 : 0);

        // Top 5 produk hari ini
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as quantity'),
                DB::raw('SUM(order_items.subtotal) as total')
            )
            ->where('orders.outlet_id', $outlet->id)
            ->whereDate('orders.created_at', $today)
            ->where('orders.status', 'completed')
            ->groupBy('products.name')
            ->orderByDesc('quantity')
            ->limit(5)
            ->get();

        // Stok yang perlu perhatian (low stock)
        $lowStock = Inventory::where('outlet_id', $outlet->id)
            ->where('quantity', '<', $outlet->min_stock)
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'min_stock' => 10,
                ];
            });

        // Shift aktif
        $activeShift = Shift::where('outlet_id', $outlet->id)
            ->where('is_closed', false)
            ->with('user')
            ->first();

        return response()->json([
            'status' => true,
            'data' => [
                'outlet' => $outlet->name,
                'date' => $today->format('Y-m-d'),
                'sales' => [
                    'today' => $todaySales,
                    'yesterday' => $yesterdaySales,
                    'change_percentage' => round($salesChange, 2),
                    'this_month' => $thisMonthSales,
                    'last_month' => $lastMonthSales,
                    'monthly_change_percentage' => round($monthlySalesChange, 2),
                ],
                'orders_today' => $todayOrders,
                'top_products' => $topProducts,
                'low_stock_items' => $lowStock,
                'active_shift' => $activeShift ? [
                    'cashier' => $activeShift->user->name,
                    'started_at' => $activeShift->start_time,
                    'duration' => Carbon::parse($activeShift->start_time)->diffForHumans(null, true), // contoh: "3 hours"
                ] : null,
            ]
        ]);
    }

    //baru 
    public function dashboardSummary(Request $request, Outlet $outlet)
    {
        try {
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            $thisMonth = Carbon::now()->startOfMonth();
            $lastMonth = Carbon::now()->subMonth()->startOfMonth();

            // Get start and end of week
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            // Data untuk response
            $responseData = [
                'outlet' => $outlet->name,
                'cash' => $outlet->cashRegisters->balance,
                'date' => $today->format('Y-m-d'),
                'summary' => [],
                'sales' => [],
                // 'orders_today' => 0,
                'daily_sales' => [], // Ganti hourly_sales menjadi daily_sales
                'category_sales' => [],
                'payment_method_sales' => [],
                'top_products' => [],
                'low_stock_items' => [],
                'active_shift' => null,
            ];

            try {
                // Daily sales data
                $sales = Order::where('outlet_id', $outlet->id)
                    ->whereDate('created_at', $today)
                    ->where('status', 'completed')
                    ->get();

                $totalSales = $sales->sum('total');
                $totalItems = OrderItem::whereIn('order_id', $sales->pluck('id'))->sum('quantity');
                $totalOrders = $sales->count();
                $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

                $responseData['summary'] = [
                    'total_sales' => $totalSales,
                    'total_orders' => $totalOrders,
                    'total_items' => $totalItems,
                    'average_order_value' => $averageOrderValue,
                ];

                // Sales comparison data
                $yesterdaySales = Order::where('outlet_id', $outlet->id)
                    ->whereDate('created_at', $yesterday)
                    ->where('status', 'completed')
                    ->sum('total');

                $salesChange = $yesterdaySales > 0
                    ? (($totalSales - $yesterdaySales) / $yesterdaySales) * 100
                    : ($totalSales > 0 ? 100 : 0);

                // Monthly sales data
                $thisMonthSales = Order::where('outlet_id', $outlet->id)
                    ->whereMonth('created_at', $today->month)
                    ->whereYear('created_at', $today->year)
                    ->where('status', 'completed')
                    ->sum('total');

                $lastMonthSales = Order::where('outlet_id', $outlet->id)
                    ->whereMonth('created_at', $lastMonth->month)
                    ->whereYear('created_at', $lastMonth->year)
                    ->where('status', 'completed')
                    ->sum('total');

                $monthlySalesChange = $lastMonthSales > 0
                    ? (($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100
                    : ($thisMonthSales > 0 ? 100 : 0);

                $responseData['sales'] = [
                    'today' => $totalSales,
                    'yesterday' => $yesterdaySales,
                    'change_percentage' => round($salesChange, 2),
                    'this_month' => $thisMonthSales,
                    'last_month' => $lastMonthSales,
                    'monthly_change_percentage' => round($monthlySalesChange, 2),
                ];

                // Daily sales data (per day of week)
                $weeklyOrders = Order::where('outlet_id', $outlet->id)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->where('status', 'completed')
                    ->get();

                $dailySalesData = [];
                $daysOfWeek = [
                    'Senin' => 1,
                    'Selasa' => 2,
                    'Rabu' => 3,
                    'Kamis' => 4,
                    'Jumat' => 5,
                    'Sabtu' => 6,
                    'Minggu' => 0,
                ];

                // Initialize data for each day
                foreach ($daysOfWeek as $day => $dayNumber) {
                    $dailySalesData[$day] = [
                        'orders' => 0,
                        'sales' => 0,
                        'items' => 0,
                        'average_order' => 0,
                        'day_number' => $dayNumber,
                    ];
                }

                // Fill in the actual data
                foreach ($weeklyOrders as $order) {
                    $dayName = Carbon::parse($order->created_at)->locale('id')->isoFormat('dddd');
                    $dayItems = OrderItem::where('order_id', $order->id)->sum('quantity');

                    $dailySalesData[$dayName]['orders']++;
                    $dailySalesData[$dayName]['sales'] += $order->total;
                    $dailySalesData[$dayName]['items'] += $dayItems;
                }

                // Calculate averages and format data
                foreach ($dailySalesData as $day => &$data) {
                    $data['average_order'] = $data['orders'] > 0 ?
                        round($data['sales'] / $data['orders'], 2) : 0;

                    // Format numbers
                    $data['sales'] = round($data['sales'], 2);
                    $data['average_order'] = round($data['average_order'], 2);
                }

                // Sort by day number
                uasort($dailySalesData, function ($a, $b) {
                    return $a['day_number'] - $b['day_number'];
                });

                $responseData['daily_sales'] = $dailySalesData;

                // Category sales data
                $responseData['category_sales'] = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->select(
                        'categories.name',
                        DB::raw('SUM(order_items.quantity) as total_quantity'),
                        DB::raw('SUM(order_items.subtotal) as total_sales')
                    )
                    ->where('orders.outlet_id', $outlet->id)
                    ->whereDate('orders.created_at', $today)
                    ->where('orders.status', 'completed')
                    ->groupBy('categories.name')
                    ->get();

                // Payment method sales data
                $responseData['payment_method_sales'] = $sales->groupBy('payment_method')
                    ->map(function ($items) {
                        return [
                            'count' => $items->count(),
                            'total' => $items->sum('total'),
                        ];
                    });

                // Top products data
                $responseData['top_products'] = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->select(
                        'products.name',
                        DB::raw('SUM(order_items.quantity) as quantity'),
                        DB::raw('SUM(order_items.subtotal) as total')
                    )
                    ->where('orders.outlet_id', $outlet->id)
                    ->whereDate('orders.created_at', $today)
                    ->where('orders.status', 'completed')
                    ->groupBy('products.name')
                    ->orderByDesc('quantity')
                    ->limit(5)
                    ->get();

                // Low stock items
                $minStock = $outlet->min_stock ?? 10;
                $responseData['low_stock_items'] = Inventory::where('outlet_id', $outlet->id)
                    ->where('quantity', '<', $minStock)
                    ->with('product')
                    ->get()
                    ->map(function ($item) use ($minStock) {
                        return [
                            'product_name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'min_stock' => $minStock,
                        ];
                    });

                // Active shift
                $activeShift = Shift::where('outlet_id', $outlet->id)
                    // ->where('is_closed', true)
                    ->with('user')
                    ->first();

                if ($activeShift) {
                    $responseData['active_shift'] = [
                        'cashier' => $activeShift->user->name,
                        'started_at' => $activeShift->start_time,
                        'duration' => Carbon::parse($activeShift->start_time)->diffForHumans(null, true),
                    ];
                }

                return $this->successResponse($responseData, 'Successfully getting dashboard data');

                // return response()->json([
                //     'status' => true,
                //     'data' => $responseData
                // ]);
            } catch (\Exception $e) {
                \Log::error('Error in data gathering: ' . $e->getMessage());
                // throw $e;

                return $this->errorResponse('Error in data gathering', $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Daily sales error: ' . $e->getMessage());
            return $this->errorResponse('Error in data gathering', $e->getMessage());
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Error generating daily sales report: ' . $e->getMessage()
            // ], 500);
        }
    }
}
