<?php

namespace App\Api;

class ClientAuthorisation
{
    const CLIENT_SECRET= '6043f0a0367324cd8ab3f0ae9044abc6';
    const CLIENT_ID='oauthTest';

    public function redirectToAuthorization()
    {
        $url = 'http://coop.apps.knpuniversity.com/authorize?'.http_build_query(
            [
                'response_type' => 'code',
                'client_id' =>self::CLIENT_ID,
                'redirect_uri' => 'localhost',
                'scope' => 'eggs-count profile'

            ]);

        var_dump($url);die;
    }
}