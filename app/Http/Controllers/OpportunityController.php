<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClosedDealResource;
use App\Http\Resources\ColdDealResource;
use App\Http\Resources\OpportunityListResource;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->query('q');
        $stage = $request->query('stage');

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Opportunity::query();

        if (!is_null($searchQuery)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->search('%' . $searchQuery . '%');
        }
        if (!is_null($stage)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->where('stage', 'like', '%' . $stage . '%');
        }

        if (!is_null($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $query->orderBy($sortBy, $orderBy);
        $invoices = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        $response = [
            'data' => OpportunityListResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function closedDeals(Request $request)
    {
        $searchQuery = $request->query('q');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Opportunity::query();

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
            'data' => ClosedDealResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function coldDeals(Request $request)
    {
        $searchQuery = $request->query('q');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Opportunity::where('Stage', 'Cold');

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
            'data' => ColdDealResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function sourcingChannels(Request $request)
    {
        $searchQuery = $request->query('q');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'source'); // You can change the default sorting field
        $orderBy = $request->query('orderBy', 'asc');

        $data = [
            [
                'source' => 'Email',
                'number_of_leads' => 23,
                'number_of_prospects' => 23,
                'opportunities' => 8,
                'cold_opportunities' => 8,
                'designation' => 'Anchor',
            ],
            [
                'source' => 'Golf Event',
                'number_of_leads' => 12,
                'number_of_prospects' => 23,
                'opportunities' => 2,
                'cold_opportunities' => 8,
                'designation' => 'Seller',
            ],
            [
                'source' => 'Email',
                'number_of_leads' => 8,
                'number_of_prospects' => 23,
                'opportunities' => 3,
                'cold_opportunities' => 8,
                'designation' => 'Anchor',
            ],
            [
                'source' => 'Event',
                'number_of_leads' => 11,
                'number_of_prospects' => 23,
                'opportunities' => 12,
                'cold_opportunities' => 8,
                'designation' => 'Anchor',
            ],
            [
                'source' => 'Event',
                'number_of_leads' => 60,
                'number_of_prospects' => 23,
                'opportunities' => 3,
                'cold_opportunities' => 8,
                'designation' => 'Vendor',
            ],
            [
                'source' => 'Email',
                'number_of_leads' => 10,
                'number_of_prospects' => 23,
                'opportunities' => 33,
                'cold_opportunities' => 8,
                'designation' => 'Seller',
            ],
            [
                'source' => 'Email',
                'number_of_leads' => 108,
                'number_of_prospects' => 23,
                'opportunities' => 71,
                'cold_opportunities' => 8,
                'designation' => 'Anchor',
            ],
        ];

        // Apply search filter
        if (!is_null($searchQuery)) {
            $filteredData = array_filter($data, function ($item) use ($searchQuery) {
                return strpos($item['source'], $searchQuery) !== false;
            });
        } else {
            $filteredData = $data;
        }

        // Sort the data
        if ($orderBy === 'asc') {
            usort($filteredData, function ($a, $b) use ($sortBy) {
                return strcmp($a[$sortBy], $b[$sortBy]);
            });
        } else {
            usort($filteredData, function ($a, $b) use ($sortBy) {
                return strcmp($b[$sortBy], $a[$sortBy]);
            });
        }

        // Paginate the data
        $total = count($filteredData);
        $start = ($page - 1) * $itemsPerPage;
        $slicedData = array_slice($filteredData, $start, $itemsPerPage);

        $response = [
            'data' => $slicedData,
            'total' => $total,
            'currentPage' => $page,
            'lastPage' => ceil($total / $itemsPerPage),
        ];

        return response()->json($response);
    }
    public function internalReferrals(Request $request)
    {
        $searchQuery = $request->query('q');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'referral_name');
        $orderBy = $request->query('orderBy', 'asc');

        $data = [
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Human Resource',
                'total_referred' => 50,
                'total_opportunities' => 18,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Marketing',
                'total_referred' => 50,
                'total_opportunities' => 9,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Finance',
                'total_referred' => 50,
                'total_opportunities' => 50,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Human Resource',
                'total_referred' => 50,
                'total_opportunities' => 50,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Finance',
                'total_referred' => 50,
                'total_opportunities' => 50,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Marketing',
                'total_referred' => 50,
                'total_opportunities' => 23,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Sales',
                'total_referred' => 50,
                'total_opportunities' => 32,
            ],
            [
                'referral_name' => 'Dennis Alier',
                'department' => 'Marketing',
                'total_referred' => 50,
                'total_opportunities' => 52,
            ],
        ];

        // Apply search filter
        if (!is_null($searchQuery)) {
            $filteredData = array_filter($data, function ($item) use ($searchQuery) {
                return strpos($item['referral_name'], $searchQuery) !== false;
            });
        } else {
            $filteredData = $data;
        }

        // Sort the data
        if ($orderBy === 'asc') {
            usort($filteredData, function ($a, $b) use ($sortBy) {
                return strcmp($a[$sortBy], $b[$sortBy]);
            });
        } else {
            usort($filteredData, function ($a, $b) use ($sortBy) {
                return strcmp($b[$sortBy], $a[$sortBy]);
            });
        }

        // Paginate the data
        $total = count($filteredData);
        $start = ($page - 1) * $itemsPerPage;
        $slicedData = array_slice($filteredData, $start, $itemsPerPage);

        $response = [
            'data' => $slicedData,
            'total' => $total,
            'currentPage' => $page,
            'lastPage' => ceil($total / $itemsPerPage),
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
        $data = $request->input('data');
        $name = $data['salutation'] . '' . $data['firstName'] . ' ' . $data['lastName'];
        // Use the create method to create and save an Opportunity
        $opportunity = Opportunity::create([
            'stage' => $data['stage'] ?? 'Lead',
            'product' => $data['product'],
            'leadType' => $data['leadType'],
            'gender' => $data['gender'],
            'martial_status' => $data['martialStatus'],
            'lead_status' => $data['leadStatus'],
            'source' => $data['source'],
            'associated_user' => $data['associatedUser'],
            'interaction_type' => $data['interactionType'] ?? '',
            'action' => $data['action'],
            'owner' => $data['owner'],
            'compaign' => $data['campaign'] ?? '',
            'company' => $data['company'] ?? $name,
            'contact_name' => $name,
            'email' => $data['email'],
            'phone_number' => $data['phoneNumber'],
            'whatsapp_phone_number' => $data['WhatsAppNumber'],
            'region' => $data['location'] ?? 'ICT',
            'status' => $data['status'] ?? 'Pending',
            'residentialAddress' => $data['residentialAddress'],
        ]);

        // Optionally, you can validate the data manually
        // and handle validation errors here if required.

        if ($opportunity) {
            // Log a success message or return a response
            return response()->json(['message' => 'Opportunity created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Opportunity $opportunity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opportunity $opportunity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $opportunity = Opportunity::whereId($id)->first();
        $result = $opportunity->update(
            ['stage' => $request->input('stage')]
        );
        if ($result) {
            // Log a success message or return a response
            return response()->json(['message' => 'Opportunity successfully updated'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error updating opportunity'], 500);
        }

    }
    public function updateCold(Request $request, $id)
    {
        $opportunity = Opportunity::whereId($id)->first();
        $result = $opportunity->update(
            ['lead_status' => $request->input('lead_status')]
        );
        if ($result) {
            return response()->json(['message' => 'Opportunity successfully updated'], 201);
        } else {
            return response()->json(['message' => 'Error updating opportunity'], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opportunity $opportunity)
    {
        //
    }
}
