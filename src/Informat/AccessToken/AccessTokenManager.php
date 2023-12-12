<?php

namespace Koba\Informat\AccessToken;

class AccessTokenManager implements AccessTokenManagerInterface
{
    protected ?AccessToken $accessToken = null;
    protected AccessTokenFetcher $accessTokenFetcher;

    public function getAccessToken(): AccessToken
    {
        if ($this->accessToken === null || $this->accessToken->expired()) {
            $this->accessToken = $this->accessTokenFetcher->fetch();
        }

        return $this->accessToken;
    }

    public function setAccessTokenFetcher(AccessTokenFetcher $fetcher): self
    {
        $this->accessTokenFetcher = $fetcher;
        return $this;
    }
}
