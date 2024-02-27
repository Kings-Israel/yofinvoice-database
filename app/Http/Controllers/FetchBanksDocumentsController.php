<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankDocumentsResource;
use App\Models\Bank;
use App\Models\BankDocument;
use Illuminate\Support\Facades\Http;

class FetchBanksDocumentsController extends Controller
{
    public function getDocuments()
    {
        $response = Http::get('https://yofinvoice.deveint.live/bank/api/banks');
        $data = $response->json();

        foreach ($data['data'] as $bankData) {
            $bank = Bank::create([
                'name' => $bankData['name'],
                'url' => $bankData['url'],
                'email' => $bankData['email'],
                'contact_person_id' => $bankData['contact_person_id'],
            ]);
            foreach ($bankData['required_documents'] as $document) {
                BankDocument::create([
                    'bank_id' => $bank->id,
                    'name' => $document['name'],
                    'requires_expiry_date' => $document['requires_expiry_date'],
                ]);

            }
        }

        return response()->json($response->json());
    }
    public function getBankDocuments()
    {
        $bankDocuments = Bank::with('requiredDocuments')->get();
        return response()->json([
            'data' => BankDocumentsResource::collection($bankDocuments),
        ]);
    }
}
