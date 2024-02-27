<?php

namespace App\Http\Controllers;

use App\Http\Resources\ComplianceDocumentResource;
use App\Mail\DocumentUploadedSuccessfullyMail;
use App\Mail\NotificationBankUploadedDocuments;
use App\Models\Bank;
use App\Models\Document;
use App\Models\Pipeline;
use App\Models\UploadDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UploadDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getDocument($uuid)
    {
        return response()->json([
            'data' => UploadDocument::where('slug', $uuid)->first(),
        ]);
    }
    public function getCompliance($id)
    {
        $uuid = UploadDocument::where('pipeline_id', $id)->latest()->value('slug');
        $documents = Document::where('uuid', $uuid)->get();
        return response()->json([
            'data' => ComplianceDocumentResource::collection($documents),
        ]);
    }
    public function postDocument(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file',
        ]);
        $uuid = $request->input('uuid');
        $uploadedDocuments = UploadDocument::where('slug', $uuid)->first();
        $pipeline = Pipeline::where('id', $uploadedDocuments->pipeline_id)->first();
        $bank = Bank::whereId($uploadedDocuments->pipeline_id)->first();
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('documents', 'public');
                Document::create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'pipeline_id' => $uploadedDocuments->pipeline_id,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'uuid' => $uuid,
                ]);
            }
        }
        Mail::to($uploadedDocuments->email)->send(new DocumentUploadedSuccessfullyMail($uploadedDocuments->documents));
        Mail::to($bank->email)->send(new NotificationBankUploadedDocuments($pipeline->name, $uploadedDocuments->documents));
        return response()->json([
            'message' => 'Files uploaded successfully',
        ], 200);
    }

}
