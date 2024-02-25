<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function TaskActivities(Request $request)
    {
        $searchQuery = $request->query('q');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'type_of_activity');
        $orderBy = $request->query('orderBy', 'asc');

        $data = [
            [
                'type_of_activity' => 'Indoor Activity',
                'activity_name' => 'Online Meeting',
                'no_contacts' => 50,
                'no_of_leads' => 5,
                'no_of_deals' => 57,
            ],
            [
                'type_of_activity' => 'Outdoor Activity',
                'activity_name' => 'Physical Meetings',
                'no_contacts' => 58,
                'no_of_leads' => 5,
                'no_of_deals' => 39,
            ],
            [
                'type_of_activity' => 'Outdoor Activity',
                'activity_name' => 'Social Events',
                'no_contacts' => 58,
                'no_of_leads' => 5,
                'no_of_deals' => 39,
            ],
            [
                'type_of_activity' => 'Outdoor Activity',
                'activity_name' => 'World Bank Conferences',
                'no_contacts' => 58,
                'no_of_leads' => 5,
                'no_of_deals' => 39,
            ],
        ];

        if (!is_null($searchQuery)) {
            $filteredData = array_filter($data, function ($item) use ($searchQuery) {
                return strpos($item['type_of_activity'], $searchQuery) !== false;
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
    public function CustomerFeedback(Request $request)
    {
        $searchQuery = $request->query('q');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'company');
        $orderBy = $request->query('orderBy', 'asc');

        $data = [
            [
                'company' => 'Jamil Ltd',
                'date_converted' => '10 Oct 2023',
                'type' => 'Negative',
                'description' => 'Long Verification Process',
                'lead_source' => 'Email',
            ],
            [
                'company' => 'Delta Juice',
                'date_converted' => '10 Oct 2023',
                'type' => 'Positive',
                'description' => 'Amazing Service',
                'lead_source' => 'Email',
            ],
            [
                'company' => 'Cardburry',
                'date_converted' => '10 Oct 2023',
                'type' => 'Positive',
                'description' => 'Amazing Service',
                'lead_source' => 'Email',
            ],
            [
                'company' => 'Fresh Milk',
                'date_converted' => '10 Oct 2023',
                'type' => 'Positive',
                'description' => 'Amazing Service',
                'lead_source' => 'Email',
            ],
        ];

        if (!is_null($searchQuery)) {
            $filteredData = array_filter($data, function ($item) use ($searchQuery) {
                return strpos($item['company'], $searchQuery) !== false;
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
    public function ConversionRateAnalysis(Request $request)
    {
        $searchQuery = $request->query('q');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'expense_value');
        $orderBy = $request->query('orderBy', 'asc');

        $data = [
            [
                'month' => 'January',
                'leads' => 250,
                'closed_deals' => 210,
                'rate_of_conversion' => '50%',
                'expense_value' => 'Email',
                'bonus' => '50,000 KSH',
            ],
            [
                'month' => 'February',
                'leads' => 250,
                'closed_deals' => 160,
                'rate_of_conversion' => '50%',
                'expense_value' => 'Email',
                'bonus' => '50,000 KSH',
            ],
            [
                'month' => 'March',
                'leads' => 250,
                'closed_deals' => 182,
                'rate_of_conversion' => '50%',
                'expense_value' => 'Email',
                'bonus' => '50,000 KSH',
            ],
            [
                'month' => 'April',
                'leads' => 250,
                'closed_deals' => 233,
                'rate_of_conversion' => '50%',
                'expense_value' => 'Email',
                'bonus' => '50,000 KSH',
            ],
        ];

        if (!is_null($searchQuery)) {
            $filteredData = array_filter($data, function ($item) use ($searchQuery) {
                return strpos($item['expense_value'], $searchQuery) !== false;
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
    public function TargetPerformance(Request $request)
    {
        $searchQuery = $request->query('q');
        $itemsPerPage = $request->query('itemsPerPage', 15);
        $page = $request->query('page', 1);
        $sortBy = $request->query('sortBy', 'type');
        $orderBy = $request->query('orderBy', 'asc');

        $data = [
            [
                'type' => 'Leads Target',
                'target' => 200,
                'start_date' => '23 Nov 2023',
                'deadline' => '23 Nov 2023',
                'status' => 'Construction',
                'success_ratio' => '50%',
            ],
            [
                'type' => 'Meetings Target',
                'target' => 200,
                'start_date' => '23 Nov 2023',
                'deadline' => '23 Nov 2023',
                'status' => 'Construction',
                'success_ratio' => '50%',
            ],
            [
                'type' => 'Deals Target',
                'target' => 200,
                'start_date' => '23 Nov 2023',
                'deadline' => '23 Nov 2023',
                'status' => 'Construction',
                'success_ratio' => '50%',
            ],
            [
                'type' => 'Leads Target',
                'target' => 200,
                'start_date' => '23 Nov 2023',
                'deadline' => '23 Nov 2023',
                'status' => 'Construction',
                'success_ratio' => '50%',
            ],
            [
                'type' => 'Meetings Target',
                'target' => 200,
                'start_date' => '23 Nov 2023',
                'deadline' => '23 Nov 2023',
                'status' => 'Construction',
                'success_ratio' => '50%',
            ],
            [
                'type' => 'Deals Target',
                'target' => 200,
                'start_date' => '23 Nov 2023',
                'deadline' => '23 Nov 2023',
                'status' => 'Construction',
                'success_ratio' => '50%',
            ],
        ];

        if (!is_null($searchQuery)) {
            $filteredData = array_filter($data, function ($item) use ($searchQuery) {
                return strpos($item['type_of_activity'], $searchQuery) !== false;
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
}
