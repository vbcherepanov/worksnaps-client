<?php

declare(strict_types=1);

namespace Worksnaps\SDK\Services;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Worksnaps\SDK\Core\ApiClient;
use Worksnaps\SDK\Core\Exceptions\BaseException;
use Worksnaps\SDK\Core\Exceptions\InvalidArgumentException;
use Worksnaps\SDK\Core\Response\Response;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class Main
 *
 * @package Worksnaps\SDK\Services
 */
class Main
{
    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * Main constructor.
     *
     * @param ApiClient                $apiClient
     * @param LoggerInterface          $log
     */
    public function __construct(ApiClient $apiClient,  LoggerInterface $log)
    {
        $this->apiClient = $apiClient;
        $this->log = $log;
    }

    /**
     * @param string $apiMethod
     * @param array  $parameters
     *
     * @return Response
     * @throws InvalidArgumentException
     * @throws TransportExceptionInterface
     * @throws BaseException
     */
    public function call(string $apiMethod, array $parameters = []): Response
    {
        $this->log->debug(
            'call.start',
            [
                'method'     => $apiMethod,
                'parameters' => $parameters,
            ]
        );

        // make async request
        $apiCallResult = $this->apiClient->getResponse($apiMethod, $parameters);
        $response = null;


        switch ($apiCallResult->getStatusCode()) {
            case StatusCodeInterface::STATUS_OK:
            case StatusCodeInterface::STATUS_CREATED:
                //todo check with empty response size from server
                $response = new Response($apiCallResult, $this->log);
                break;
            case StatusCodeInterface::STATUS_UNAUTHORIZED:
                $this->log->notice(
                    'The user did not provide a valid authentication token',[]
                );
                throw new BaseException('The user did not provide a valid authentication token');
            case StatusCodeInterface::STATUS_BAD_REQUEST:
                $this->log->notice(
                    'The request could not be understood due to malformed syntax or incorrect parameters',[]
                );
                throw new BaseException('The request could not be understood due to malformed syntax or incorrect parameters');
            case StatusCodeInterface::STATUS_FORBIDDEN:
                $this->log->notice(
                    'he user is not allowed to perform the operation',[]
                );
                throw new BaseException('he user is not allowed to perform the operation');
            case StatusCodeInterface::STATUS_NOT_FOUND:
                $this->log->notice(
                    'The requested resource is not found',[]
                );
                throw new BaseException('The requested resource is not found');
            case StatusCodeInterface::STATUS_CONFLICT:
                $this->log->notice(
                    'The request is valid but the object cannot be created (for example, due to duplicated unique key)',[]
                );
                throw new BaseException('The request is valid but the object cannot be created (for example, due to duplicated unique key)');
            case StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR:
                $this->log->notice(
                    'The server encounters an error when processing the request',[]
                );
                throw new BaseException('The server encounters an error when processing the request');
        }
        $this->log->debug('call.finish');

        return $response;
    }
}