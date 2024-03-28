<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionListResource;
use App\Models\PermissionData;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $data = PermissionData::withCount('roleIDs')->paginate($itemsPerPage, ['*'], 'page', $page);
        $response = [
            'permissions' => PermissionListResource::collection($data),
            'permisionTest' => Role::withCount('Permissions')->get(),
            'totalPermissions' => $data->total(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
        ];
        return response()->json($response);

    }
    public function userRoles(Request $request)
    {
        $module = $request->query('module', '');
        if ($module === 'CRM' || $module === 'Bank') {
            return response(PermissionData::where('RoleTypeName', $module)->pluck('RoleName'));
        } else {
            return response([]);
        }
    }
}
