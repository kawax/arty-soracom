<?php

namespace Revolution\Soracom\Concerns;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;

trait Auth
{
    /**
     * @return $this
     * @throws ClientException
     */
    public function auth()
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->httpClient()->post($this->endpoint().'/auth', [
            'json' => [
                'authKeyId' => $this->auth_id,
                'authKey'   => $this->auth_secret,
            ],
        ]);

        $res = json_decode($response->getBody());

        $this->api_key = $res->apiKey ?? '';
        $this->token = $res->token ?? '';
        $this->operator_id = $res->operatorId ?? '';

        return $this;
    }

    /**
     * @param  string  $email
     * @param  string  $password
     * @return $this
     * @throws ClientException
     */
    public function authByPassword(string $email, string $password)
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->httpClient()->post($this->endpoint().'/auth', [
            'json' => [
                'email'    => $email,
                'password' => $password,
            ],
        ]);

        $res = json_decode($response->getBody());

        $this->api_key = $res->apiKey ?? '';
        $this->token = $res->token ?? '';
        $this->operator_id = $res->operatorId ?? '';

        return $this;
    }
}
