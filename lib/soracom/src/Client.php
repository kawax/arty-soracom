<?php

namespace Revolution\Soracom;

use Illuminate\Support\Traits\Macroable;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

use Revolution\Soracom\Contracts\Factory;

class Client implements Factory
{
    use Concerns\Auth;
    use Concerns\Billing;

    use Macroable;

    /**
     * @var GuzzleClient
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
     * @param  array  $config
     */
    public function __construct(array $config)
    {
        $this->auth_id = $config['auth_id'] ?? '';
        $this->auth_secret = $config['auth_secret'] ?? '';
        $this->api_key = $config['api_key'] ?? '';
        $this->token = $config['token'] ?? '';
        $this->endpoint = $config['endpoint'] ?? self::API_BASE_URL;
    }

    /**
     * @param  string  $api
     * @param  array  $params
     * @return array
     * @throws ClientException
     */
    public function get(string $api, array $params = [])
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->httpClient()->get($this->endpoint().$api, [
            'headers' => $this->headers(),
            'query'   => $params,
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param  string  $api
     * @param  array  $json
     * @return array
     * @throws ClientException
     */
    public function post(string $api, array $json = [])
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->httpClient()->post($this->endpoint().$api, [
            'headers' => $this->headers(),
            'json'    => $json,
        ]);

        return json_decode($response->getBody(), true);
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
     * @return ClientInterface
     */
    protected function httpClient(): ClientInterface
    {
        if (is_null($this->http)) {
            $this->http = new GuzzleClient();
        }

        return $this->http;
    }

    /**
     * @param  ClientInterface  $client
     * @return $this
     */
    public function setHttpClient(ClientInterface $client)
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
