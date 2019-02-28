<?php

namespace App\Api;

use GuzzleHttp\Client;

class CollectEggs
{
    const BASE_URI = 'http://coop.apps.knpuniversity.com';
    const CLIENT_SECRET= '6043f0a0367324cd8ab3f0ae9044abc6';
    const CLIENT_ID='oauthTest';
    const GRANT_TYPE='client_credentials';

    public function http()
    {
        return new Client(['base_uri' => self::BASE_URI]);
    }

    public function createToken(): ?string
    {
        $client = $this->http();

        $request = $client->post('/token',
            [
                "form_params" => [
                    'client_id'     => self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
                    'grant_type'    => self::GRANT_TYPE,
                ]
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);

        return $response['access_token'] ?? null;

    }

    public function postEggs(): string
    {
        $token = $this->createToken();
        $client = $this->http();

        $request = $client->post('/api/257/eggs-collect',
            [
                'headers' => ['Authorization' => 'Bearer '.$token],
            ]
        );

        var_dump($request->getBody()->getContents());die;
    }
}