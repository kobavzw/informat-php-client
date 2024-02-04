<?php

namespace Koba\Informat\Helpers;

use JsonMapper\JsonMapperFactory;
use JsonMapper\JsonMapperInterface;
use Koba\Informat\Exceptions\InternalErrorException;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class JsonMapper
{
    protected JsonMapperInterface $mapper;

    public function __construct()
    {
        $this->mapper = (new JsonMapperFactory())->bestFit();
    }

    /**
     * @template T of object
     * @param ResponseInterface $content
     * @param string $property
     * @param class-string<T> $targetClass
     * @return T
     */
    public function mapProperty(ResponseInterface $content, string $property, string $targetClass)
    {
        $decoded = json_decode($content->getBody()->getContents());
        if (is_object($decoded) && property_exists($decoded, $property)) {
            return $this->mapper->mapToClass(
                $decoded->{$property},
                $targetClass
            );
        }

        throw new InternalErrorException('Invalid JSON property requested.');
    }

    /**
     * @template T of object
     * @param ResponseInterface $content
     * @param string $property
     * @param class-string<T> $targetClass
     * @return T[]
     */
    public function mapPropertyArray(ResponseInterface $content, string $property, string $targetClass)
    {
        $decoded = json_decode($content->getBody()->getContents());
        if (is_object($decoded) && property_exists($decoded, $property)) {
            return $this->mapper->mapToClassArray(
                $decoded->{$property},
                $targetClass
            );
        }

        throw new InternalErrorException('Invalid JSON property requested.');
    }

    /**
     * @template T of object
     * @param ResponseInterface $content
     * @param class-string<T> $targetClass
     * @return T
     */
    public function mapObject(ResponseInterface $content, string $targetClass)
    {
        $decoded = json_decode($content->getBody()->getContents());
        if ($decoded instanceof stdClass) {
            return $this->mapper->mapToClass($decoded, $targetClass);
        }

        throw new InternalErrorException('Invalid input provided.');
    }

    /**
     * @template T of object
     * @param ResponseInterface $content
     * @param class-string<T> $targetClass
     * @return T[]
     */
    public function mapArray(ResponseInterface $content, string $targetClass)
    {
        $decoded = json_decode($content->getBody()->getContents());
        if (is_array($decoded)) {
            return $this->mapper->mapToClassArray($decoded, $targetClass);
        }

        throw new InternalErrorException('Invalid input provided.');
    }
}
