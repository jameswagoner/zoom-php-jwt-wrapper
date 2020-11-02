<?php

namespace WAGoner\Zoom\Test;

use Lcobucci\JWT\Token;
use PHPUnit\Framework\TestCase;
use WAGoner\Zoom\Zoom;

class ZoomTest extends TestCase
{

    public function testKeysAreSet()
    {
        new Zoom('apiKey', 'apiSecret');

        $this->assertClassHasAttribute('apiKey', Zoom::class);
        $this->assertClassHasAttribute('apiSecret', Zoom::class);
    }

    public function testJwtIsGenerated()
    {
        $client = new Zoom('apiKey', 'apiSecret');
        $client->setJWT();

        $this->assertInstanceOf(Token::class, $client->getJWT());
    }
}
