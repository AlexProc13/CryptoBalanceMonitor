<?php

namespace App\Servises\Wallets\LTC;

use App\Servises\Wallets\Source;
use Illuminate\Support\Facades\Http;

class LTCSource extends Source
{
    public const URL = 'https://api.blockchair.com/litecoin/addresses/balances?addresses=%s';

    public function getBalance($address): string
    {
        $response = $this->call([implode(',', $address)]);
        $balance = 0;
        if (isset( $response['data'][$address])) {
            $balance = $response['data'][$address];
        }
        return $balance;
    }

    public function getBalances($addresses): array
    {
        $response = $this->call([implode(',', $addresses)]);
        return $response['data'];
    }

    public function call($params): array
    {
        $url = sprintf(self::URL, ...$params);
        $response = Http::timeout(self::TIME_OUT)->get($url);
        return $response->json();
    }
}
