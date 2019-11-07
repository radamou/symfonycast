<?php

namespace KnpU\CodeBattle\Tests;

use Guzzle\Http\Client;
use PHPUnit\Framework\TestCase;

class ProgrammerControllerTest extends TestCase
{
    public function testPOST()
    {
        // create our http client (Guzzle)
        $client = new Client('http://localhost:8000', [
            'request.options' => [
                'exceptions' => false,
            ],
        ]);

        $nickname = 'ObjectOrienter'.\rand(0, 999);
        $data = [
            'nickname' => $nickname,
            'avatarNumber' => 5,
            'tagLine' => 'a test dev!',
        ];

        $request = $client->post('/api/programmers', null, \json_encode($data));
        $response = $request->send();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $data = \json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('nickname', $data);
    }
}
