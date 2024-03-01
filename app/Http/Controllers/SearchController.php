<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public $db = [
        'searchItems' => [
            [
                'title' => 'Home',
                'category' => 'Home',
                'children' => [
                    [
                        'url' => ['name' => 'home'],
                        'icon' => 'tabler-smart-home',
                        'title' => 'Home',
                    ],
                ],
            ],
            [
                'title' => 'Pipeline',
                'category' => 'pipeline',
                'children' => [
                    [
                        'url' => ['name' => 'pipeline-new'],
                        'icon' => 'tabler-pencil',
                        'title' => 'New',
                    ],
                    [
                        'url' => ['name' => 'pipeline-contacts-tab', 'params' => ['tab' => 'Contacts']],
                        'icon' => 'tabler-eye-code',
                        'title' => 'Contacts',
                    ],
                    [
                        'url' => ['name' => 'pipeline-leads-tab', 'params' => ['tab' => 'Leads']],
                        'icon' => 'tabler-eye-code',
                        'title' => 'Leads',
                    ],
                    [
                        'url' => ['name' => 'pipeline-opportunity-tab', 'params' => ['tab' => 'Opportunity']],
                        'icon' => 'tabler-eye-code',
                        'title' => 'Opportunity',
                    ],
                    [
                        'url' => ['name' => 'pipeline-closed-tab', 'params' => ['tab' => 'Closed']],
                        'icon' => 'tabler-eye-code',
                        'title' => 'Closed',
                    ],
                ],
            ],
            [
                'title' => 'Calendar',
                'category' => 'calendar',
                'children' => [
                    [
                        'url' => ['name' => 'calendar-schedules'],
                        'icon' => 'tabler-calendar',
                        'title' => 'Schedules',
                    ],
                    [
                        'url' => ['name' => 'calendar-followups'],
                        'icon' => 'tabler-calendar',
                        'title' => 'Follow Ups',
                    ],
                ],
            ],
            [
                'title' => 'Source Analysis',
                'category' => 'source-analysis',
                'children' => [
                    [
                        'url' => ['name' => 'source-analysis'],
                        'icon' => 'tabler-truck-loading',
                        'title' => 'Source Analysis',
                    ],
                ],
            ],
            [
                'title' => 'Expense Management',
                'category' => 'expense-management',
                'children' => [
                    [
                        'url' => ['name' => 'expense-management'],
                        'icon' => 'tabler-cash-banknote',
                        'title' => 'Expense Management',
                    ],
                ],
            ],
            [
                'title' => 'Reports',
                'category' => 'reports',
                'children' => [
                    [
                        'url' => ['name' => 'reports'],
                        'icon' => 'tabler-report',
                        'title' => 'Reports',
                    ],
                ],
            ],
        ],
    ];

    public function search(Request $request)
    {
        $query = $request->query('q', '');
        $queryLowered = strtolower($query);

        $filteredSearchData = [];

        foreach ($this->db['searchItems'] as $item) {
            if (isset($item['children'])) {
                $matchingChildren = array_filter($item['children'], function ($child) use ($queryLowered) {
                    return strpos(strtolower($child['title']), $queryLowered) !== false;
                });

                if (count($matchingChildren) > 0) {
                    $parentCopy = $item;

                    if (count($matchingChildren) > 5) {
                        $parentCopy['children'] = array_slice($matchingChildren, 0, 5);
                    } else {
                        $parentCopy['children'] = array_values($matchingChildren);
                    }

                    $filteredSearchData[] = $parentCopy;
                }
            }
        }

        return response()->json($filteredSearchData);
    }
}
