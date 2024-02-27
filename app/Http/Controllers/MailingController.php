<?php

namespace App\Http\Controllers;

use App\Mail\DocumentsUploadMail;
use App\Models\Pipeline;
use App\Models\UploadDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailingController extends Controller
{

    public function generateLink(Request $request)
    {
        $titles = implode(', ', array_column($request->input('data'), 'title'));
        $data = $request->input('data');
        $id = $request->input('target');
        $uploadDocument = UploadDocument::create([
            'slug' => Str::uuid(),
            'email' => Pipeline::whereId($id)->pluck('email')->implode(''),
            'documents' => $titles,
        ]);
        $pipeline = Pipeline::whereId($id)->first();

        $url = env('APP_FRONTEND_URL') . '/documents/' . $uploadDocument->slug;
        Mail::to($uploadDocument->email)->send(new DocumentsUploadMail($pipeline->name, $url, $data));
        return response()->json([
            "url" => $url,
        ]);
    }
}
