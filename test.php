<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;
use Worksnaps\SDK\Core\Collection\CollectionFactory;
use Worksnaps\SDK\Core\Response\Response;
use Worksnaps\SDK\Services\Model\TimeEntry\TimeEntry;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));

$client = HttpClient::create(['http_version' => '2.0']);
$traceableClient = new \Symfony\Component\HttpClient\TraceableHttpClient($client);
$traceableClient->setLogger($log);
$ssl=true;
$my = '*****';
$dp = '*****';

$token = new \Worksnaps\SDK\Core\Credentials\AccessToken(
    $dp
);

$credentials = \Worksnaps\SDK\Core\Credentials\Credentials::createForAuth($token,$ssl);

try {
    $apiClient = new \Worksnaps\SDK\Core\ApiClient($credentials, $traceableClient, $log);

   $app = new \Worksnaps\SDK\Services\Main($apiClient, $log);

    $log->debug('================================');

    // api call with expired access token

    $result=[];

    $class='projects';
//    $timeReport = new \Worksnaps\SDK\Core\Collection\Collection('Worksnaps\SDK\Services\Model\TimeEntry\LineItem');
//    $p = new \Worksnaps\SDK\Services\Model\Project\Project(73986);
//    $report = new \Worksnaps\SDK\Services\Model\Project\Report($p);
//    $report->setFromTimestamp(new DateTimeImmutable('2020-09-01 00:00:00'));
//    $report->setToTimestamp(new DateTimeImmutable('2020-10-01 00:00:00'));

    $res = $app->call($class,['METHOD'=>'getList','PARAMS'=>'']);

    $arResult = call_user_func("Worksnaps\\SDK\\Services\\Calls\\" . ucfirst($class) . '::returnData',$res);
    var_dump($arResult);

} catch (\Throwable $exception) {
    print(sprintf('error: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('class: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}