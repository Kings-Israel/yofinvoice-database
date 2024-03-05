<?php

namespace App\Http\Controllers;

use App\Models\BankPaymentAccount;
use App\Http\Requests\StoreBankPaymentAccountRequest;
use App\Http\Requests\UpdateBankPaymentAccountRequest;

class BankPaymentAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreBankPaymentAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BankPaymentAccount $bankPaymentAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankPaymentAccount $bankPaymentAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankPaymentAccountRequest $request, BankPaymentAccount $bankPaymentAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankPaymentAccount $bankPaymentAccount)
    {
        //
    }
}
