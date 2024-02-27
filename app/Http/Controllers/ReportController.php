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
