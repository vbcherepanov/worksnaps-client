<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\TraceableHttpClient;
use Worksnaps\SDK\Core\ApiClient;
use Worksnaps\SDK\Core\Credentials\AccessToken;
use Worksnaps\SDK\Core\Credentials\Credentials;
use Worksnaps\SDK\Core\Response\Response;
use Worksnaps\SDK\Services\Main;
use Worksnaps\SDK\Services\Model\Project\Project;
use Worksnaps\SDK\Services\Model\Project\Report;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));

$client = HttpClient::create(['http_version' => '2.0']);
$traceableClient = new TraceableHttpClient($client);
$traceableClient->setLogger($log);
$ssl=true;
$my = '******';
$dp = '******';

$token = new AccessToken(
    $dp
);

$credentials = Credentials::createForAuth($token,$ssl);

try {
    $apiClient = new ApiClient($credentials, $traceableClient, $log);

$startDate=new \DateTimeImmutable();
    $app = new Main($apiClient, $log);
    $file = fopen('report.txt','a+');
    fwrite($file,$startDate->format('"Y-m-d H:i:s'));
    $log->debug('================================');

    $class='summary';
    $collection = new \Worksnaps\SDK\Core\Collection\Collection('');
    $p = new Project($collection);
    $report = new Report($p);
    $data = date_period_grid('2019-01-01', '2020-11-11');
    foreach($data as $dt){
        $result=[];
        $report->setFromTimestamp(new DateTimeImmutable($dt['start']));
        $report->setToTimestamp(new DateTimeImmutable($dt['end']));
        $res = $app->call($class,['METHOD'=>'reports','PARAMS'=>$report]);

        $arResult = $res->getResponseData()->getResult()->getResultData();

        if(array_key_exists('manager_report',$arResult)) {
            $arResult = $arResult['manager_report'];
        }

        if(array_key_exists('status',$arResult) && count($arResult)==1){
            unset($arResult['status']);
        }
        Response::notArray($arResult);
        if(count($arResult)>0) {
            foreach ($arResult as $item) {
                fwrite($file,print_r($item,true));
            }
        }
        echo $dt['start'].'-'.$dt['end'].PHP_EOL;
        sleep(1);
    }
    $endDate = new \DateTimeImmutable();
    fwrite($file,$endDate->format('"Y-m-d H:i:s'));
fclose($file);
} catch (\Throwable $exception) {
    print(sprintf('error: %s', $exception->getMessage()) . PHP_EOL);
    print(sprintf('class: %s', get_class($exception)) . PHP_EOL);
    print(sprintf('trace: %s', $exception->getTraceAsString()) . PHP_EOL);
}






function date_period_grid($start, $end)
{
    try {
        $start = new \DateTimeImmutable($start);
    } catch (Exception $e) {
    }
    try {
        $end = new \DateTimeImmutable($end);
    } catch (Exception $e) {
    }

    $result=[];
    $sum = $start;
    while($sum!=$end){
        $years = $sum->format("Y");
        $month = $sum->format("m");
        $day = $sum->format('Y-m-d');
        $result[$years][$month][]=$day;
        $sum=$sum->add(new DateInterval('P1D'));
    }
    $return=[];
    foreach($result as $years=>$months)
        foreach($months as $month=>$d){
            $return[]=['start'=>$d[0],'end'=>$d[count($d)-1]];
        }

    return $return;
}