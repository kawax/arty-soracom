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

        return $this;
    }
}
