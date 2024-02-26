<?php

namespace App\Helpers;

use App\Models\Pipeline;

class UpdatePipelineData
{

    public static function updateLeadsDetails($data, $id)
    {
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Lead',
                'point_of_contact' => $data['pointOfContact'],
                'region' => $data['region'],
                'branch' => $data['branch'],
                'status' => $data['status'],
            ]);
        info(json_encode($pipeline));
        if ($pipeline) {
            // Log a success message or return a response
            return response()->json(['message' => 'Opportunity created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
    public static function updateOpportunitysDetails($data, $id)
    {
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Opportunity',
                'product' => $data['product'],
                'tatDays' => $data['tatDays'],
                'priority' => $data['priority'],
                'source' => $data['source'],
                'branch' => $data['branch'],
                'very_next_step' => $data['status'],
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
