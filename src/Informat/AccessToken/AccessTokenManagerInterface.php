<?php

namespace Koba\Informat\AccessToken;

interface AccessTokenManagerInterface
{
    /** Should return a valid, non-expired access token */
    public function getAccessToken(): AccessToken;
    public function setAccessTokenFetcher(AccessTokenFetcher $fetcher): self;
}
