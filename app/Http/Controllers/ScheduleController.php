<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Http\Resources\RecentActivityTimelineDashboardResource;
use App\Http\Resources\Schedule\AllFollowUpsResource;
use App\Http\Resources\Schedule\GuestListUIResource;
use App\Models\Pipeline;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->query('q', '');
        $searchStatus = $request->query('status', '');
        $calendar = $request->query('calendar', '');
        $query = Schedule::query();

        if (!is_null($searchQuery)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->search('%' . $searchQuery . '%');
        }
        if (!is_null($searchStatus)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->where('status', 'LIKE', '%' . $searchStatus . '%');
        }
        if (!is_null($calendar)) {
            // Assuming 'searchQuery' applies to a specific field or set of fields
            $query->where('calendar', 'LIKE', '%' . $calendar . '%');
        }
        return response()->json([
            'data' => AllFollowUpsResource::collection($query->get()),
        ]);
    }

    public function getGuestList()
    {
        return response()->json([
            'data' => GuestListUIResource::collection(Pipeline::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $props = $request->input('extendedProps');
        $title = $request->input('title');
        $pipeline = [];
        $pipeline = Pipeline::whereName($title)->first();
        $event = Schedule::create([
            'title' => "Meeting with " . $pipeline->name,
            'pipeline_id' => $pipeline->id,
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'allDay' => $request->input('allDay'),
            'url' => $request->input('url'),
            'calendar' => $props['calendar'],
            'extendedProps' => $props,
        ]);
        if ($event) {
            ActivityHelper::logActivity([
                'subject_type' => "Creating an event",
                "stage" => "Schedule",
                "section" => "Event",
                "pipeline_id" => $event->id,
                'user_id' => $event->id,
                'description' => "Creating a new event",
                'properties' => $event,
            ]);

            return response()->json($event, 201);
        }
        return response()->json([
            "message" => "An error occurred",
        ], 500);

    }
    public function getRecentActivityDashboard()
    {
        return response()->json([
            'data' => RecentActivityTimelineDashboardResource::collection(Schedule::orderBy('id', 'desc')->limit(1)->get()),
        ]);
    }
    public function getSixMonthSchedule()
    {
        $monthlyCounts = [];
        $stages = ['Physical Meetings', 'Online Meetings'];

        // Adjust the loop to iterate over the last 6 months only
        for ($i = 0; $i <= 5; $i++) {
            $month = Carbon::now()->subMonths($i);
            foreach ($stages as $stage) {
                $count = Schedule::where('calendar', $stage)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                $key = strtolower(str_replace(' ', '_', $stage));
                $monthlyCounts[$key][] = $count + 20 ?? 0 + 2;
            }
        }
        return response()->json($monthlyCounts);
    }
    public function getScheduleCount()
    {
        return response()->json([
            'count' => Schedule::count(),
        ]);
    }

    public function getWeeklyCollectionMeeting()
    {
        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $hoursPerWeekday = Schedule::query()
            ->select([
                DB::raw('DAYNAME(start) as weekday'),
                DB::raw('LEAST(SUM(TIMESTAMPDIFF(HOUR, start, end)), 7) as total_hours'),
            ])
            ->whereRaw('DAYOFWEEK(start) BETWEEN 2 AND 6')
            ->groupBy(DB::raw('DAYNAME(start)'))
            ->get()
            ->pluck('total_hours', 'weekday');
        $weekdaysWithHours = collect($weekdays)->mapWithKeys(function ($weekday) use ($hoursPerWeekday) {
            return [$weekday => (int) $hoursPerWeekday->get($weekday, 0)];
        });

        return response()->json($weekdaysWithHours);

    }
}
