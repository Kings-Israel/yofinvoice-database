<?php

namespace App\Helpers;

use App\Models\Pipeline;

class StorePipelineData
{

    public static function storeContactDetails($data)
    {
        $pipeline = Pipeline::create([
            'stage' => $data['stage'],
            'name' => $data['name'],
            'company' => $data['company'],
            'department' => $data['department'],
            'phone_number' => $data['phoneNumber'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'status' => strtolower($data['status']),
            'owner' => $data['owner'],
            'campaign' => $data['campaign'],
            'source' => $data['source'],
            'very_next_step' => $data['veryNextStep'],
        ]);
        if ($pipeline) {
            // Log a success message or return a response
            return response()->json(['message' => 'Opportunity created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
}
