<?php

namespace Koba\Informat\AccessToken;

class AccessToken
{
    protected int $created_at;

    public function __construct(
        protected string $accessToken,
        protected int $expiresIn,
        ?int $created_at = null
    ) {
        $this->created_at = $created_at ?? time();
    }

    /**
     * Returns whether the access token has expired.
     */
    public function expired(): bool
    {
        return (time() - $this->created_at) > $this->expiresIn;
    }

    /**
     * Returns the actual bearer token you need to include in request headers.
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Returns the timestamp on which the access token was created.
     */
    public function getCreatedAt(): int
    {
        return $this->created_at;
    }

    /**
     * Returns the number of seconds after which the access token expires,
     * starting from the creation date of the token.
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * String transformation, just returns the bearer token.
     * @return string 
     */
    public function __toString()
    {
        return $this->getAccessToken();
    }
}
