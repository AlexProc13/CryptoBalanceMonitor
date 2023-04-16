<?php

namespace App\Servises\Wallets\Currencies\BTC;

use App\Servises\Wallets\Clients\BlockchairClient;
use App\Servises\Wallets\Currencies\Source;
use App\Servises\Wallets\Currencies\Wallet;

class BTCWallet extends Wallet
{
    /**
     * @param $pennies
     * @return string
     */
    public function fromPennyToCoin($pennies): string
    {
        //todo convert
        return $pennies;
    }

    /**
     * @param string $address
     * @return bool
     */
    public function isAddress(string $address): bool
    {
        //todo use other way
        preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $address, $matches);
        if (empty($matches)) {
            return false;
        }
        return true;
    }

    /**
     * @return Source
     */
    public function getSource(): Source
    {
        $client = new BlockchairClient();
        return new BTCSource($client);
    }
}
