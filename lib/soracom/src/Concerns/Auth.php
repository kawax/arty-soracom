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
        $json = [
            'authKeyId' => $this->auth_id,
            'authKey'   => $this->auth_secret,
        ];

        return $this->authRequest($json);
    }

    /**
     * @param  string  $email
     * @param  string  $password
     * @return $this
     * @throws ClientException
     */
    public function authByPassword(string $email, string $password)
    {
        $json = [
            'email'    => $email,
            'password' => $password,
        ];

        return $this->authRequest($json);
    }

    /**
     * @param  array  $json
     * @return $this
     * @throws ClientException
     */
    private function authRequest(array $json)
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->httpClient()->post($this->endpoint().'/auth', [
            'json' => $json,
        ]);

        $res = json_decode($response->getBody());

        $this->api_key = $res->apiKey ?? '';
        $this->token = $res->token ?? '';
        $this->operator_id = $res->operatorId ?? '';

        return $this;
    }
}
