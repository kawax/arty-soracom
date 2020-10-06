<?php

namespace Revolution\Soracom\Concerns;

trait Auth
{
    /**
     * @return $this
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
     *
     * @return $this
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
     *
     * @return $this
     * @throws
     */
    private function authRequest(array $json)
    {
        $response = $this->httpClient()->request(
            'POST',
            $this->endpoint().'/auth',
            [
                'json' => $json,
            ]
        );

        $res = json_decode($response->getBody(), true);

        $this->api_key = $res['apiKey'] ?? '';
        $this->token = $res['token'] ?? '';
        $this->operator_id = $res['operatorId'] ?? '';

        return $this;
    }
}
