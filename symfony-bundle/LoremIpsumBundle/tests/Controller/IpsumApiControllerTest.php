<?php

namespace KnpU\LoremIpsumBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Client;

class IpsumApiControllerTest extends TestCase
{
    public function testIndex()
    {
        $kernel = new KnpULoremIpsumControllerKernel('test', true);
        $client = new Client($kernel);
        $client->request('GET', '/api/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
