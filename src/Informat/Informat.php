<?php

namespace Koba\Informat;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Koba\Informat\AccessToken\AccessTokenFetcher;
use Koba\Informat\AccessToken\AccessTokenManager;
use Koba\Informat\AccessToken\AccessTokenManagerInterface;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Directories\Preregistrations\PreregistrationsDirectory;
use Koba\Informat\Directories\Students\StudentsDirectory;
use Koba\Informat\Scopes\ScopeStrategyInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Informat
{
    protected CallProcessor $callProcessor;

    public function __construct(
        string $clientId,
        string $clientSecret,
        ScopeStrategyInterface $scopeStrategy,
        ?AccessTokenManagerInterface $accessTokenManager = null,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        $httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();

        $this->callProcessor = new CallProcessor(
            ($accessTokenManager ?? new AccessTokenManager)->setAccessTokenFetcher(
                new AccessTokenFetcher(
                    $clientId,
                    $clientSecret,
                    $scopeStrategy,
                    $httpClient,
                    $requestFactory,
                    $streamFactory
                )
            ),
            $httpClient,
            $requestFactory,
            $streamFactory
        );
    }

    public function students(): StudentsDirectory
    {
        return new StudentsDirectory($this->callProcessor);
    }

    public function preregistrations(): PreregistrationsDirectory
    {
        return new PreregistrationsDirectory($this->callProcessor);
    }
}
