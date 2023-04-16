<?php

namespace App\Servises\Wallets\Currencies\BTC;

use App\Servises\Wallets\Currencies\Source;

class BTCSource extends Source
{
    /**
     * @param $address
     * @return string
     */
    public function getBalance($address): string
    {
        $response = $this->client->call(['bitcoin', $address]);
        $balance = 0;
        if (isset($response['data'][$address])) {
            $balance = $response['data'][$address];
        }
        return $balance;
    }

    /**
     * @param $addresses
     * @return array
     */
    public function getBalances($addresses): array
    {
        $response = $this->client->call(['bitcoin', implode(',', $addresses)]);
        return $response['data'];
    }
}
