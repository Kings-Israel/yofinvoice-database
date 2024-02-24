<?php

namespace App\Helpers;

use App\Http\Resources\ContactUIPipelineResource;
use App\Models\Pipeline;

class FetchPipelineData
{

    public static function fetchContactDetails($request)
    {
        $searchQuery = $request->query('q');
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

        if (!is_null($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        $query->orderBy($sortBy, $orderBy);

        $contacts = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        $response = [
            'data' => ContactUIPipelineResource::collection($contacts),
            'total' => $contacts->total(),
            'currentPage' => $contacts->currentPage(),
            'lastPage' => $contacts->lastPage(),
        ];
        return response()->json($response);

    }
}
