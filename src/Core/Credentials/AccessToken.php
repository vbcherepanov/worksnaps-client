<?php

declare(strict_types=1);

namespace Worksnaps\SDK\Core\Credentials;

/**
 * Class AccessToken
 *
 * @package Worksnaps\SDK\Core\Credentials
 */
class AccessToken
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * AccessToken constructor.
     *
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public static function initFromArray(array $request): self
    {
        return new self(
            (string)$request['access_token']
        );
    }
}