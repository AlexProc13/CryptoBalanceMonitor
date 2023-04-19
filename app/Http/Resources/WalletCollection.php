<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['data' => $this->collection,];
    }

    /**
     * Customize the pagination information for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $paginated
     * @param array $default
     * @return array
     */
    public function paginationInformation($request, $paginated, $default): array
    {
        return [
            'status' => true,
            'total' => $this->total(),
            'perPage' => $this->perPage(),
            'hasPages' => $this->hasPages(),
            'currentPage' => $this->currentPage(),
            'previousPageUrl' => $this->previousPageUrl(),
        ];
    }
}
