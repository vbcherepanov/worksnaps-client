<?php

declare(strict_types=1);

namespace Worksnaps\SDK\Core\Credentials;

use LogicException;

/**
 * Class Credentials
 *
 * @package Worksnaps\SDK\Core\Credentials
 */
class Credentials
{
    /**
     * @var bool
     */
    protected $ssl;
    /**
     * @var AccessToken|null
     */
    protected $accessToken;
    /**
     * Credentials constructor.
     *
     * @param AccessToken|null        $accessToken
     * @param bool|false              $ssl
     */
    public function __construct(
        ?AccessToken $accessToken,
        $ssl=false
    ) {
        $this->accessToken = $accessToken;
        $this->ssl = $ssl;

        if ($this->accessToken === null) {
            throw new LogicException(sprintf('you must set on of auth type: webhook or OAuth 2.0'));
        }
    }

    /**
     * @param AccessToken $accessToken
     */
    public function setAccessToken(AccessToken $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return bool
     */
    public function isSsl(): bool
    {
        return $this->ssl;
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @param AccessToken        $accessToken
     * @param bool               $ssl
     *
     * @return static
     */
    public static function createForAuth(AccessToken $accessToken ,bool $ssl =false): self
    {
        return new self(
            $accessToken,
            $ssl
        );
    }
}