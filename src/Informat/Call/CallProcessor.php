<?php

namespace Koba\Informat\Call;

use BackedEnum;
use Koba\Informat\AccessToken\AccessTokenManagerInterface;
use Koba\Informat\Contracts\HasDescriptionInterface;
use Koba\Informat\Enums\HttpMethod;
use Koba\Informat\Exceptions\KnownErrorException;
use Koba\Informat\Exceptions\NotFoundException;
use Koba\Informat\Exceptions\UnknownErrorException;
use Koba\Informat\Helpers\InstituteNumber;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

class CallProcessor
{
    /**
     * @var null|class-string<BackedEnum&HasDescriptionInterface> $errorCodes
     */
    protected ?string $errorCodes;

    public function __construct(
        protected AccessTokenManagerInterface $accessTokenManager,
        protected ClientInterface $httpClient,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * Stelt de geldige error codes voor de calls.
     * 
     * @param null|class-string<BackedEnum&HasDescriptionInterface> $codes
     */
    public function setErrorCodes(?string $codes): self
    {
        $this->errorCodes = $codes;
        return $this;
    }

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
     * @throws KnownErrorException
     * @throws UnknownErrorException
     * @throws NotFoundException
     */
    public function send(EncapsulatedRequest $request): ResponseInterface
    {
        $response = $this->httpClient->sendRequest($request->getRequest());
        
        if ($response->getStatusCode() === 200) {
            return $response;
        }

        $this->handleErrorCodes($response);

        if ($response->getStatusCode() === 404) {
            throw new NotFoundException;
        }

        throw $this->getGenericError($response);
    }

    /**
     * This function will try to map the error codes in the response to an
     * exception.
     * 
     * @throws KnownErrorException
     */
    public function handleErrorCodes(ResponseInterface $response): void
    {
        if ($this->errorCodes === null) {
            return;
        }

        $body = json_decode($response->getBody()->getContents(), true);
        if (false === is_array($body)) {
            return;
        }

        $exception = null;
        $body = array_change_key_case($body, CASE_LOWER);
        if (
            array_key_exists('errors', $body)
            && is_array($body['errors'])
        ) {
            foreach($body['errors'] as $error) {
                if (false === is_array($error)) {
                    continue;
                }

                $error = array_change_key_case($error, CASE_LOWER);
                if (
                    array_key_exists('code', $error)
                    && array_key_exists('message', $error)
                ) {
                    $code = $this->errorCodes::tryFrom($error['code']);
                    if ($code !== null) {
                        $exception = KnownErrorException::make(
                            $code,
                            $error['message'],
                            $response->getStatusCode(),
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
     */
    protected function getGenericError(ResponseInterface $response): Throwable
    {
        return new UnknownErrorException(
            $response->getBody()->getContents(),
            $response->getStatusCode(),
        );
    }
}
