<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClosedDealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avatarUrl = asset("images/avatars/avatar-1.png");

        return [
            'id' => $this->id,
            'bank_name' => $this->getRandomKenyanBank(),
            'company' => $this->company,
            'avatar' => $avatarUrl,
            'contact_person' => $this->contact_name,
            'phone_number' => $this->phone_number,
            'status' => $this->getRandomStatus(),
            'date' => $this->created_at->format('d-M-Y'),
        ];

    }
    public function getRandomKenyanBank()
    {
        $banks = [
            'Kenya Commercial Bank (KCB)',
            'Equity Bank',
            'Co-operative Bank of Kenya',
            'Standard Chartered Bank',
            'Barclays Bank of Kenya',
            'Absa Bank Kenya',
            'Diamond Trust Bank (DTB)',
            'National Bank of Kenya',
            'Citi Bank Kenya',
            'Stanbic Bank Kenya',
            'NIC Bank',
            'Housing Finance Company of Kenya',
            'Family Bank',
            'Chase Bank (In Receivership)',
            'Consolidated Bank of Kenya',
        ];
        $randomIndex = array_rand($banks);
        return $banks[$randomIndex];
    }
    public function getRandomStatus()
    {
        $status = [
            'Successfully Program Setup',
            'Pending Program Onboard',
        ];
        $randomIndex = array_rand($status);
        return $status[$randomIndex];
    }

}
