<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleTypeRequest;
use App\Http\Requests\UpdateRoleTypeRequest;
use App\Models\RoleType;

class RoleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(RoleType::with('Groups.AccessGroups')->get());

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
    public function store(StoreRoleTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleType $roleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleType $roleType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleTypeRequest $request, RoleType $roleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleType $roleType)
    {
        //
    }
}
