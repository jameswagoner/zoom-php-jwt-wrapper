<?php

namespace WAGoner\ZoomWrapper\Test;

use PHPUnit\Framework\TestCase;
use WAGoner\ZoomWrapper\Zoom;

class ZoomTest extends TestCase
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
