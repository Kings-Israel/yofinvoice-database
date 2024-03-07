<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBankRequest;
use App\Http\Resources\BankResource;
use App\Models\Bank;
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
        info($request->all());
        $name = $request->input('name');
        $url = $request->input('url');
        $email = $request->input('email');
        $created_by = $request->input('createdBy');

        $bank = Bank::create([
            'name' => $name,
            'email' => $email,
            'url' => Str::replace(' ', '', $url),
        ]);
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
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
    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
