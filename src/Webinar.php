<?php

namespace Wagoner\Zoom;

class Webinar extends Zoom
{
    public $baseUrl = 'https://api.zoom.us/v2/webinars/';

    public function __construct(string $apiKey, string $apiSecret)
    {
        parent::__construct($apiKey, $apiSecret);
    }

    public function find($id)
    {
        $resource = $this->baseUrl . $id;

        return $this->request('GET', $resource);
    }
}