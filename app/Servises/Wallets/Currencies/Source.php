<?php

namespace App\Servises\Wallets\Currencies;

abstract class Source
{
    /**
     * @var null
     */
    protected $client = null;

    /**
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param $address
     * @return string
     */
    abstract public function getBalance($address): string;

    /**
     * @param $addresses
     * @return array
     */
    abstract public function getBalances($addresses): array;

    //...
}
