<?php


namespace Tests\AppBundle\Controller\Api;

use AppBundle\Test\ApiTestCase;

class ProgrammerControllerTest extends ApiTestCase
{

    public function testPOSTProgrammerWorks()
    {
        $data = array(
            'nickname' => 'ObjectOrienter',
            'avatarNumber' => 5,
            'tagLine' => 'a test dev!'
        );

        $response = $this->client->post('/api/programmers', [
            'body' => \json_encode($data),
            'headers' => $this->getAuthorizedHeaders('weaverryan')
        ]);
    }
}