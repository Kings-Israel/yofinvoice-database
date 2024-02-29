<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Http\Resources\ExpenseManagementResource;
use App\Models\ExpenseManagement;
use Illuminate\Http\Request;

class ExpenseManagementController extends Controller
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
        $orderBy = $request->query('orderBy', 'desc');

        $query = ExpenseManagement::query();

        if (!is_null($searchQuery)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->search('%' . $searchQuery . '%');
        }

        if (!is_null($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $query->orderBy($sortBy, $orderBy);

        $invoices = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        $response = [
            'data' => ExpenseManagementResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
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
        $fileName = '';
        if ($request->hasFile('file')) {
            // Retrieve the file from the request
            $file = $request->file('file');

            // Define the file's storage path and name
            $destinationPath = 'uploads'; // You should define the correct path according to your requirements
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Move the file to the destination path
            $file->move($destinationPath, $fileName);
        }
        $result = ExpenseManagement::create([
            'lead_name' => $request->input('leadName'),
            'document' => $fileName, // Use the processed file name
            'activity' => $request->input('activity'),
            'request_date' => $request->input('requestDate') ?? now(),
            'amount' => $request->input('amount'),
            'notes' => $request->input('notes'),
            'status' => 'pending',
        ]);

        ActivityHelper::logActivity([
            'subject_type' => "Expense Management",
            "stage" => "Expense Management",
            "section" => "Expense Management",
            "pipeline_id" => $result->id,
            'user_id' => $request->input("user_id"),
            'description' => "Request for lead name" . $result->lead_name,
            'properties' => $result,
        ]);

        if ($result) {
            // Log a success message or return a response
            return response()->json(['message' => 'Expense management entry created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating expense management entry'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseManagement $expenseManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseManagement $expenseManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();
        ExpenseManagement::whereIn('id', $data)->update(['status' => 'approved']);
        return response()->json(['message' => 'Expense management updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseManagement $expenseManagement)
    {
        //
    }
}
