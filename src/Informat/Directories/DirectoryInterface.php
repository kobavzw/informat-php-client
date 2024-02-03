<?php

namespace Koba\Informat\Directories;

use Koba\Informat\Call\CallProcessor;
use Koba\Informat\Call\UrlBuilderInterface;

interface DirectoryInterface
{
    public function getCallProcessor(): CallProcessor;
    public function getUrlBuilder(): UrlBuilderInterface;
}