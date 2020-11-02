<?php

namespace WAGoner\ZoomWrapper;

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function testKeysAreSet()
    {
        new Zoom('apiKey', 'apiSecret');
        $this->assertClassHasAttribute('apiKey', '\WAGoner\ZoomWrapper\Zoom');
        $this->assertClassHasAttribute('apiSecret', '\WAGoner\ZoomWrapper\Zoom');
    }

    public function testJwtIsGenerated()
    {
        $client = new Zoom('apiKey', 'apiSecret');
        $client->setJWT();

        $this->assertNotNull($client->getJWT());
    }
}
