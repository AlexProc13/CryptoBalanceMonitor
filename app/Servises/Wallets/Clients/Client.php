<?php

namespace App\Servises\Wallets\Clients;

use Illuminate\Support\Facades\Http;

abstract class Client
{
    /**
     *
     */
    public const TIME_OUT = 10;

    /**
     * @var null
     */
    protected $url = null;

    /**
     * @param $params
     * @return array
     */
    public function call(array $params): array
    {
        $url = sprintf($this->url, ...$params);
        $response = Http::timeout(self::TIME_OUT)->get($url);
        return $response->json();
    }

    /**
     * @param $url
     * @return void
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }
}
