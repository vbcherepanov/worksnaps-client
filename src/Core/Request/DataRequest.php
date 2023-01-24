<?php


namespace Worksnaps\SDK\Core\Request;


class DataRequest
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $body;

    public function __construct(string $method, string $url, string $body='')
    {
        $this->method=$method;
        $this->url = $url;
        $this->body = $body;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

}