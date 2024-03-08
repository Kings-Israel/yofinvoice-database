<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionDataRequest;
use App\Http\Requests\UpdatePermissionDataRequest;
use App\Http\Resources\PermissionListResource;
use App\Models\PermissionData;

class PermissionDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'permissions' => PermissionListResource::collection(PermissionData::withCount('roleIDs')->get()),
        ]);
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
    public function store(StorePermissionDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PermissionData $permissionData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermissionData $permissionData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionDataRequest $request, PermissionData $permissionData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionData $permissionData)
    {
        //
    }
}
