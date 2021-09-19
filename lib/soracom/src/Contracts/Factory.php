<?php

namespace Revolution\Soracom\Contracts;

use GuzzleHttp\ClientInterface;

interface Factory
{
    public const API_BASE_URL = 'https://api.soracom.io/v1';

    /**
     * @return $this
     */
    public function auth();

    /**
     * @param  string  $email
     * @param  string  $password
     * @return $this
     */
    public function authByPassword(string $email, string $password);

    /**
     * @param  string  $api
     * @param  array  $params
     * @return array
     */
    public function get(string $api, array $params = []);

    /**
     * @param  string  $api
     * @param  array  $json
     * @return array
     */
    public function post(string $api, array $json = []);

    /**
     * @param  ClientInterface  $client
     * @return $this
     */
    public function setHttpClient(ClientInterface $client);

    /**
     * @return array
     */
    public function getLatestBilling();
}
