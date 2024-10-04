<?php

namespace Koba\Informat\Helpers;

use Exception;
use Koba\Informat\Exceptions\InternalErrorException;

class File
{
    protected function __construct(
        protected string $name,
        protected string $contents,
    ) {}

    /**
     * Creates a new file object, given the name of the file and the base64
     * encoded contents of the file.
     */
    public static function make(string $name, string $contents): self
    {
        return new self($name, $contents);
    }

    /**
     * Reads the contents of the given path and creates a file object from it.
     */
    public static function makeForPath(string $path): self
    {
        $contents = file_get_contents($path);
        if (false === $contents) {
            throw new InternalErrorException('File could not be read.');
        }

        return new self(basename($path), base64_encode($contents));
    }

    /**
     * Sets the name of the file.
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the content (base64 encoded) of the file.
     */
    public function setContents(string $contents): self
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * Returns the filename.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the contents of the file (base64 encoded).
     */
    public function getContents(): string
    {
        return $this->contents;
    }
}
