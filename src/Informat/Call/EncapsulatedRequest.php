<?php

namespace Koba\Informat\Call;

use Koba\Informat\Exceptions\InternalErrorException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class EncapsulatedRequest
{
    public function __construct(
        protected RequestInterface $request,
        protected StreamFactoryInterface $streamFactory
    ) {
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param array<mixed>|string $body
     */
    public function withBody(array|string $body): self
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }

        if ($body === false) {
            throw new InternalErrorException('Invalid call content.');
        }

        $this->request = $this->request->withBody(
            $this->streamFactory->createStream($body)
        );

        return $this;
    }

    public function withVersion(string $version): self
    {
        $this->request = $this->request->withAddedHeader('Api-Version', $version);
        return $this;
    }
}
