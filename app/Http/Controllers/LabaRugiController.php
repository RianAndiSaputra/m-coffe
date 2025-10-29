<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\RawMaterialPurchase;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'outlet_id' => 'nullable|exists:outlets,id',
        ]);

        $data = $this->calculateProfitLoss(
            $request->start_date,
            $request->end_date,
            $request->outlet_id
        );

        return response()->json($data);
    }

    /**
     * Data untuk chart/grafik
     */
    public function chartData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'outlet_id' => 'nullable|exists:outlets,id',
        ]);

        $data = $this->calculateProfitLoss(
            $request->start_date,
            $request->end_date,
            $request->outlet_id
        );

        return response()->json([
            'labels' => array_column($data['daily_breakdown'], 'date'),
            'revenue' => array_column($data['daily_breakdown'], 'revenue'),
            'cost' => array_column($data['daily_breakdown'], 'raw_material_cost'),
            'profit' => array_column($data['daily_breakdown'], 'gross_profit'),
        ]);
    }

    /**
     * Hitung laba rugi berdasarkan rentang tanggal
     */
    private function calculateProfitLoss($startDate, $endDate, $outletId = null)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Hitung total pendapatan dari orders yang completed
        $revenueData = $this->calculateRevenue($start, $end, $outletId);
        
        // Hitung total biaya bahan baku
        $rawMaterialCost = $this->calculateRawMaterialCost($start, $end, $outletId);
        
        // Hitung laba kotor
        $grossProfit = max(0, $revenueData['total_revenue'] - $rawMaterialCost);
        
        // Hitung margin laba (%)
        $profitMargin = $revenueData['total_revenue'] > 0 
            ? max(0, ($grossProfit / $revenueData['total_revenue']) * 100)
            : 0;
        
        // Hitung persentase biaya bahan baku terhadap pendapatan (%)
        $rawMaterialPercentage = $revenueData['total_revenue'] > 0 
            ? ($rawMaterialCost / $revenueData['total_revenue']) * 100 
            : 0;

        return [
            'period' => [
                'start_date' => $start->format('Y-m-d'),
                'end_date' => $end->format('Y-m-d'),
                'days' => $start->diffInDays($end) + 1,
            ],
            'revenue' => [
                'total_revenue' => round($revenueData['total_revenue'], 2),
                'total_orders' => $revenueData['total_orders'],
                'average_order_value' => round($revenueData['average_order_value'], 2),
                'subtotal' => round($revenueData['subtotal'], 2),
                'tax' => round($revenueData['tax'], 2),
                'discount' => round($revenueData['discount'], 2),
            ],
            'raw_material_cost' => [
                'total_cost' => round($rawMaterialCost, 2),
                'total_purchases' => $this->getTotalPurchases($start, $end, $outletId),
                'percentage_of_revenue' => round($rawMaterialPercentage, 2),
            ],
            'profit_summary' => [
                'gross_profit' => round($grossProfit, 2),
                'profit_margin_percentage' => round($profitMargin, 2),
                'revenue_vs_cost_ratio' => $rawMaterialCost > 0 
                    ? round($revenueData['total_revenue'] / $rawMaterialCost, 2) 
                    : 0,
            ],
            'daily_breakdown' => $this->getDailyBreakdown($start, $end, $outletId),
        ];
    }

    /**
     * Hitung total pendapatan
     */
    private function calculateRevenue($start, $end, $outletId = null)
    {
        $query = Order::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end]);

        if ($outletId) {
            $query->where('outlet_id', $outletId);
        }

        $orders = $query->select(
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total) as total_revenue'),
            DB::raw('SUM(subtotal) as subtotal'),
            DB::raw('SUM(tax) as tax'),
            DB::raw('SUM(discount) as discount')
        )->first();

        $totalRevenue = $orders->total_revenue ?? 0;
        $totalOrders = $orders->total_orders ?? 0;

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'average_order_value' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
            'subtotal' => $orders->subtotal ?? 0,
            'tax' => $orders->tax ?? 0,
            'discount' => $orders->discount ?? 0,
        ];
    }

    /**
     * Hitung total biaya bahan baku
     */
    private function calculateRawMaterialCost($start, $end, $outletId = null)
    {
        $query = RawMaterialPurchase::whereBetween('purchase_date', [$start, $end]);

        if ($outletId) {
            $query->where('outlet_id', $outletId);
        }

        return $query->sum('total_amount') ?? 0;
    }

    /**
     * Hitung total jumlah pembelian bahan baku
     */
    private function getTotalPurchases($start, $end, $outletId = null)
    {
        $query = RawMaterialPurchase::whereBetween('purchase_date', [$start, $end]);

        if ($outletId) {
            $query->where('outlet_id', $outletId);
        }

        return $query->count();
    }

    /**
     * Breakdown harian pendapatan vs biaya
     */
    private function getDailyBreakdown($start, $end, $outletId = null)
    {
        $dailyData = [];
        $currentDate = $start->copy();

        while ($currentDate->lte($end)) {
            $dayStart = $currentDate->copy()->startOfDay();
            $dayEnd = $currentDate->copy()->endOfDay();

            $revenueQuery = Order::where('status', 'completed')
                ->whereBetween('created_at', [$dayStart, $dayEnd]);

            $costQuery = RawMaterialPurchase::whereDate('purchase_date', $currentDate);

            if ($outletId) {
                $revenueQuery->where('outlet_id', $outletId);
                $costQuery->where('outlet_id', $outletId);
            }

            $dailyRevenue = $revenueQuery->sum('total') ?? 0;
            $dailyCost = $costQuery->sum('total_amount') ?? 0;
            $dailyProfit = $dailyRevenue - $dailyCost;

            $dailyData[] = [
                'date' => $currentDate->format('Y-m-d'),
                'revenue' => round($dailyRevenue, 2),
                'raw_material_cost' => round($dailyCost, 2),
                'gross_profit' => round($dailyProfit, 2),
                'profit_margin' => $dailyRevenue > 0 
                    ? round(($dailyProfit / $dailyRevenue) * 100, 2) 
                    : 0,
            ];

            $currentDate->addDay();
        }

        return $dailyData;
    }
}
