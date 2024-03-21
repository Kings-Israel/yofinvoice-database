<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssociationContactResource;
use App\Http\Resources\BankDocumentResource;
use App\Http\Resources\BankResource;
use App\Http\Resources\BankUserUIResource;
use App\Models\Bank;
use App\Models\BankDocument;
use App\Models\BankUser;
use App\Models\PermissionData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->query('q');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'asc');

        $query = Bank::query();

        if (!is_null($searchQuery)) {
            $query->search('%' . $searchQuery . '%');
        }

        if (!is_null($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $query->orderBy($sortBy, $orderBy);

        $banks = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        $response = [
            'data' => BankResource::collection($banks),
            'total' => $banks->total(),
            'currentPage' => $banks->currentPage(),
            'lastPage' => $banks->lastPage(),
        ];
        return response()->json($response);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('bankEmail');
        $created_by = $request->input('createdBy');
        $user = User::create([
            'name' => $request->input('contactPersonName'),
            'email' => $request->input('contactEmail'),
            'phone_number' => $request->input('phoneNumber'),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $bank = Bank::create([
            'name' => $name,
            'email' => $email,
            'url' => "https://yofinvoice.deveint.live/bank/" . strtolower(Str::replace(' ', '', $name)),
            'contact_person_id' => $user->id,
        ]);

        if ($user && $bank) {
            return response()->json(['message' => 'Bank created successfully'], 201);
        } else {
            return response()->json(['message' => 'Error creating a user'], 500);
        }

    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('emailNew');
        $exists = Bank::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function bankDocuments($id)
    {
        return response()->json(BankDocumentResource::collection(BankDocument::with('bank')->where('bank_id', $id)->get()));
    }

    public function associatedBankUser()
    {
        $roleId = PermissionData::where('RoleTypeName', 'Bank')->pluck('id');
        $users = User::whereIn('id', $roleId)->get();

        return response()->json(AssociationContactResource::collection($users));

    }

    public function getBankByID($id)
    {
        $bank = Bank::where('banks.id', $id)
            ->leftJoin('users', 'users.id', '=', 'banks.contact_person_id')
            ->select(
                'banks.id',
                'users.name as contactPerson',
                'banks.email',
                'banks.url',
                'banks.name as bank'
            )->first();
        return response()->json($bank);

    }
    public function getBankUsers(Request $request, $id)
    {
        $searchQuery = $request->query('q');
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');
        $itemsPerPage = $request->query('itemsPerPage', 15);

        $query = Bank::find($id)->users();
        if (!is_null($searchQuery)) {
            $query->search('%' . $searchQuery . '%');
        }
        $bankUsers = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        $response = [
            'data' => BankUserUIResource::collection($bankUsers),
            'total' => $bankUsers->total(),
            'currentPage' => $bankUsers->currentPage(),
            'lastPage' => $bankUsers->lastPage(),
        ];

        return response()->json($response);
    }
    public function addUserToABank(Request $request)
    {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('mobile'),
            'password' => Hash::make('password'),
            'role_id' => $request->input('role'),
            'email_verified_at' => now(),
        ]);
        $bank = BankUser::create([
            'user_id' => $user->id,
            'bank_id' => $request->input('bank_id'),
        ]);
        if ($user && $bank) {
            return response()->json(['message' => 'Bank created successfully'], 201);
        } else {
            return response()->json(['message' => 'Error creating a user'], 500);
        }

    }

    public function getUserToMap($id)
    {
        $userIds = BankUser::where('bank_id', $id)->pluck('user_id');
        $users = User::whereNotIn('id', $userIds)->pluck('name');
        return response()->json($users);
    }
    public function postMapBankUser(Request $request)
    {
        $userId = User::whereName($request->input('name'))->value('id');
        $bank = BankUser::create([
            'user_id' => $userId,
            'bank_id' => $request->input('bank_id'),
        ]);
        if ($bank) {
            return response()->json(['message' => 'Bank created successfully'], 201);
        } else {
            return response()->json(['message' => 'Error creating a user'], 500);
        }
    }
}
