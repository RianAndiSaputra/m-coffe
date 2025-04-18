<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $members = Member::all();
            return $this->successResponse($members, 'Successfully retrieved members');
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
                'name' => 'required|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|string|email',
                'address' => 'nullable|string',
                'gender' => 'nullable|string|in:male,female'
            ]);

            $member = Member::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'gender' => $request->gender
            ]);

            return $this->successResponse($member, "Member created successfully");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|string|email',
                'address' => 'nullable|string',
                'gender' => 'nullable|string|in:male,female'
            ]);

            $member->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'gender' => $request->gender
            ]);

            return $this->successResponse($member, "Member created successfully");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return $this->successResponse(null, 'Member deleted successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
