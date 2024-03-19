<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Http\Resources\AssociationContactResource;
use App\Models\PermissionData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'email' => ['The provided credentials are incorrect.'],
                    'password' => ['The provided credentials are incorrect.'],
                ],
            ], 422);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        $abilityRules = $user->abilityRules ?? [
            [
                'action' => 'manage',
                'subject' => 'all',
            ],
        ];
        $user->makeHidden(['password', 'remember_token']);
        $userDetails = $user->toArray();
        $userDetails['abilityRules'] = $abilityRules;
        $userDetails['role'] = 'admin';
        $userDetails['avatar'] = asset('images/avatars/yofinvoice.png');
        $userDetails['username'] = str_replace(' ', '', $user->name);

        ActivityHelper::logActivity([
            'subject_type' => "UserAction",
            "stage" => "Login",
            "section" => "Login",
            "pipeline_id" => $user->id,
            'user_id' => $user->id,
            'description' => $user->name . " logged in at " . now(),
            'properties' => $abilityRules,
        ]);

        return response()->json([
            'accessToken' => $token,
            'userData' => $userDetails,
            'userAbilityRules' => $abilityRules,
        ], 200);
    }

    public function addUser(Request $request)
    {
        $data = $request->all();
        $password = $data['password'] ?? 'password';
        $role = PermissionData::where('RoleTypeName', $data['role'])->first();
        $user = User::create([
            'name' => $data['firstName'] . $data['lastName'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'phone_number' => $data['contactNumber'],
            'role_id' => $role->id ?? 0,
        ]);
        if ($user) {
            // Log a success message or return a response
            return response()->json(['message' => 'User created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating a user'], 500);
        }

    }
    public function getAssociatedUser()
    {
        $roleId = PermissionData::where('RoleTypeName', 'Bank')->pluck('id');
        $users = User::whereIn('id', $roleId)->get();

        return response()->json(AssociationContactResource::collection($users));

    }

}
