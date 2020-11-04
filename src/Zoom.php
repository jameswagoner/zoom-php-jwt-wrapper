<?php

namespace Wagoner\Zoom;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Wagoner\Zoom\Exceptions\ZoomException;

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
     * @var Client
     */
    public $client;

    /**
     * Client constructor.
     *
     * @param string $apiKey
     * @param string $apiSecret
     *
     * @throws ZoomException
     */
    public function __construct(string $apiKey, string $apiSecret)
    {
        if (is_null($apiKey) || is_null($apiSecret)) {
            throw new ZoomException('No API Key and Secret provided');
        }

        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

        $this->setClient();
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

    /**
     * Sets the HTTP client
     *
     * @return void
     */
    private function setClient() : void
    {
        $this->client = new Client([
            'headers' => [
                'Authorization' => "Bearer $this->jwt"
            ]
        ]);
    }

    public function request($method, $uri, $options = [])
    {
        try {
            $response = $this->client->request($method, $uri, $options);

            return json_encode($response->getBody());
        } catch (GuzzleException $e) {

        }
    }

    /**
     * Returns API resource class
     *
     * @param $class
     *
     * @return mixed
     */
    public function __get($class)
    {
        $class = "Wagoner\\Zoom\\" .  ucfirst($class);

        return new $class($this->apiKey, $this->apiSecret);
    }
}