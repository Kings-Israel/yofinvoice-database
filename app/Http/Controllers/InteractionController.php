<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInteractionRequest;
use App\Http\Resources\InteractionUIResource;
use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(InteractionUIResource::collection(Interaction::all()));
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
        $interaction = Interaction::create([
            'pipeline_id' => $data['id'],
            'name' => $data['name'],
            'stage' => $data['stage'],
            'remarks' => $data['remarks'],
            'veryNextStep' => $data['veryNextStep'],
        ]);
        if ($interaction) {
            return response()->json(['message' => 'Interaction added successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating an interaction'], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Interaction $interaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interaction $interaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInteractionRequest $request, Interaction $interaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        //
    }
}
