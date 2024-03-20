<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramUIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bank' => $this->bank->name,
            'name' => $this->name,
            'code' => $this->code,
            'eligibility' => $this->eligibity,
            'program_limit' => $this->program_limit,
            'approved_date' => $this->approved_date,
            'limit_expiry_date' => $this->limit_expiry_date,
            'max_limit_per_account' => $this->max_limit_per_account,
            'min_financing_days' => $this->min_financing_days,
            'recourse' => $this->recourse,
            'max_financing_days' => $this->max_financing_days,
            'program_type' => $this->programType->name,
            'program_code' => $this->programCode->name,
            'anchor' => $this->getAnchor($this->anchor),
        ];
    }

    public function getAnchor($data)
    {
        return [
            'id' => $data->id,
            'branch_code' => $data->branch_code,
            'organization_type' => $data->organization_type,
            'approval_status' => $data->approval_status,
            'status' => $data->status,
            'customer_type' => $data->customer_type,
            'name' => $data->name,

        ];
    }
}
