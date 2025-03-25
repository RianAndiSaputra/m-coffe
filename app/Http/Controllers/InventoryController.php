<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $inventory = Inventory::all()->load('product', 'outlet', 'user');
            return $this->successResponse($inventory, 'Inventory retrieved successfully');
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
                'product_id' => 'required|exists:products,id',
                'outlet_id' => 'required|exists:outlets,id',
                'user_id' => 'required|exists:users,id',
                'min_stock' => 'required|integer',
                'quantity' => 'required|integer',
            ]);
            $inventory = Inventory::create($request->all());
            return $this->successResponse($inventory, 'Inventory created successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        try {
            $inventory->load('product', 'outlet', 'user');
            return $this->successResponse($inventory, 'Inventory retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'outlet_id' => 'required|exists:outlets,id',
                'user_id' => 'required|exists:users,id',
                'min_stock' => 'required|integer',
                'quantity' => 'required|integer',
            ]);
            $inventory->update($request->all());
            return $this->successResponse($inventory, 'Inventory updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();
            return $this->successResponse(null, 'Inventory deleted successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
