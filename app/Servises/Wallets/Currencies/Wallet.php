<?php

namespace App\Servises\Wallets\Currencies;

use App\Models\HistoryBalance;
use Illuminate\Support\Collection;

abstract class Wallet
{
    /**
     * @return Source
     */
    abstract public function getSource(): Source;

    abstract public function fromPennyToCoin(string $pennies): string;

    /**
     * @param Collection $wallets
     * @return bool
     */
    public function updateBalances(Collection $wallets): bool
    {
        //todo catch errors if it would be neeeded
        $addresses = $wallets->pluck('address')->toArray();
        $source = $this->getSource();
        $balancePerAddress = $source->getBalances($addresses);
        foreach ($wallets as $wallet) {
            if (!isset($balancePerAddress[$wallet->address])) {
                continue;
            }

            $balance = $wallet->lastBalance->balance;
            $currentBalance = $balancePerAddress[$wallet->address];
            //update only if changed
            if ($balance === $currentBalance) {
                continue;
            }

            HistoryBalance::create([
                'wallet_id' => $wallet->id,
                'balance' => $currentBalance
            ]);
        }

        return true;
    }
}
