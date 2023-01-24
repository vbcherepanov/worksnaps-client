<?php

declare(strict_types=1);

namespace Worksnaps\SDK\Core;

use Bitrix\Main\Service\GeoIp\Data;
use Worksnaps\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Worksnaps\SDK\Core\Request\DataRequest;

/**
 * Class ApiClient
 *
 * @package Worksnaps\SDK\Core
 */
class ApiClient
{
    /**
     * @var HttpClientInterface
     */
    protected $client;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var Credentials\Credentials
     */
    protected $credentials;
    /**
     * @const string
     */
    protected const SSL_ON = 'https';
    protected const SSL_OFF = 'http';

    protected const API_WORKSNAPS_COM_API = 'api.worksnaps.com/api';
    /**
     * @const string
     */
    protected const SDK_VERSION = '2.0';

    /**
     * ApiClient constructor.
     *
     * @param Credentials\Credentials $credentials
     * @param HttpClientInterface $client
     * @param LoggerInterface $logger
     */
    public function __construct(Credentials\Credentials $credentials, HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->credentials = $credentials;
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @return Credentials\Credentials
     */
    public function getCredentials(): Credentials\Credentials
    {
        return $this->credentials;
    }

    public function getUrl(string $className, array $parameters = []): DataRequest
    {
        $ssl    = $this->getCredentials()->isSsl();
        $url = sprintf('%s://%s/', $ssl ? self::SSL_ON : self::SSL_OFF,self::API_WORKSNAPS_COM_API);
        /**
         * @var DataRequest $dtRequest
         */
        $dtRequest =call_user_func("Worksnaps\\SDK\\Services\\Calls\\".ucfirst($className).'::'.$parameters['METHOD'],$parameters['PARAMS']);
        $url = $url.$dtRequest->getUrl();
        $dtRequest->setUrl($url);
        return $dtRequest;
    }

    /**
     * @param string $apiMethod
     * @param array $parameters
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */

    public function getResponse(string $apiMethod, array $parameters = []): ResponseInterface
    {
        $this->logger->debug(
            sprintf('getResponse.start %s', $apiMethod),
            [
                'parameters' => $parameters,
            ]
        );
        /**
         * @var DataRequest $dataRequest
         */
        $dataRequest = $this->getUrl($apiMethod,$parameters);

        if ($this->getCredentials()->getAccessToken() === null) {
            throw new InvalidArgumentException(sprintf('access token in credentials not found'));
        }

        $requestOptions = [
            'auth_basic'=>[$this->getCredentials()->getAccessToken()->getAccessToken(),'ignored'],
            'headers'=> [
                'Content-Type'=>'application/xml',
            ],
            'body'=>$dataRequest->getBody()
        ];
        $response = $this->client->request($dataRequest->getMethod(), $dataRequest->getUrl(), $requestOptions);

        $this->logger->debug(
            sprintf('getResponse.end %s', $apiMethod),
            [
                'responseInfo' => $response->getInfo(),
            ]
        );

        return $response;
    }
}
