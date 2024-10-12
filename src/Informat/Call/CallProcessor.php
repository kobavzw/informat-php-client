<?php

namespace Koba\Informat\Call;

use Koba\Informat\AccessToken\AccessTokenManagerInterface;
use Koba\Informat\Enums\BadRequestCode;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Enums\MethodNotAllowedCode;
use Koba\Informat\Exceptions\BadRequestException;
use Koba\Informat\Exceptions\CallException;
use Koba\Informat\Exceptions\InternalErrorException;
use Koba\Informat\Exceptions\MethodNotAllowedException;
use Koba\Informat\Exceptions\NotFoundException;
use Koba\Informat\Helpers\InstituteNumber;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

class CallProcessor
{
    public function __construct(
        protected AccessTokenManagerInterface $accessTokenManager,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
    ) {}

    public function buildRequest(
        string $url,
        HttpMethod $method,
        InstituteNumber $instituteNumber
    ): EncapsulatedRequest {
        return new EncapsulatedRequest(
            $this->requestFactory
                ->createRequest($method->value, $url)
                ->withAddedHeader(
                    'Authorization',
                    'BEARER ' . $this->accessTokenManager->getAccessToken()
                )
                ->withAddedHeader('InstituteNo', (string)$instituteNumber)
                ->withAddedHeader('Content-Type', 'application/json'),
            $this->streamFactory
        );
    }

    /**
     * Sends the request.
     * 
     * @throws NotFoundException 
     * @throws MethodNotAllowedException 
     * @throws CallException 
     * @throws InternalErrorException 
     */
    public function send(EncapsulatedRequest $request): ResponseInterface
    {
        $response = $this->httpClient->sendRequest($request->getRequest());

        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            case 400:
                $this->handleBadRequest($response);
            case 404:
                throw new NotFoundException;
            case 405:
                $this->handleMethodNotAllowed($response);
            default:
                throw $this->getGenericError($response);
        }
    }

    /**
     * If a method not allowed response is return, this function will try
     * to generate a specific exception for it and throw it. If this doesn't
     * throw, generic error handling should be used.
     * 
     * @throws MethodNotAllowedException
     */
    protected function handleMethodNotAllowed(
        ResponseInterface $response
    ): void {
        $exception = null;
        $body = json_decode($response->getBody()->getContents(), true);

        if (
            is_array($body)
            && array_key_exists('errors', $body)
            && is_array($body['errors'])
        ) {
            foreach ($body['errors'] as $error) {
                if (
                    is_array($error)
                    && array_key_exists('Code', $error)
                    && array_key_exists('Message', $error)
                ) {
                    $code = MethodNotAllowedCode::tryFrom($error['Code']);
                    if ($code !== null) {
                        $exception = MethodNotAllowedException::make(
                            $code,
                            $error['Message'],
                            $exception,
                        );
                    }
                }
            }
        }

        if ($exception !== null) {
            throw $exception;
        }
    }

    /**
     * If a method not allowed response is return, this function will try
     * to generate a specific exception for it and throw it. If this doesn't
     * throw, generic error handling should be used.
     * 
     * @throws BadRequestException
     */
    protected function handleBadRequest(
        ResponseInterface $response
    ): void {
        $exception = null;
        $body = json_decode($response->getBody()->getContents(), true);

        if (
            is_array($body)
            && array_key_exists('errors', $body)
            && is_array($body['errors'])
        ) {
            foreach ($body['errors'] as $error) {
                if (
                    is_array($error)
                    && array_key_exists('Code', $error)
                    && array_key_exists('Message', $error)
                ) {
                    $code = BadRequestCode::tryFrom($error['Code']);
                    if ($code !== null) {
                        $exception = BadRequestException::make(
                            $code,
                            $error['Message'],
                            $exception,
                        );
                    }
                }
            }
        }

        if ($exception !== null) {
            throw $exception;
        }
    }

    /**
     * Returns a generic error.
     * 
     * @throws CallException
     * @throws InternalErrorException
     */
    protected function getGenericError(ResponseInterface $response): Throwable
    {
        $body = json_decode($response->getBody()->getContents(), true);

        if (
            is_array($body)
            && array_key_exists('message', $body)
            && array_key_exists('errors', $body)
            && is_array($body['errors'])
        ) {
            return new CallException(
                $body['message'],
                array_map(
                    fn(array $err) => $err['message'],
                    $body['errors']
                )
            );
        }

        return new InternalErrorException(
            $response->getBody()->getContents(),
            $response->getStatusCode(),
        );
    }
}
