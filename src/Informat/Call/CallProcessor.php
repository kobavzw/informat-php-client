<?php

namespace Koba\Informat\Call;

use Koba\Informat\AccessToken\AccessTokenManagerInterface;
use Koba\Informat\Exceptions\CallException;
use Koba\Informat\Exceptions\InternalErrorException;
use Koba\Informat\Helpers\InstituteNumber;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class CallProcessor
{
    protected const BASE_URL = 'https://leerlingenapi.informatsoftware.be/';

    public function __construct(
        protected AccessTokenManagerInterface $accessTokenManager,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
    ) {
    }

    protected function buildUrl(string $endpoint): string
    {
        return self::BASE_URL . ltrim($endpoint, '/');
    }

    public function buildRequest(
        string $method,
        string $endpoint,
        InstituteNumber $instituteNumber
    ): EncapsulatedRequest {
        return new EncapsulatedRequest(
            $this->requestFactory
                ->createRequest(
                    $method,
                    $this->buildUrl($endpoint)
                )
                ->withAddedHeader(
                    'Authorization',
                    'BEARER ' . $this->accessTokenManager->getAccessToken()
                )
                ->withAddedHeader('InstituteNo', (string)$instituteNumber)
                ->withAddedHeader('Content-Type', 'application/json'),
            $this->streamFactory
        );
    }

    public function send(EncapsulatedRequest $request): ResponseInterface
    {
        $response = $this->httpClient->sendRequest($request->getRequest());

        if ($response->getStatusCode() === 200) {
            return $response;
        } else {
            $decoded = json_decode($response->getBody()->getContents(), true);
            if (
                is_array($decoded)
                && array_key_exists('message', $decoded)
                && array_key_exists('errors', $decoded)
                && is_array($decoded['errors'])
            ) {
                throw new CallException(
                    $decoded['message'],
                    array_map(
                        fn (array $err) => $err['message'],
                        $decoded['errors']
                    )
                );
            }

            throw new InternalErrorException($response->getBody()->getContents());
        }
    }
}
