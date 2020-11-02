<?php

namespace WAGoner\ZoomWrapper;

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function testKeysAreSet()
    {
        new Client('apiKey', 'apiSecret');
        $this->assertClassHasAttribute('apiKey', '\WAGoner\ZoomWrapper\Client');
        $this->assertClassHasAttribute('apiSecret', '\WAGoner\ZoomWrapper\Client');
    }

    public function testJwtIsGenerated()
    {
        $client = new Client('apiKey', 'apiSecret');
        $client->setJWT();

        $this->assertNotNull($client->getJWT());
    }
}
