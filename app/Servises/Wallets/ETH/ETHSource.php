<?php

namespace App\Servises\Wallets\ETH;

use App\Servises\Wallets\Source;
use Illuminate\Support\Facades\Http;

class ETHSource extends Source
{
    public const URL = 'https://api.etherscan.io/api?module=%s&action=%s&address=%s&tag=latest&apikey=%s';

    public function getBalance($address): string
    {
        $key = config('wallets.sources.ETH.key');
        $response = $this->call(['account', 'balance', $address, $key]);
        return $response['result'];
    }

    public function getBalances($addresses): array
    {
        $key = config('wallets.sources.ETH.key');
        $response = $this->call(['account', 'balancemulti', implode(',', $addresses), $key]);
        $result = [];
        foreach ($response['result'] as $accountBalance) {
            $result[$accountBalance['account']] = $accountBalance['balance'];
        }
        return $result;
    }

    public function call($params): array
    {
        $url = sprintf(self::URL, ...$params);
        $response = Http::timeout(self::TIME_OUT)->get($url);
        return $response->json();
    }
}
