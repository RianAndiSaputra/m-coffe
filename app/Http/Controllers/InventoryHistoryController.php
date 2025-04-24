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
                'type' => 'required|in:purchase,sale,adjustment,transfer,stocktake,shipment,other',
                'notes' => 'nullable|string',
            ]);

            DB::beginTransaction();

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

            $inventoryHistory = InventoryHistory::create([
                'outlet_id' => $request->outlet_id,
                'product_id' => $request->product_id,
                'quantity_before' => $quantityBefore,
                'quantity_after' => $inventory->quantity,
                'quantity_change' => $request->quantity_change,
                'type' => $request->type,
                'notes' => $request->notes,
                'user_id' => $request->user()->id,
            ]);

            DB::commit();

            return $this->successResponse($inventoryHistory, 'Inventory history created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function cashierAdjustStock(Request $request)
    {
        try {
            $request->validate([
                'outlet_id' => 'required|exists:outlets,id',
                'product_id' => 'required|exists:products,id',
                'quantity_change' => 'required|integer',
                'type' => 'required|in:purchase,sale,adjustment,transfer,stocktake,shipment,other',
                'notes' => 'nullable|string',
            ]);

            $inventory = Inventory::firstOrCreate(
                [
                    'outlet_id' => $request->outlet_id,
                    'product_id' => $request->product_id,
                ],
                ['quantity' => 0]
            );

            $quantityBefore = $inventory->quantity;

            // Cek apakah tipe transaksi adalah adjustment
            if ($request->type === 'adjustment') {
                // Jika adjustment, hanya catat permintaan dan tunggu persetujuan admin
                $inventoryHistory = InventoryHistory::create([
                    'outlet_id' => $request->outlet_id,
                    'product_id' => $request->product_id,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $quantityBefore, // Belum berubah
                    'quantity_change' => $request->quantity_change,
                    'type' => $request->type,
                    'notes' => $request->notes,
                    'user_id' => $request->user()->id,
                    'status' => 'pending', // Menunggu persetujuan
                ]);

                return $this->successResponse($inventoryHistory, 'Stock adjustment request has been submitted and is awaiting admin approval.');
            } else {
                // Untuk tipe transaksi lainnya, langsung ubah stok
                DB::beginTransaction();

                // Update quantity
                $inventory->quantity += $request->quantity_change;
                $inventory->save();

                // Catat riwayat dengan status approved
                $inventoryHistory = InventoryHistory::create([
                    'outlet_id' => $request->outlet_id,
                    'product_id' => $request->product_id,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $inventory->quantity,
                    'quantity_change' => $request->quantity_change,
                    'type' => $request->type,
                    'notes' => $request->notes,
                    'user_id' => $request->user()->id,
                    'status' => 'approved', // Langsung approved
                    'approved_by' => $request->user()->id,
                    'approved_at' => now(),
                ]);

                DB::commit();

                return $this->successResponse($inventoryHistory, 'Stock has been updated successfully.');
            }
        } catch (\Throwable $th) {
            if (isset($db) && $db instanceof \Illuminate\Database\ConnectionInterface) {
                DB::rollBack();
            }
            return $this->errorResponse($th->getMessage());
        }
    }

    public function adminApprovStock(Request $request)
    {
        try {
            $request->validate([
                'inventory_history_id' => 'required|exists:inventory_histories,id',
            ]);

            $inventoryHistory = InventoryHistory::where('id', $request->inventory_history_id)
                ->where('status', 'pending')
                ->first();

            if (!$inventoryHistory) {
                return $this->errorResponse('No pending stock adjustment found for the provided ID.');
            }

            DB::beginTransaction();

            $inventory = Inventory::firstOrCreate(
                [
                    'outlet_id' => $inventoryHistory->outlet_id,
                    'product_id' => $inventoryHistory->product_id,
                ],
                ['quantity' => 0]
            );
            $quantityBefore = $inventory->quantity;
            $inventory->quantity += $inventoryHistory->quantity_change;
            $inventory->save();

            $inventoryHistory->update([
                'quantity_before' => $quantityBefore,
                'quantity_after'  => $inventory->quantity,
                'status' => 'approved',
                'approved_by' => $request->user()->id,
                'approved_at' => now(),
            ]);

            DB::commit();

            return $this->successResponse($inventoryHistory, 'Stock adjustment approved successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function adminRejectStock(Request $request)
    {
        try {
            $request->validate([
                'inventory_history_id' => 'required|exists:inventory_histories,id',
            ]);

            $inventoryHistory = InventoryHistory::where('id', $request->inventory_history_id)
                ->where('status', 'pending')
                ->first();

            if (!$inventoryHistory) {
                return $this->errorResponse('No pending stock adjustment found for the provided ID.');
            }

            $inventoryHistory->update([
                'status' => 'rejected',
                'approved_by' => $request->user()->id,
                'approved_at' => now(),
            ]);

            return $this->successResponse($inventoryHistory, 'Stock adjustment has been rejected.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }


    public function showCashierInventoryHistories(Request $request, $outletId)
    {
        try {

            $date = $request->date;

            $cashierHistories = InventoryHistory::with(['user', 'product'])
                ->where('outlet_id', $outletId)
                ->where('type', '!=', 'sale')
                ->when($date, function ($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->whereHas('user', function ($query) {
                    $query->where('role', 'kasir');
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return $this->successResponse(
                $cashierHistories,
                'Inventory histories from cashier retrieved successfully.'
            );
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getStock($outletId)
    {
        try {
            $inventory = Inventory::where('outlet_id', $outletId)
                ->with(['stockByType', 'product.category'])
                ->get();

            return $this->successResponse($inventory, 'Stok retrieved successfully');
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

    public function getHistoryByOutlet(Request $request, $outletId)
    {
        try {
            $date = $request->date;
            $inventoryHistory = InventoryHistory::where('outlet_id', $outletId)->where('created_at', 'like', '%' . $date . '%')->with('outlet', 'product', 'user')->orderBy('created_at', 'desc')->get();
            return $this->successResponse($inventoryHistory, 'Inventory history retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
