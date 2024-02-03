<?php

namespace Koba\Informat\AccessToken;

use Koba\Informat\Exceptions\AccessTokenException;
use Koba\Informat\Scopes\ScopeStrategyInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class AccessTokenFetcher
{
    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected ScopeStrategyInterface $scopeStrategy,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory
    ) {
    }

    public function fetch(): AccessToken
    {
        $request = $this->requestFactory
            ->createRequest(
                'POST',
                'https://www.identityserver.be/connect/token'
            )
            ->withAddedHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($this->streamFactory->createStream(
                http_build_query([
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'scope' => implode(' ', $this->scopeStrategy->getScopes()),
                    'grant_type' => 'client_credentials'
                ])
            ));

        $response = $this->httpClient->sendRequest($request);
        if ($response->getStatusCode() !== 200) {
            throw new AccessTokenException('Fetching access token failed.');
        }

        $decoded = json_decode(
            $response->getBody()->getContents(),
            true
        );

        if (
            is_array($decoded)
            && array_key_exists('access_token', $decoded)
            && array_key_exists('expires_in', $decoded)
        ) {
            return new AccessToken($decoded['access_token'], $decoded['expires_in']);
        }

        throw new AccessTokenException('Invalid access token');
    }
}
