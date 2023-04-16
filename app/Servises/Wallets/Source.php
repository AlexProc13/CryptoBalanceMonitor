<?php

namespace App\Servises\Wallets;

abstract class Source
{
    public const TIME_OUT = 10;

    abstract public function getBalance($address);

    abstract public function getBalances($addresses);
    abstract public function call($params);
}
