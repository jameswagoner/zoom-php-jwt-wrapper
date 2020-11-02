<?php

namespace WAGoner\Zoom;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use WAGoner\Zoom\Exceptions\ZoomException;

class Zoom
{
    /**
     * @var null
     */
    private $apiKey;

    /**
     * @var null
     */
    private $apiSecret;

    private $jwt;

    /**
     * Client constructor.
     *
     * @param null $apiKey
     * @param null $apiSecret
     *
     * @throws ZoomException
     */
    public function __construct($apiKey = null, $apiSecret = null) {
        if (is_null($apiKey)) {
            if (is_null($this->apiKey)) {
                throw new ZoomException('No API Key provided, and non is globally set.');
            }
        }

        if (is_null($apiSecret)) {
            if (is_null($this->apiSecret)) {
                throw new ZoomException('No API Secret provided, and non is globally set.');
            }
        }

        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function setJWT()
    {
        $this->jwt = $this->generateJWT();
    }

    public function getJWT()
    {
        return $this->jwt;
    }

    private function generateJWT() {
        $signer = new Sha256;
        $key = new Key($this->apiSecret);

        return (new Builder())->issuedBy($this->apiKey)
            ->expiresAt(time() + 3600)
            ->getToken($signer, $key);

    }
}