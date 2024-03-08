<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRoleTypeRequest;
use App\Models\PermissionData;
use App\Models\RoleType;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $role = PermissionData::create([
            'RoleName' => $request->input('RoleName'),
            'RoleTypeName' => $request->input('RoleTypeName'),
            'RoleDescription' => $request->input('RoleDescription'),
        ]);

        foreach ($request->input('RoleIDs') as $roleID) {
            $role->roleIDs()->create([
                'RoleID' => $roleID,
                'access_right_group_id' => $roleID,
            ]);
        }
        info($role);
        if ($role) {
            return response()->json(['message' => 'Role Created Successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

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
