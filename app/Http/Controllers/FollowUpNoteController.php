<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFollowUpNoteRequest;
use App\Http\Resources\FollowUpUIResource;
use App\Models\FollowUpNote;
use App\Models\Schedule;
use Illuminate\Http\Request;

class FollowUpNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(FollowUpUIResource::collection(FollowUpNote::all()));
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

        $data = $request->all();
        info($data['checked'] == 'done');
        $followups = FollowUpNote::create([
            'pipeline_id' => $data['id'],
            'status' => $data['checked'] === 'done' ? '1' : '0',
            'date' => $data['date'],
            'remarks' => $data['remarks'],
            'veryNextStep' => $data['veryNextStep'],
        ]);
        $result = Schedule::where('id', $data['id'])->update([
            'status' => $data['checked'] === 'done' ? '1' : '0',
        ]
        );
        info($result);
        if ($followups) {
            return response()->json(['message' => 'Follow Up added successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating an interaction'], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUpNote $followUpNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUpNote $followUpNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFollowUpNoteRequest $request, FollowUpNote $followUpNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUpNote $followUpNote)
    {
        //
    }
}
