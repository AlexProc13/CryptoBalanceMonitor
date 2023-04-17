<?php

namespace App\Servises\Wallets\Currencies\ETH;

use App\Servises\Wallets\Currencies\Source;
use Illuminate\Support\Facades\Http;

class ETHSource extends Source
{
    /**
     * @param $address
     * @return string
     */
    public function getBalance($address): string
    {
        $key = config('wallets.sources.ETH.key');
        $response = $this->client->call(['account', 'balance', $address, $key]);
        return $response['result'];
    }

    /**
     * @param $addresses
     * @return array
     */
    public function getBalances($addresses): array
    {
        $key = config('wallets.sources.ETH.key');
        $response = $this->client->call(['account', 'balancemulti', implode(',', $addresses), $key]);
        $result = [];
        foreach ($response['result'] as $accountBalance) {
            $result[$accountBalance['account']] = $accountBalance['balance'];
        }
        return $result;
    }
}
