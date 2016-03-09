<?php

namespace Monero;

use Graze\GuzzleHttp\JsonRpc\Client;

class Wallet
{
    /**
     * Test constructor.
     * @param $hostname
     * @param $port
     */
    function __construct($hostname, $port)
    {
        $url = $hostname . ':' . $port . '/json_rpc';
        $this->client = Client::factory($url);
    }

    /**
     * Helper function for creating wallet requests
     * @param $method
     * @param $params
     * @return string
     */
    public function _request($method, $params)
    {
        $response = $this->client->send($this->client->request(0, $method));
        $response = json_decode($response->getBody());
        return json_encode($response->result);
    }

    /**
     * Return total balance and unlocked balance of wallet
     */
    public function getBalance()
    {
        $method = 'getbalance';
        $params = '';
        $balance = $this->_request($method, $params);
        return $balance;
    }

    /**
     * Return the address of the wallet
     */
    public function getAddress()
    {
        $method = 'getaddress';
        $params = '';
        $address = $this->_request($method, $params);
        return $address;
    }

    /**
     *
     */
}