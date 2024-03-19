<?php

namespace App\Http\Controllers;

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
    public function userRoles(Request $request)
    {
        $module = $request->query('module');
        $roleType = $request->query('roleType');
        if ($module === 'CRM' || $module === 'Bank') {
            return response(PermissionData::where('RoleTypeName', $module)->pluck('RoleName'));
        } else if ($module === 'Company') {
            return response(PermissionData::where('RoleTypeName', $roleType)->pluck('RoleName'));

        } else {
            return response([]);
        }
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
}
