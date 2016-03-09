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
    public function _request($body)
    {
        $response = $this->client->send($this->client->request(0, $body['method']));
        $response = json_decode($response->getBody());
        return json_encode($response->result);
    }

    /**
     * Return total balance and unlocked balance of wallet
     */
    public function getBalance()
    {
        $body = ['method' => 'getbalance'];
        $balance = $this->_request($body);
        return $balance;
    }

    /**
     * Return the address of the wallet
     */
    public function getAddress()
    {
        $body = ['method' => 'getaddress'];
        $address = $this->_request($body);
        return $address;
    }

    /**
     * Return the current block height
     */
    public function getHeight()
    {
        $body = ['method' => 'getheight'];
        $height = $this->_request($body);
        return $height;
    }

    /**
     * Transfer Monero to a single recipient or group of recipients
     */
    public function transfer($options)
    {
        $body = [
            'method' => 'transfer',
            'destinations' => [$options['destinations']],
            'mixin' => ($options['mixin'] ? $options['mixin'] : 4),
            'unlock_time' => ($options['unlock_time'] ? $options['unlock_time'] : 0),
            'payment_id' => ($options['payment_id'] ? $options['payment_id'] : null)
        ];
        $tx_hash = $this->request($body);
        return $tx_hash;
    }
}