<?php

namespace WAGoner\ZoomWrapper;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Client
{
    private $apiKey;

    private $apiSecret;

    public function __construct($apiKey, $apiSecret) {
        $this->apiKey = $apiKey;

        $this->apiSecret = $apiSecret;
    }

    private function generateJWTKey() {
        $signer = new Sha256;

        return (new Builder())->issuedBy($this->apiKey)
            ->expiresAt(time() + 3600)
            ->getToken($signer, $this->apiSecret);

    }
}