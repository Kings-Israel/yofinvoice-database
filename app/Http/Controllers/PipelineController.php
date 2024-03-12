<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Helpers\FetchPipelineData;
use App\Helpers\UpdatePipelineData;
use App\Http\Resources\ActiveProjectsDashboardResource;
use App\Http\Resources\AssociationContactResource;
use App\Http\Resources\ClosedDealsReportResource;
use App\Http\Resources\ColdLeadsUIPipelineResource;
use App\Http\Resources\ContactUIPipelineResource;
use App\Http\Resources\LeadsReportResource;
use App\Http\Resources\LeadUIPipelineResource;
use App\Http\Resources\OpportunityUIPipelineResource;
use App\Http\Resources\RecentDashboardProspect;
use App\Models\Activity;
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
        $pipeline_id = $request->input('pipeline_id');
        $exists = true;
        if ($pipeline_id) {
            $exists = Pipeline::whereNot('id', $pipeline_id)->where('email', $email)->exists();
        } else {

            $exists = Pipeline::where('email', $email)->exists();
        }

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
    public function getAssociationContacts()
    {
        return response()->json(AssociationContactResource::collection(Pipeline::whereNull('pipeline_id')->where('stage', 'Contact')->whereNot('lead_type', 'corporate')->get()));
    }
    public function getAssociatedContacts(Request $request)
    {
        $data = $request->all();
        return response()->json(AssociationContactResource::collection(Pipeline::where('pipeline_id', $data['pipeline_id'])->get()));
    }
    public function postAssociationContacts(Request $request)
    {
        $data = $request->all();
        Pipeline::whereId($data['contact_id'])->update([
            'pipeline_id' => $data['pipeline_id'],
        ]);
        return response()->json(['message' => "contact associated successfully"]);
    }
    public function contactDetails(Request $request)
    {

        $searchQuery = $request->query('q');
        $stage = $request->query('stage');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $leadType = $request->query('leadType', 'individual');
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');
        $query = Pipeline::where('stage', 'Contact')
            ->with('Contacts')
            ->where('lead_type', $leadType);
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

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $query = Pipeline::where('stage', 'Closed');

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
        $leadType = strtolower($data['lead_type']);
        $pipeline = Pipeline::create([
            'stage' => 'Contact',
            'name' => $data['name'],
            'whatsapp_number' => $data['whatsapp_number'],
            'company' => $data['company'] ?? $data['name'],
            'department' => $data['department'] ?? "No department",
            'phone_number' => $data['phone_number'],
            'product' => strtolower($data['product']),
            'email' => $data['email'],
            'lead_type' => $leadType,
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
            'branch' => $data['branch'] ?? "No Branch",
            'associated_user' => $data['associated_user'],
            'interaction_type' => $data['interaction_type'],
            'source' => $data['source'],
            'very_next_step' => $data['very_next_step'] ?? 'Call',
            'note' => $data['note'],
        ]);
        if ($leadType === "corporate") {
            $pipeline = Pipeline::create([
                'stage' => 'Contact',
                'name' => $data['firstName'] . " " . $data['lastName'],
                'whatsapp_number' => $data['contact_phone_number'],
                'company' => $data['company'] ?? $data['name'],
                'department' => $data['department'] ?? "No department",
                'phone_number' => $data['contact_phone_number'],
                'product' => strtolower($data['product']),
                'email' => $data['contactEmail'],
                'lead_type' => 'individual',
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
                'branch' => $data['branch'] ?? "No Branch",
                'associated_user' => $data['associated_user'],
                'interaction_type' => $data['interaction_type'],
                'source' => $data['source'],
                'very_next_step' => $data['very_next_step'] ?? 'Call',
                'note' => $data['note'],
                'pipeline_id' => $pipeline->id,
            ]);
        }
        if ($pipeline) {
            ActivityHelper::logActivity([
                'subject_type' => "Storing an Pipeline",
                "stage" => "Pipeline",
                "section" => $pipeline->stage,
                "pipeline_id" => $pipeline->id,
                'user_id' => $pipeline->id,
                'description' => "Storing an pipeline",
                'properties' => $pipeline,
            ]);

            // Log a success message or return a response
            return response()->json(['message' => 'Contact created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating contact'], 500);
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        switch ($data['stage']) {
            case 'Lead':
                UpdatePipelineData::updateLeadsDetails($request, $id);
                break;

            case 'Opportunity':
                UpdatePipelineData::updateOpportunitysDetails($data, $id);
                break;

            default:
                return response()->json(['message' => 'Error creating pipeline'], 500);

                // break;
        }
    }
    public function updateLead(Request $request, $id)
    {
        $lead = Pipeline::findOrFail($id); // Ensure the lead exists

        $lead->update($request->all());
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Lead',
            ]);
        if ($pipeline) {
            $pipelinData = Pipeline::whereId($id)->first();
            ActivityHelper::logActivity([
                'subject_type' => "Converting to a Lead",
                "stage" => $pipelinData->stage,
                "section" => $pipelinData->stage,
                "pipeline_id" => $id,
                'user_id' => $id,
                'description' => "Converted the following to a lead",
                'properties' => $pipelinData,
            ]);

            return response()->json(['message' => 'Opportunity created successfully'], 200);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
    public function updateOpportunity(Request $request, $id)
    {
        $lead = Pipeline::findOrFail($id); // Ensure the lead exists

        $lead->update($request->all());
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Opportunity',
            ]);
        if ($pipeline) {
            $pipelinData = Pipeline::whereId($id)->first();
            ActivityHelper::logActivity([
                'subject_type' => "Converting to a Lead",
                "stage" => $pipelinData->stage,
                "section" => $pipelinData->stage,
                "pipeline_id" => $id,
                'user_id' => $id,
                'description' => "Converted the following to a lead",
                'properties' => $pipelinData,
            ]);

            return response()->json(['message' => 'Opportunity created successfully'], 200);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
    public function updatePipeline(Request $request, $id)
    {
        $data = $request->all();
        $pipeline = Pipeline::whereId($id)
            ->update([
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
            $value = Pipeline::whereId($id)->first();
            ActivityHelper::logActivity([
                'subject_type' => "Updating a Pipeline",
                "stage" => "Pipeline",
                "section" => $value->stage,
                "pipeline_id" => $value->id,
                'user_id' => $value->id,
                'description' => "Updating a pipeline",
                'properties' => $value,
            ]);

            // Log a success message or return a response
            return response()->json(['message' => 'Edit was successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'An error occurred'], 500);
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
    public function getPipelineCount()
    {
        return response()->json(Pipeline::select(
            'stage',
            DB::raw('count(*) as count'),
        )->groupBy('stage')
                ->get());
    }

    public function getLeadsReport(Request $request)
    {
        $searchQuery = $request->query('q', '');
        $query = Pipeline::with(['Schedules', 'CreationDate']);

        if (!is_null($searchQuery)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->search('%' . $searchQuery . '%');
        }

        return response()->json(LeadsReportResource::collection($query->where('stage', 'Lead')->get()));
    }
    public function productReport(Request $request)
    {

        $searchQuery = $request->query('q');
        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');
        $query = Pipeline::query();
        if (!is_null($searchQuery)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->search('%' . $searchQuery . '%');
        }

        if (!is_null($selectedStatus)) {
            $query->where('product', $selectedStatus);
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

    public function getClosedDealsReports()
    {
        return response()->json(ClosedDealsReportResource::collection(Pipeline::with('ClosedActivity')->where('stage', 'Closed')->get()));
    }

    public function getWidgetReportData()
    {
        $stageCounts = Pipeline::selectRaw("
        SUM(product = 'dealer financing') as dealer_financing,
        SUM(product = 'vendor financing') as vendor_financing
    ")->first();

        $widgetData = collect([
            ['value' => 'Dealer Financing', 'title' => $stageCounts->dealer_financing ?? 0],
            ['value' => 'Vendor Financing', 'title' => $stageCounts->vendor_financing ?? 0],
            ['value' => 'Closed Deals', 'title' => Pipeline::where('stage', 'Closed')->count() ?? 0],
        ]);

        $iconMap = [
            'Dealer Financing' => 'tabler-leaf',
            'Vendor Financing' => 'tabler-pencil-bolt',
            'Closed Deals' => 'tabler-clock-hour-12',
        ];

        $colorsMap = [
            'Dealer Financing' => 'primary',
            'Vendor Financing' => 'info',
            'Closed Deals' => 'warning',
        ];

        $widgetData = $widgetData->map(function ($item) use ($iconMap, $colorsMap) {
            $item['icon'] = $iconMap[$item['value']];
            $item['color'] = $colorsMap[$item['value']];
            return $item;
        });

        return response()->json($widgetData);
    }

    public function getCountPipelineWithinAPeriod(Request $request)
    {
        $dateRange = $request->input('date', '');
        $startDateCarbon = null;
        $endDateCarbon = null;

        if (!empty($dateRange)) {
            if (strpos($dateRange, ' to ') !== false) {
                [$startDate, $endDate] = explode(" to ", $dateRange);
                $startDateCarbon = Carbon::parse($startDate);
                $endDateCarbon = Carbon::parse($endDate)->endOfDay(); // Ensure full day coverage
                info("Start Date: " . $startDateCarbon);
                info("End Date: " . $endDateCarbon);
            } else {
                $startDateCarbon = Carbon::parse($dateRange);
                $endDateCarbon = Carbon::now()->endOfMonth(); // Assuming you want to end at the current month's end if only start date is given
                info("Start Date: " . $startDateCarbon);
                info("End Date: " . $endDateCarbon);
            }
        }

        // Adjust your query to filter by the date range if both dates are defined
        $query = Activity::query();

        if ($startDateCarbon && $endDateCarbon) {
            $query->whereBetween('created_at', [$startDateCarbon, $endDateCarbon]);
        }

        $stageCounts = $query->selectRaw("
        SUM(section = 'Contact') as contact_count,
        SUM(section = 'Lead') as lead_count,
        SUM(section = 'Opportunity') as opportunity_count,
        SUM(section = 'Closed') as closed_count")->first();

        $widgetData = collect([
            ['title' => 'Contacts', 'value' => $stageCounts->contact_count ?? 0],
            ['title' => 'Leads', 'value' => $stageCounts->lead_count ?? 0],
            ['title' => 'Opportunities', 'value' => $stageCounts->opportunity_count ?? 0],
            ['title' => 'Closed', 'value' => $stageCounts->closed_count ?? 0], // Corrected 'cold_count' to 'closed_count'
        ]);

        $colorsMap = [
            'Contacts' => 'secondary',
            'Leads' => 'info',
            'Opportunities' => 'primary',
            'Closed' => 'success',
        ];

        $widgetData = $widgetData->map(function ($item) use ($colorsMap) {
            $item['color'] = $colorsMap[$item['title']];
            return $item;
        });

        return response()->json($widgetData);
    }
    public function getProductCounts()
    {
        $productsCount = Pipeline::selectRaw("
        SUM(product = 'vendor financing') as vendor,
        SUM(product = 'dealer financing') as dealer,
        COUNT(*) as count
    ")->first();
        $widgetData = collect([
            ['title' => 'Vendor Financing', 'value' => $productsCount->vendor ?? 0],
            ['title' => 'Dealer Financing', 'value' => $productsCount->dealer ?? 0],
            ['title' => 'Total', 'value' => $productsCount->count ?? 0],
        ]);

        $colorsMap = [
            'Vendor Financing' => 'secondary',
            'Dealer Financing' => 'info',
            'Total' => 'primary',
        ];
        $iconMap = [
            'Vendor Financing' => 'tabler-phone-call',
            'Dealer Financing' => 'tabler-direction-sign',
            'Total' => 'tabler-chart-candle-filled',
        ];

        $widgetData = $widgetData->map(function ($item) use ($iconMap, $colorsMap) {
            $item['color'] = $colorsMap[$item['title']];
            $item['icon'] = $iconMap[$item['title']];
            return $item;
        });

        return response()->json($widgetData);
    }

    public function addNewContact(Request $request)
    {
        $data = $request->all();

        $associatedPipeline = Pipeline::whereId($data['pipeline_id'])->first();
        if ($associatedPipeline) {
            $pipeline = Pipeline::create([
                'stage' => 'Contact',
                'name' => $data['firstName'] . " " . $data['lastName'],
                'whatsapp_number' => $data['phone_number'],
                'company' => $associatedPipeline->name,
                'department' => $associatedPipeline->department,
                'phone_number' => $data['phone_number'],
                'product' => $associatedPipeline->product,
                'email' => $data['email'],
                'lead_type' => 'individual',
                'point_of_contact' => $associatedPipeline->point_of_contact,
                'tatDays' => 0,
                'gender' => $data['gender'],
                'status' => 'hot',
                'owner' => $associatedPipeline->owner,
                'campaign' => $associatedPipeline->campaign,
                'region' => $associatedPipeline->region,
                'industry' => $associatedPipeline->industry,
                'location' => $associatedPipeline->location,
                'priority' => $associatedPipeline->priority,
                'branch' => $associatedPipeline->branch,
                'associated_user' => $associatedPipeline->associated_user,
                'interaction_type' => $associatedPipeline->interaction_type,
                'source' => $associatedPipeline->source,
                'very_next_step' => $associatedPipeline->very_next_step,
                'note' => $associatedPipeline->note,
                'pipeline_id' => $associatedPipeline->id,
            ]);
            if ($pipeline) {
                ActivityHelper::logActivity([
                    'subject_type' => "Storing an Pipeline",
                    "stage" => "Pipeline",
                    "section" => $pipeline->stage,
                    "pipeline_id" => $pipeline->id,
                    'user_id' => $pipeline->id,
                    'description' => "Storing an pipeline",
                    'properties' => $pipeline,
                ]);

                // Log a success message or return a response
                return response()->json(['message' => 'Contact created successfully'], 201);
            }
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating contact'], 500);
        }

    }
}
