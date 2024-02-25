<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SourceAnalysisController extends Controller
{
    public function sourceAnalysisChannel(Request $request)
    {
        $searchQuery = $request->query('q');
// $stage = $request->query('stage');

        $selectedStatus = $request->query('status');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'id');
        $orderBy = $request->query('orderBy', 'desc');

        $queryResult = DB::table('pipelines')
            ->select([
                'source',
                DB::raw('count(case when stage = "Contact" then 1 end) as contact_count'),
                DB::raw('count(case when stage = "Lead" then 1 end) as lead_count'),
                DB::raw('count(case when stage = "Opportunity" then 1 end) as opportunity_count'),
                DB::raw('count(case when stage = "Cold" then 1 end) as cold_count'),
                DB::raw('count(case when stage = "Reject" then 1 end) as reject_count'),
            ])
            ->groupBy('source')
            ->paginate($itemsPerPage);

        $response = [
            'data' => $queryResult->items(), // If you have a Resource for formatting, use it here
            'total' => $queryResult->total(),
            'currentPage' => $queryResult->currentPage(),
            'lastPage' => $queryResult->lastPage(),
            'perPage' => $queryResult->perPage(),
            'from' => $queryResult->firstItem(),
            'to' => $queryResult->lastItem(),
        ];

        return response()->json($response);
    }

}
