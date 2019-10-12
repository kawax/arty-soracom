<?php

namespace Revolution\Soracom\Concerns;

use Psr\Http\Message\ResponseInterface;

trait Auth
{
    /**
     * @return $this
     */
    public function auth()
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->httpClient()->post($this->endpoint().'/auth', [
            'json' => [
                'email'    => $this->email,
                'password' => $this->password,
            ],
        ]);

        $res = json_decode($response->getBody());

        $this->api_key = $res->apiKey;
        $this->token = $res->token;

        return $this;
    }
}
