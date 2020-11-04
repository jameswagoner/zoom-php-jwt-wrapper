<?php

namespace Wagoner\Zoom\Test;

use PHPUnit\Framework\TestCase;
use Wagoner\Zoom\Zoom;

class WebinarTest extends TestCase
{
    public function testGetWebinar()
    {
        // TODO: need to start mocking
        $zoom = new Zoom('apiKey', 'apiSecret');

        $webinar = $zoom->webinar->find(12345);

        $this->assertTrue(89909979149, $webinar->id);
    }
}