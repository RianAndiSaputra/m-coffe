<?php

namespace App\Http\Controllers;

use App\Models\RawMaterialStock;
use App\Models\RawMaterialStockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class RawMaterialStockController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = RawMaterialStock::query()
                ->with(['outlet:id,name', 'rawMaterial:id,name,min_stock'])
                ->when($request->outlet_id, fn($q) => $q->where('outlet_id', $request->outlet_id))
                ->when($request->raw_material_id, fn($q) => $q->where('raw_material_id', $request->raw_material_id))
                ->when(
                    $request->boolean('low_stock'),
                    fn($q) => $q->whereHas('rawMaterial', fn(Builder $sub) =>
                        $sub->whereColumn('raw_material_stocks.current_stock', '<', 'raw_materials.min_stock')
                    )
                );

            // Use pagination and indexing optimization
            $stocks = $query
                ->orderBy('raw_material_id')
                ->orderBy('outlet_id')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'data' => $stocks->items(),
                'meta' => [
                    'current_page' => $stocks->currentPage(),
                    'per_page' => $stocks->perPage(),
                    'total' => $stocks->total(),
                ]
            ]);

        } catch (\Throwable $e) {
            Log::error('Error fetching raw material stock list: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to fetch raw material stock data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getLowStock(Request $request)
    {
        try {
            $query = RawMaterialStock::query()
                ->with(['outlet:id,name', 'rawMaterial:id,name,min_stock'])
                ->whereHas('rawMaterial', fn($q) =>
                    $q->whereColumn('raw_material_stocks.current_stock', '<', 'raw_materials.min_stock')
                )
                ->when($request->outlet_id, fn($q) => $q->where('outlet_id', $request->outlet_id));

            $lowStocks = $query
                ->orderBy('raw_material_id')
                ->get(['id', 'raw_material_id', 'outlet_id', 'current_stock']);

            return response()->json(['data' => $lowStocks]);

        } catch (\Throwable $e) {
            Log::error('Error fetching low stock data: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to fetch low stock data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStockHistory(Request $request)
    {
        try {
            $query = RawMaterialStockHistory::query()
                ->with([
                    'outlet:id,name',
                    'rawMaterial:id,name,unit',
                    'user:id,name',
                    'product:id,name',
                    'order:id,order_number'
                ])
                ->when($request->outlet_id, fn($q) => $q->where('outlet_id', $request->outlet_id))
                ->when($request->raw_material_id, fn($q) => $q->where('raw_material_id', $request->raw_material_id))
                ->when($request->type, fn($q) => $q->where('type', $request->type))
                ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
                ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to));

            $history = $query
                ->orderByDesc('created_at')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'data' => $history->items(),
                'meta' => [
                    'current_page' => $history->currentPage(),
                    'per_page' => $history->perPage(),
                    'total' => $history->total(),
                ]
            ]);

        } catch (\Throwable $e) {
            Log::error('Error fetching stock history: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Failed to fetch stock history.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
