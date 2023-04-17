<?php

namespace App\Servises\Wallets\Currencies\LTC;

use App\Servises\Wallets\Currencies\Source;
use App\Servises\Wallets\Currencies\Wallet;
use App\Servises\Wallets\Clients\BlockchairClient;

class LTCWallet extends Wallet
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
        preg_match('/^[LM3][a-km-zA-HJ-NP-Z1-9]{26,70}$/', $address, $matches);
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
        return new LTCSource($client);
    }
}
