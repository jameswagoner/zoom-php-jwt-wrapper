<?php

namespace WAGoner\Zoom;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use WAGoner\Zoom\Exceptions\ZoomException;

class Zoom
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @var Token
     */
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
        if (is_null($apiKey) && is_null($apiSecret)) {
            throw new ZoomException('No API Key and Secret provided');
        }

        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Sets generated JWT
     */
    public function setJWT() : void
    {
        $this->jwt = $this->generateJWT();
    }

    /**
     * Gets generated JWT
     *
     * @return Token
     */
    public function getJWT() : ?Token
    {
        if ($this->validateJWT()) {
            return $this->jwt;
        }

        return null;
    }

    /**
     * Builds and signs JWT
     *
     * @return Token
     */
    private function generateJWT() : Token
    {
        $signer = new Sha256;
        $key = new Key($this->apiSecret);

        return (new Builder)
            ->issuedBy($this->apiKey)
            ->expiresAt(time() + 3600)
            ->getToken($signer, $key);
    }

    /**
     * Validates JWT
     *
     * @return bool
     */
    private function validateJWT() : bool
    {
        $data = new ValidationData();

        $data->setIssuer($this->apiKey);
        $data->setCurrentTime(time() + 61);

        return $this->jwt->validate($data);
    }
}