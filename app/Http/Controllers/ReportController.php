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
        ]);

        $year = $request->year ?: Carbon::now()->year;
        $month = $request->month ?: Carbon::now()->month;

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Cek apakah laporan bulanan sudah ada
        $existingReport = MonthlyReport::where('outlet_id', $outlet->id)
            ->where('report_date', $startDate->format('Y-m-01'))
            ->first();

        if ($existingReport) {
            // Ambil data laporan yang tersimpan
            $reportData = [
                'total_sales' => $existingReport->total_sales,
                'total_transactions' => $existingReport->total_transactions,
                'average_transaction' => $existingReport->average_transaction,
                'report_date' => $existingReport->report_date,
            ];
        } else {
            // Generate laporan baru
            $sales = Order::where('outlet_id', $outlet->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->get();

            $totalSales = $sales->sum('total');
            $totalTransactions = $sales->count();
            $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

            // Simpan laporan bulanan
            $report = new MonthlyReport();
            $report->outlet_id = $outlet->id;
            $report->report_date = $startDate->format('Y-m-d');
            $report->total_sales = $totalSales;
            $report->total_transactions = $totalTransactions;
            $report->average_transaction = $averageTransaction;
            $report->generated_by = $request->user()->id;
            $report->save();

            $reportData = [
                'total_sales' => $totalSales,
                'total_transactions' => $totalTransactions,
                'average_transaction' => $averageTransaction,
                'report_date' => $startDate->format('Y-m-d'),
            ];
        }

        // Data penjualan harian dalam bulan
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

        $year = $request->year ?: Carbon::now()->year;
        $month = $request->month ?: Carbon::now()->month;

        $reportDate = Carbon::createFromDate($year, $month, 1)->format('Y-m-d');

        // Cek apakah laporan sudah ada
        $existingReports = MonthlyInventoryReport::where('outlet_id', $outlet->id)
            ->where('report_date', $reportDate)
            ->with('product') // Eager load product data
            ->get();

        if ($existingReports->count() > 0) {
            // Return laporan yang sudah ada
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

        // Jika belum ada laporan, generate laporan baru
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $previousMonthDate = Carbon::createFromDate($year, $month, 1)->subMonth()->format('Y-m-d');

        // Ambil produk di outlet
        $products = Product::whereHas('inventory', function ($query) use ($outlet) {
            $query->where('outlet_id', $outlet->id);
        })->get();

        $reports = [];
        $totalStockValue = 0;

        foreach ($products as $product) {
            // Cek inventory saat ini
            $currentStock = Inventory::where('outlet_id', $outlet->id)
                ->where('product_id', $product->id)
                ->first();

            // Riwayat transaksi inventory
            $historySales = DB::table('inventory_histories')
                ->where('outlet_id', $outlet->id)
                ->where('product_id', $product->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 'sale')
                ->sum('quantity_change');

            $historyPurchases = DB::table('inventory_histories')
                ->where('outlet_id', $outlet->id)
                ->where('product_id', $product->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 'purchase')
                ->sum('quantity_change');

            $historyAdjustments = DB::table('inventory_histories')
                ->where('outlet_id', $outlet->id)
                ->where('product_id', $product->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('type', 'adjustment')
                ->sum('quantity_change');

            // Cari laporan bulan sebelumnya untuk opening stock
            $previousMonthReport = MonthlyInventoryReport::where('outlet_id', $outlet->id)
                ->where('product_id', $product->id)
                ->where('report_date', $previousMonthDate)
                ->first();

            $openingStock = $previousMonthReport ? $previousMonthReport->closing_stock : 0;
            $closingStock = $currentStock ? $currentStock->quantity : 0;
            $stockValue = $closingStock * $product->price;
            $totalStockValue += $stockValue;

            // Create report
            $report = new MonthlyInventoryReport();
            $report->outlet_id = $outlet->id;
            $report->product_id = $product->id;
            $report->report_date = $reportDate;
            $report->opening_stock = $openingStock;
            $report->closing_stock = $closingStock;
            $report->sales_quantity = abs($historySales);
            $report->purchase_quantity = abs($historyPurchases);
            $report->adjustment_quantity = $historyAdjustments;
            $report->stock_value = $stockValue;
            $report->save();

            $reports[] = $report;
        }

        // Eager load product information
        $reports = MonthlyInventoryReport::whereIn('id', collect($reports)->pluck('id'))
            ->with('product')
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'year' => $year,
                'month' => $month,
                'outlet' => $outlet->name,
                'inventory_reports' => $reports,
                'total_stock_value' => $totalStockValue,
            ]
        ]);
    }

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
    public function dashboardSummary(Request $request, Outlet $outlet)
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
    
}
