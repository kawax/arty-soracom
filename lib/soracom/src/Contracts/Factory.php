<?php

namespace Revolution\Soracom\Contracts;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

interface Factory
{
    /**
     * @return $this
     */
    public function auth();

    /**
     * @param  string  $api
     * @param  array  $params
     * @return array
     * @throws ClientException
     */
    public function get(string $api, array $params = []);

    /**
     * @param  string  $api
     * @param  array  $json
     * @return array
     * @throws ClientException
     */
    public function post(string $api, array $json = []);

    /**
     * @param  ClientInterface  $client
     * @return $this
     */
    public function setHttpClient(ClientInterface $client);
}
