<?php

declare(strict_types=1);

namespace Worksnaps\SDK\Core\Response;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;
use Worksnaps\SDK\Core\Exceptions\BaseException;
use Worksnaps\SDK\Core\Response\DTO;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class Response
 *
 * @package Worksnaps\SDK\Core\Response
 */
class Response
{
    /**
     * @var ResponseInterface
     */
    protected $httpResponse;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var  DTO\ResponseData|null
     */
    protected $responseData;

    /**
     * Response constructor.
     *
     * @param ResponseInterface $httpResponse
     * @param LoggerInterface   $logger
     */
    public function __construct(ResponseInterface $httpResponse, LoggerInterface $logger)
    {
        $this->httpResponse = $httpResponse;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse(): ResponseInterface
    {
        return $this->httpResponse;
    }

    /**
     * @return DTO\ResponseData
     * @throws BaseException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getResponseData(): DTO\ResponseData
    {
        $this->logger->debug('getResponseData.start');
        if ($this->responseData === null) {
            try {
                $xml = simplexml_load_string($this->httpResponse->getContent());
                $curlResult = json_encode($xml);
                $responseResult = json_decode($curlResult, true);
                $resultDto = new DTO\Result($responseResult);
                $this->responseData = new DTO\ResponseData(
                    $resultDto
                );
            } catch (Throwable $e) {
                $this->logger->error(
                    $e->getMessage(),
                    [
                        'response' => $this->httpResponse->getContent(false),
                    ]
                );
                throw new BaseException(sprintf('api request error: %s', $e->getMessage()), $e->getCode(), $e);
            }
        }
        $this->logger->debug('getResponseData.finish');

        return $this->responseData;
    }
    public static function notArray(&$val): void
    {
        if (!is_array(current($val))) {
            $l = $val;
            $val = [];
            $val[] = $l;
            unset($l);
            $val = array_filter($val);
        }
    }
}