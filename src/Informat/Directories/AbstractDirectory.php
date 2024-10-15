<?php

namespace Koba\Informat\Directories;

use BackedEnum;
use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\UrlBuilder;
use Koba\Informat\Call\UrlBuilderInterface;
use Koba\Informat\Contracts\HasDescriptionInterface;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\BaseUrl;

abstract class AbstractDirectory implements DirectoryInterface
{
    protected UrlBuilderInterface $urlBuilder;
    protected CallProcessor $callProcessor;

    public function __construct(CallProcessor $callProcessor)
    {
        $this->callProcessor = clone $callProcessor;
        $this->callProcessor->setErrorCodes(static::getErrorCodes());
        $this->urlBuilder = new UrlBuilder($this->getBaseUrl());
    }

    public function getCallProcessor(): CallProcessor
    {
        return $this->callProcessor;
    }

    public function getUrlBuilder(): UrlBuilderInterface
    {
        return $this->urlBuilder;
    }

    abstract protected function getBaseUrl(): BaseUrl;

    /**
     * Geeft de geldige, bekende error codes voor deze directory.
     * 
     * @return null|class-string<BackedEnum&HasDescriptionInterface>
     */
    protected static function getErrorCodes(): null|string
    {
        return null;
    }
}
