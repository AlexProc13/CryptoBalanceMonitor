<?php

namespace App\Servises\Wallets\Currencies\ETH;

use App\Servises\Wallets\Currencies\Source;
use App\Servises\Wallets\Currencies\Wallet;
use App\Servises\Wallets\Clients\EtherscanClient;

class ETHWallet extends Wallet
{
    use ETHWalletTrait;

    /**
     * @param $pennies
     * @return string
     */
    public function fromPennyToCoin($pennies): string
    {
        //todo convert
        return $pennies;
    }

    public function isAddress(string $address): bool
    {
        //See: https://github.com/ethereum/web3.js/blob/7935e5f/lib/utils/utils.js#L415
        if ($this->matchesPattern($address)) {
            return $this->isAllSameCaps($address) ?: $this->isValidChecksum($address);
        }

        return false;
    }

    public function getSource(): Source
    {
        $client = new EtherscanClient();
        return new ETHSource($client);
    }
}
