<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //it would be executed in loop - cache this data
        static $currencies;
        $currencies = $currencies ?? config('wallets.currencies');
        return [
            'id' => $this->id,
            'address' => $this->address,
            'balance' => $this->lastBalance->balance ?? 0,
            'createdAt' => $this->created_at,
            'balanceChanged' => $this->lastBalance->created_at ?? $this->created_at,
            'coin' => array_flip($currencies)[$this->type],//it is not in task - it is for me to split addresses
        ];
    }
}
