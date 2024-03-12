<?php

namespace App\Helpers;

use App\Models\Pipeline;

class UpdatePipelineData
{

    public static function updateLeadsDetails($data, $id)
    {
        $lead = Pipeline::findOrFail($id); // Ensure the lead exists

        $lead->update($data);
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Lead',
            ]);
        if ($pipeline) {
            $pipelinData = Pipeline::whereId($id)->first();
            ActivityHelper::logActivity([
                'subject_type' => "Converting to a Lead",
                "stage" => $pipelinData->stage,
                "section" => $pipelinData->stage,
                "pipeline_id" => $id,
                'user_id' => $id,
                'description' => "Converted the following to a lead",
                'properties' => $pipelinData,
            ]);

            return response()->json(['message' => 'Opportunity created successfully'], 200);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
    public static function updateLeadsOpportunity($data, $id)
    {
        $lead = Pipeline::findOrFail($id);

        $lead->update($data);
        $pipeline = Pipeline::whereId($id)
            ->update([
                'stage' => 'Opportunity',
            ]);
        if ($pipeline) {
            $pipelinData = Pipeline::whereId($id)->first();
            ActivityHelper::logActivity([
                'subject_type' => "Converting to a Lead",
                "stage" => $pipelinData->stage,
                "section" => $pipelinData->stage,
                "pipeline_id" => $id,
                'user_id' => $id,
                'description' => "Converted the following to a lead",
                'properties' => $pipelinData,
            ]);

            return response()->json(['message' => 'Opportunity created successfully'], 200);
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
            $pipelinData = Pipeline::whereId($id)->first();
            ActivityHelper::logActivity([
                'subject_type' => "Converting to an opportunity",
                "stage" => $pipelinData->stage,
                "section" => $pipelinData->stage,
                "pipeline_id" => $id,
                'user_id' => $id,
                'description' => "Converted the following to a opportunity",
                'properties' => $pipelinData,
            ]);

            return response()->json(['message' => 'Opportunity created successfully'], 201);
        } else {
            // Log an error message or return an error response
            return response()->json(['message' => 'Error creating opportunity'], 500);
        }

    }
}
