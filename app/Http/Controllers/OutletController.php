<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\Outlet;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
                'tax' => 'nullable|numeric|min:0',
                'qris' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            ]);

            DB::beginTransaction();
            
            if ($request->hasFile('qris')) {
                $path = $request->file('qris')->store('qris', 'public');
                $qrisPath = $path;
            }

            $outlet = Outlet::create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'tax' => $request->tax,
                'qris' => $qrisPath,
            ]);
            CashRegister::create([
                'outlet_id' => $outlet->id,
                'balance' => 0, 
                'is_active' => true,
            ]);
            DB::commit();
            return $this->successResponse($outlet, 'Outlet created successfully');
        } catch (ValidationException $th) {
            DB::rollBack();
            return $this->errorResponse('Validation error', $th->errors());
        }catch (\Throwable $th) {
            DB::rollBack();
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
        try {
            
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'is_active' => 'required|boolean',
                'tax' => 'nullable|numeric|min:0',
                'qris' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            ]);

            $qrisPath = $outlet->qris;

            if ($request->hasFile('qris')) {
                $path = $request->file('qris')->store('qris', 'public');
                $qrisPath = $path;
            }

            $outlet->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'tax' => $request->tax,
                'qris' => $qrisPath,
                'is_active' => $request->is_active,
            ]);
            return $this->successResponse($outlet, 'Outlet updated successfully');
        }
        catch (ValidationException $th) {
            return $this->errorResponse('Validation error', $th->errors());
        }
        
        catch (\Throwable $th) {
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
