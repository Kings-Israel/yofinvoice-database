<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColdDealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = $this->getRandomDateAndDaysDifference();

        return [
            'id' => $this->id,
            'company_name' => $this->company,
            'contact_person' => $this->contact_name,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'inactive_period' => rand(10, $result['daysDifference']),
        ];

    }
    public function getDesignation()
    {
        $designation = [
            'HR Manager',
            'ICT',
            'Finacial Department',
        ];
        $randomIndex = array_rand($designation);
        return $designation[$randomIndex];
    }
    public function getRandomDateAndDaysDifference()
    {
        $currentDate = Carbon::now();
        $lastYearDate = Carbon::now()->subYear()->addDays(rand(1, 365));
        $daysDifference = $currentDate->diffInDays($lastYearDate);
        $lastYearDateFormatted = $lastYearDate->format('Y-m-d');
        return [
            'randomDate' => $lastYearDateFormatted,
            'daysDifference' => $daysDifference,
        ];
    }
}
