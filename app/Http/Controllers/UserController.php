<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserListResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $role = $request->query('role');
        $sortBy = $request->query('sortBy', 'id');
        $searchQuery = $request->query('q');
        $orderBy = $request->query('orderBy', 'desc');
        $query = User::with('roles');

        if (!is_null($searchQuery)) {
            $query->search('%' . $searchQuery . '%');
        }

        if (!is_null($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }
        if (!is_null($role)) {
            $query->where('role_id', $role);
        }

        $query->orderBy($sortBy, $orderBy);
        $rolesWithCounts = DB::table('users')
            ->select('role_id', DB::raw('count(*) as count'))
            ->groupBy('role_id')
            ->get();

        $users = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        return response()->json([
            'users' => UserListResource::collection($users),
            'total' => $users->total(),
            'rolesWithCounts' => $rolesWithCounts,
            'currentPage' => $users->currentPage(),
            'lastPage' => $users->lastPage(),
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
    public function store(Request $request): JsonResponse
    {
        $roleId = Role::where('name', $request->input('role'))->value('id');
        $user = User::create([
            'name' => $request->input('fullName'),
            'role' => $roleId,
            'contact' => $request->input('contact'),
            'password' => Hash::make('password'),
            'email' => $request->input('email'),
            'status' => $request->input('status'),
        ]);
        return response()->json([
            'message' => 'User added Successfully',
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
