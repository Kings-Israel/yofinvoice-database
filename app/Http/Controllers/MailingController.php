<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Mail\DocumentsUploadMail;
use App\Models\BankDocument;
use App\Models\Pipeline;
use App\Models\UploadDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailingController extends Controller
{

    public function generateLink(Request $request)
    {
        $bankID = $request->input('bank');
        $pipelineID = $request->input('pipeline');
        $pipeline = Pipeline::whereId($pipelineID)->first();
        $documents = BankDocument::where('bank_id', $bankID)->pluck('name');

        $uploadDocument = UploadDocument::create([
            'slug' => Str::uuid(),
            'email' => $pipeline->email,
            'pipeline_id' => $pipelineID,
            'documents' => json_encode($documents),
        ]);
        $url = env('APP_FRONTEND_URL') . '/documents/' . $uploadDocument->slug;

        Mail::to($pipeline->email)->send(new DocumentsUploadMail($pipeline->name, $url, $documents));
        $pipeline->update([
            'bank_id' => $bankID,
        ]);
        ActivityHelper::logActivity([
            'subject_type' => "Document",
            "stage" => "Emailing Documents Link",
            "section" => "Emailing Documents",
            "pipeline_id" => $pipelineID,
            'user_id' => $pipelineID,
            'description' => "Request for lead name" . $url,
            'properties' => $uploadDocument,
        ]);

        return response()->json([
            "url" => $url,
            'message' => "Uploaded",
        ]);
    }
}
