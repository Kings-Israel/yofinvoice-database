<?php

namespace App\Http\Controllers;

use App\Helpers\FetchPipelineData;
use App\Helpers\UpdatePipelineData;
use App\Http\Resources\ActiveProjectsDashboardResource;
use App\Http\Resources\ColdLeadsUIPipelineResource;
use App\Http\Resources\ContactUIPipelineResource;
use App\Http\Resources\LeadUIPipelineResource;
use App\Http\Resources\OpportunityUIPipelineResource;
use App\Http\Resources\RecentDashboardProspect;
use App\Models\Pipeline;
use App\Models\User;
use App\Pipes\CheckEmailExistsPipe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PipelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        switch ($request->query('stage')) {
            case 'Contact':
                FetchPipelineData::fetchContactDetails($request);
                break;

            default:
                return response()->json(['message' => 'Error fetch pipeline'], 500);
                // break;
        }
    }
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = Pipeline::where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    }
    public function check(Request $request)
    {
        $email = $request->input('email');

        $exists = app(Pipeline::class)
            ->send(User::query())
            ->through([
                new CheckEmailExistsPipe($email),
            ])
            ->then(function ($query) {
                return $query->exists();
            });

        return response()->json(['exists' => $exists]);
    }
    public function getIDPipeline($id)
    {
        $data = Pipeline::whereId($id)->first();
        return response()->json([$data]);

    }
    public function contactDetails(Request $request)
    {

        $searchQuery = $request->query('q');
        $stage = $request->query('stage');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');
        $query = Pipeline::where('stage', 'Contact');
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
            'data' => ContactUIPipelineResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function leadDetails(Request $request)
    {
        $searchQuery = $request->query('q');
        $stage = $request->query('stage');

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Pipeline::where('stage', 'Lead');

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
            'data' => LeadUIPipelineResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function opportunityDetails(Request $request)
    {
        $searchQuery = $request->query('q');
        $stage = $request->query('stage');

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Pipeline::where('stage', 'Opportunity');

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
            'data' => OpportunityUIPipelineResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function closedDetails(Request $request)
    {
        $searchQuery = $request->query('q');
        $stage = $request->query('stage');

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Pipeline::where('stage', 'closed');

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
            'data' => OpportunityUIPipelineResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        return response()->json($response);

    }
    public function coldDetails(Request $request)
    {
        $searchQuery = $request->query('q');
        // $stage = $request->query('stage');

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Pipeline::where('status', 'cold');

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
            'data' => ColdLeadsUIPipelineResource::collection($invoices),
            'total' => $invoices->total(),
            'currentPage' => $invoices->currentPage(),
            'lastPage' => $invoices->lastPage(),
        ];
        info(json_encode($response));
        return response()->json($response);

    }
    /**
     * Store a newly created resource in storage.
     *
     * const baseFormData: FormData = {
    }
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $pipeline = Pipeline::create([
            'stage' => 'Contact',
            'name' => $data['name'],
            'whatsapp_number' => $data['whatsapp_number'],
            'company' => $data['company'] ?? $data['name'],
            'department' => $data['department'],
            'phone_number' => $data['phone_number'],
            'product' => strtolower($data['product']),
            'email' => $data['email'],
            'lead_type' => strtolower($data['lead_type']),
            'point_of_contact' => $data['point_of_contact'] ?? $data['owner'],
            'tatDays' => $data['tatDays'],
            'gender' => $data['gender'],
            'status' => strtolower($data['status']),
            'owner' => $data['owner'],
            'campaign' => $data['campaign'] ?? 'Google',
            'region' => $data['region'],
            'industry' => $data['industry'],
            'location' => $data['location'],
            'priority' => $data['priority'],
            'branch' => $data['branch'],
            'associated_user' => $data['associated_user'],
            'interaction_type' => $data['interaction_type'],
            'source' => $data['source'],
            'very_next_step' => $data['very_next_step'] ?? 'Call',
            'note' => $data['note'],
        ]);
        if ($pipeline) {
            // Log a success message or return a response
            return response()->json(['message' => 'Opportunity created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        info($data);
        switch ($data['stage']) {
            case 'Lead':
                UpdatePipelineData::updateLeadsDetails($data, $id);
                break;

            case 'Opportunity':
                UpdatePipelineData::updateOpportunitysDetails($data, $id);
                break;

            default:
                return response()->json(['message' => 'Error creating pipeline'], 500);

                // break;
        }
    }
    public function updatePipeline(Request $request, $id)
    {
        $data = $request->all();
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Contact',
                'name' => $data['name'],
                'company' => $data['company'] ?? $data['name'],
                'department' => $data['department'],
                'phone_number' => $data['phone_number'],
                'whatsapp_number' => $data['whatsapp_number'] ?? $data['phone_number'],
                'product' => strtolower($data['product']),
                'email' => $data['email'],
                'lead_type' => strtolower($data['lead_type']),
                'point_of_contact' => $data['point_of_contact'],
                'tatDays' => $data['tatDays'],
                'gender' => $data['gender'],
                'status' => strtolower($data['status']),
                'owner' => $data['owner'],
                'campaign' => $data['campaign'] ?? 'Google',
                'region' => $data['region'],
                'industry' => $data['industry'],
                'location' => $data['location'],
                'priority' => $data['priority'],
                'branch' => $data['branch'],
                'associated_user' => $data['associated_user'],
                'interaction_type' => $data['interaction_type'],
                'source' => $data['source'],
                'very_next_step' => $data['very_next_step'],
                'note' => $data['note'],
            ]);
        if ($pipeline) {
            // Log a success message or return a response
            return response()->json(['message' => 'Opportunity created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
    public function getWidgetData()
    {
        $stageCounts = Pipeline::selectRaw("
        SUM(stage = 'Contact') as contact_count,
        SUM(stage = 'Lead') as lead_count,
        SUM(stage = 'Opportunity') as opportunity_count,
        SUM(stage = 'Cold') as cold_count,
        SUM(stage = 'Reject') as reject_count
    ")->first();

        $widgetData = collect([
            ['title' => 'Contacts', 'value' => $stageCounts->contact_count ?? 0],
            ['title' => 'Leads', 'value' => $stageCounts->lead_count ?? 0],
            ['title' => 'Opportunities', 'value' => $stageCounts->opportunity_count ?? 0],
            ['title' => 'Cold Leads', 'value' => $stageCounts->cold_count ?? 0],
            ['title' => 'Rejects', 'value' => $stageCounts->reject_count ?? 0],
        ]);

        $iconMap = [
            'Contacts' => 'tabler-phone-call',
            'Leads' => 'tabler-direction-sign',
            'Opportunities' => 'tabler-chart-candle-filled',
            'Cold Leads' => 'tabler-coffee-off',
            'Rejects' => 'tabler-droplet-cancel',
        ];

        $colorsMap = [
            'Contacts' => 'primary',
            'Leads' => 'info',
            'Opportunities' => 'success',
            'Cold Leads' => 'warning',
            'Rejects' => 'error',
        ];

        $changeValues = [
            'Contacts' => 5.7,
            'Leads' => 12.4,
            'Opportunities' => null,
            'Cold Leads' => -3.5,
            'Rejects' => -3.5,
        ];

        $widgetData = $widgetData->map(function ($item) use ($iconMap, $colorsMap, $changeValues) {
            $item['icon'] = $iconMap[$item['title']];
            $item['color'] = $colorsMap[$item['title']];
            $item['change'] = $changeValues[$item['title']];
            return $item;
        });

        return response()->json($widgetData);
    }

    public function recentDashboardProspect()
    {
        return response()->json([
            'data' => RecentDashboardProspect::collection(Pipeline::orderBy('id', 'DESC')->limit(5)->get()),
        ]);
    }

    public function countPipelineCreatedEachMonth()
    {
        $monthlyPipelineCounts = [];
        for ($i = 0; $i <= 11; $i++) {
            $month = Carbon::now()->subMonths($i);
            $count = Pipeline::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            // $monthlyPipelineCounts[$month->format('Y-m')] = $count;
            array_push($monthlyPipelineCounts, $count);
        }
        $queryResult = DB::table('pipelines')
            ->select([
                'status',
                DB::raw('count(*) as count'),
            ])
            ->groupBy('status')
            ->get();

        return response()->json([
            'series' => $monthlyPipelineCounts,
            'pipelineStatusCount' => $queryResult,
            'total' => Pipeline::count(),
        ]);
    }
    public function activePipeline()
    {
        return response()->json([
            'data' => ActiveProjectsDashboardResource::collection(Pipeline::orderBy('id', 'DESC')->limit(6)->get()),
        ]);
    }
    public function countEachStageYearly()
    {
        // Initialize arrays to hold the monthly counts for each stage
        $monthlyCounts = [
            'contact' => [],
            'lead' => [],
            'opportunity' => [],
            'closed' => [],
        ];

        // Define the stages you want to count
        $stages = ['Contact', 'Lead', 'Opportunity', 'Closed'];

        // Loop through each of the last 12 months once
        for ($i = 0; $i <= 11; $i++) {
            $month = Carbon::now()->subMonths($i);

            // Iterate through each stage and count entries for the current month
            foreach ($stages as $stage) {
                $count = Pipeline::where('stage', $stage)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();

                // Map stage to the correct key in the monthlyCounts array
                $key = strtolower($stage) . 's'; // Convert "Contact" to "contacts", etc.
                $monthlyCounts[$key][] = $count ?? 0;
            }
        }

        // Return the counts as a JSON response
        return response()->json($monthlyCounts);
    }
    public function getTopProduct()
    {
        return response()->json([
            'count' => Pipeline::where('product', 'vendor financing')->count(),
        ]);
    }
    public function getLeadsOpportunityCount()
    {
        return response()->json([
            'data' => Pipeline::select(
                'stage',
                DB::raw('count(*) as count'),
            )->whereIn('stage', ['Lead', 'Opportunity'])
                ->groupBy('stage')
                ->get(),
        ]);
    }

}
