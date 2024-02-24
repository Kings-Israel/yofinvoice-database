<?php

namespace App\Http\Controllers;

use App\Helpers\FetchPipelineData;
use App\Helpers\StorePipelineData;
use App\Helpers\UpdatePipelineData;
use App\Http\Resources\ColdLeadsUIPipelineResource;
use App\Http\Resources\ContactUIPipelineResource;
use App\Http\Resources\LeadUIPipelineResource;
use App\Http\Resources\OpportunityUIPipelineResource;
use App\Models\Pipeline;
use App\Models\User;
use App\Pipes\CheckEmailExistsPipe;
use Illuminate\Http\Request;

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
     */
    public function store(Request $request)
    {
        $data = $request->all();
        switch ($data['stage']) {
            case 'Contact':
                StorePipelineData::storeContactDetails($data);
                break;

            default:
                return response()->json(['message' => 'Error creating pipeline'], 500);
            // break;
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

}
