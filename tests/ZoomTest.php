<?php

namespace Wagoner\Zoom\Test;

use Lcobucci\JWT\Token;
use PHPUnit\Framework\TestCase;
use Wagoner\Zoom\Zoom;

class ZoomTest extends TestCase
{

    public function testMissingApiKeyRaisesException()
    {
        $this->expectExceptionMessage('No API Key and Secret provided');
        new Zoom();
    }

    public function testJwtIsGenerated()
    {
        $client = new Zoom('apiKey', 'apiSecret');
        $client->setJWT();

        $this->assertInstanceOf(Token::class, $client->getJWT());
    }
}
