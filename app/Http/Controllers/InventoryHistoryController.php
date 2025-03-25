<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryHistoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $inventoryHistory = InventoryHistory::all()->load('outlet', 'product', 'user')->sortByDesc('created_at');
            return $this->successResponse($inventoryHistory, 'Inventory history retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'outlet_id' => 'required|exists:outlets,id',
                'product_id' => 'required|exists:products,id',
                'quantity_change' => 'required|integer',
                'type' => 'required|in:purchase,sale,adjustment,transfer,stocktake',
                'notes' => 'nullable|string',
            ]);

            DB::transaction(function () use ($request) {
                $inventory = Inventory::firstOrCreate(
                    [
                        'outlet_id' => $request->outlet_id,
                        'product_id' => $request->product_id,
                    ],
                    ['quantity' => 0]
                );

                $quantityBefore = $inventory->quantity;

                $inventory->quantity += $request->quantity_change;
                $inventory->save();

                InventoryHistory::create([
                    'outlet_id' => $request->outlet_id,
                    'product_id' => $request->product_id,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $inventory->quantity,
                    'quantity_change' => $request->quantity_change,
                    'type' => $request->type,
                    'notes' => $request->notes,
                    'user_id' => $request->user()->id,
                ]);
            });
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getStock($outletId, $productId)
    {
        try {
            $inventory = Inventory::where('outlet_id', $outletId)
                ->where('product_id', $productId)
                ->first();

            if (!$inventory) {
                return $this->errorResponse('Stok tidak ditemukan', 404);
            }

            return $this->successResponse($inventory->quantity, 'Stok retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryHistory $inventoryHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryHistory $inventoryHistory) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryHistory $inventoryHistory)
    {
        //
    }
}
