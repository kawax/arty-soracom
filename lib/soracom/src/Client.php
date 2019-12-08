<?php

namespace Revolution\Soracom;

use Revolution\Soracom\Contracts\Factory;
use Illuminate\Support\Traits\Macroable;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client implements Factory
{
    use Concerns\Auth;
    use Concerns\Billing;
    use Macroable;

    /**
     * @var HttpClientInterface
     */
    protected $http;

    /**
     * @var string
     */
    protected $auth_id;

    /**
     * @var string
     */
    protected $auth_secret;

    /**
     * @var string
     */
    protected $operator_id;

    /**
     * @var string
     */
    protected $api_key;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * constructor.
     *
     * @param  HttpClientInterface  $http
     * @param  array  $config
     */
    public function __construct(HttpClientInterface $http, array $config)
    {
        $this->http = $http;
        $this->auth_id = $config['auth_id'] ?? '';
        $this->auth_secret = $config['auth_secret'] ?? '';
        $this->api_key = $config['api_key'] ?? '';
        $this->token = $config['token'] ?? '';
        $this->endpoint = $config['endpoint'] ?? self::API_BASE_URL;
    }

    /**
     * @param  string  $api
     * @param  array  $params
     *
     * @return array
     * @throws
     */
    public function get(string $api, array $params = [])
    {
        $response = $this->httpClient()->request(
            'GET',
            $this->endpoint().$api,
            [
                'headers' => $this->headers(),
                'query'   => $params,
            ]
        );

        return $response->toArray();
    }

    /**
     * @param  string  $api
     * @param  array  $json
     *
     * @return array
     * @throws
     */
    public function post(string $api, array $json = [])
    {
        $response = $this->httpClient()->request(
            'POST',
            $this->endpoint().$api,
            [
                'headers' => $this->headers(),
                'json'    => $json,
            ]
        );

        return $response->toArray();
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'X-Soracom-API-Key' => $this->api_key,
            'X-Soracom-Token'   => $this->token,
        ];
    }

    /**
     * @return HttpClientInterface
     */
    protected function httpClient(): HttpClientInterface
    {
        return $this->http;
    }

    /**
     * @param  HttpClientInterface  $client
     *
     * @return $this
     */
    public function setHttpClient(HttpClientInterface $client)
    {
        $this->http = $client;

        return $this;
    }

    /**
     * @return string
     */
    protected function endpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function operatorId(): string
    {
        return $this->operator_id;
    }
}
