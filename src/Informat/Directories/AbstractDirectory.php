<?php

namespace Koba\Informat\Directories;

use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\UrlBuilder;
use Koba\Informat\Call\UrlBuilderInterface;
use Koba\Informat\Directories\DirectoryInterface;
use Koba\Informat\Enums\BaseUrl;

abstract class AbstractDirectory implements DirectoryInterface
{
    protected UrlBuilderInterface $urlBuilder;

    public function __construct(protected CallProcessor $callProcessor)
    {
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
}
