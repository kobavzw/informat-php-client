<?php

namespace Koba\Informat\Call;

use Koba\Informat\Exceptions\InternalErrorException;

class MultipartBody
{
    /**
     * @var array<int,array{name:string,contents:string,filename:null|string,contentType:null|string}>
     */
    protected array $parts = [];

    protected string $boundary;

    public function __construct(?string $boundary = null)
    {
        $this->boundary = $boundary ?? bin2hex(random_bytes(16));
    }

    /**
     * @param array<mixed>|string $contents
     */
    public function addJsonPart(string $name, array|string $contents, ?string $filename = null): self
    {
        if (is_array($contents)) {
            $contents = json_encode($contents);
        }

        if ($contents === false) {
            throw new InternalErrorException('Invalid multipart JSON content.');
        }

        return $this->addPart($name, $contents, $filename, 'application/json');
    }

    public function addFilePart(
        string $name,
        string $contents,
        string $filename,
        string $contentType = 'application/octet-stream',
    ): self {
        return $this->addPart($name, $contents, $filename, $contentType);
    }

    public function addFieldPart(string $name, string $contents): self
    {
        return $this->addPart($name, $contents);
    }

    public function getContentType(): string
    {
        return 'multipart/form-data; boundary=' . $this->boundary;
    }

    public function toString(): string
    {
        $body = '';

        foreach ($this->parts as $part) {
            $body .= "--{$this->boundary}\r\n";
            $body .= 'Content-Disposition: form-data; name="'
                . $this->escapeHeaderValue($part['name']) . '"';

            if ($part['filename'] !== null) {
                $body .= '; filename="' . $this->escapeHeaderValue($part['filename']) . '"';
            }

            $body .= "\r\n";

            if ($part['contentType'] !== null) {
                $body .= "Content-Type: {$part['contentType']}\r\n";
            }

            $body .= "\r\n{$part['contents']}\r\n";
        }

        return $body . "--{$this->boundary}--\r\n";
    }

    protected function addPart(
        string $name,
        string $contents,
        ?string $filename = null,
        ?string $contentType = null,
    ): self {
        $this->parts[] = [
            'name' => $name,
            'contents' => $contents,
            'filename' => $filename,
            'contentType' => $contentType,
        ];

        return $this;
    }

    protected function escapeHeaderValue(string $value): string
    {
        return str_replace(['\\', '"'], ['\\\\', '\"'], $value);
    }
}
