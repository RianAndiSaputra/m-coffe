<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $outlets = Outlet::all();
            return $this->successResponse($outlets, 'Outlets retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:outlets',
            ]);

            $outlet = Outlet::create($request->all());
            return $this->successResponse($outlet, 'Outlet created successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Outlet $outlet)
    {
        try {
            $outlet->load([
                'users',
                'products',
                'shifts',
                'orders',
                'inventory'
            ]);

            return $this->successResponse($outlet, 'Outlet retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outlet $outlet)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:outlets,email,' . $outlet->id,
            'is_active' => 'required|boolean',
        ]);

        try {
        
            $outlet->update($request->all());
            return $this->successResponse($outlet, 'Outlet updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Outlet update failed', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outlet $outlet)
    {
        try {
            $outlet->delete();
            return $this->successResponse(null, 'Outlet deleted successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Outlet deletion failed', $th->getMessage());
        }
    }
}
