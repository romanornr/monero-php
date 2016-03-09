<?php

namespace Monero;

use Graze\GuzzleHttp\JsonRpc\Client;

class Wallet
{
    /**
     * Wallet constructor.
     * @param string $hostname
     * @param int $port
     */
    function __construct($hostname = 'http://127.0.0.1', $port = 18082)
    {
        $url = $hostname . ':' . $port . '/json_rpc';
        $this->client = Client::factory($url);
    }

    /**
     * Helper function for creating wallet requests
     * @param $body array
     * @return string
     */
    public function _request($body)
    {
        if(isset($body['params'])){
            $response = $this->client->send($this->client->request(0, $body['method'], $body['params']));
        } else {
            $response = $this->client->send($this->client->request(0, $body['method']));
        }
        $response = json_decode($response->getBody());
        // if there is an error, return the error message otherwise respond with result
        if(property_exists($response, 'error')){
            return json_encode($response->error);
        } else {
            return json_encode($response->result);
        }
    }

    /**
     * Return total balance and unlocked balance of wallet
     * @return string
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
        return $this->_request($body);
    }

    /**
     * Return the current block height
     */
    public function getHeight()
    {
        $body = ['method' => 'getheight'];
        return $this->_request($body);
    }

    /**
     * Transfer Monero to a single recipient or group of recipients
     * @param $options
     * @return string
     */
    public function transfer($options)
    {
        // Convert amount to atomic units
        $options['destinations']['amount'] = $options['destinations']['amount'] * 1e12;
        // Define Mixin
        $mixin = (isset($options['mixin']) ? $options['mixin'] : 4);
        // Define Unlock Time
        $unlock_time = (isset($options['unlock_time']) ? $options['unlock_time'] : 0);
        // Define Payment ID
        $payment_id = (isset($options['payment_id']) ? $options['payment_id'] : null);
        $params = [
            'destinations' => [$options['destinations']],
            'mixin' => $mixin,
            'unlock_time' => $unlock_time,
            'payment_id' => $payment_id
        ];
        $body = [
            'method' => 'transfer',
            'params' => $params
        ];
        return $this->_request($body);
    }

    public function transferSplit($options)
    {

    }

    /**
     * Send all dust output back to the wallet with mixin 0
     */
    public function sweepDust()
    {
        $body = ['method' => 'sweep_dust'];
        return $this->_request($body);
    }

    /**
     * Save the blockchain
     */
    public function store()
    {
        $body = ['method' => 'store'];
        return $this->_request($body);
    }

    /**
     * Get a list of incoming payments from a given payment ID
     */
    public function getPayments($payment_id)
    {
        $params = ['payment_id' => $payment_id];
        $body = [
            'method' => 'get_payments',
            'params'=> $params
        ];
        return $this->_request($body);
    }

    /**
     * Get a list of incoming payments from a single payment ID or list of payment IDs from a given height
     */
    public function getBulkPayments($payment_ids, $height)
    {

    }

    /**
     * Return a list of incoming transfers to the wallet.
     * @param $type
     * @return string
     */
    public function incomingTransfers($type)
    {
        $params = ['transfer_type' => $type];
        $body = [
            'method' => 'incoming_transfers',
            'params' => $params
        ];
        return $this->_request($body);
    }

    /**
     * Return the spend or view private key.
     * @param $key_type string
     * @return string
     */
    public function queryKey($key_type)
    {
        $params = ['key_type' => $key_type];
        $body = [
            'method' => 'query_key',
            'params' => $params
        ];
        return $this->_request($body);
    }

    public function integratedAddress($payment_id)
    {

    }

    /**
     * Retrieve the standard address and payment id corresponding to an integrated address.
     * @param $address string
     * @return string
     */
    public function splitIntegratedAddress($address)
    {
        $params = ['integrated_address' => $address];
        $body = [
            'method' => 'split_integrated_address',
            'params' => $params
        ];
        return $this->_request($body);
    }

    /**
     * Stops the wallet, storing the current state.
     * @return string
     */
    public function stopWallet()
    {
        $body = ['method' => 'stop_wallet'];
        return $this->_request($body);
    }
}