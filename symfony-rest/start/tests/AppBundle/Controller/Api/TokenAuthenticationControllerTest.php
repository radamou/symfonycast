<?php

namespace Tests\AppBundle\Controller\Api;

use AppBundle\Test\ApiTestCase;

class TokenAuthenticationControllerTest extends ApiTestCase
{
    public function testPOSTTokenInvalidCredentials()
    {
        $this->createUser('weaverryan', 'I<3Pizza');
        $response = $this->client->post('/api/tokens', [
            'auth' => ['weaverryan', 'IH8Pizza']
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

}