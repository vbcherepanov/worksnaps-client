<?php
declare(strict_types=1);

namespace Worksnaps\SDK\Services\Calls;


use Worksnaps\SDK\Core\Request\DataRequest;
use Worksnaps\SDK\Services\Model\Project\Report;
use Worksnaps\SDK\Services\Model\TimeEntry\LineItem;

class Summary
{

    const URL = 'projects';
    const EXT = '.xml';
    const ALL = 'GET';
    const CREATE = 'POST';
    const GET_ONE = 'GET';
    const UPDATE = 'PUT';
    const DELETE = 'DELETE';
    const REPORTS = 'time_entry';


    public static function reports(Report $report): DataRequest
    {
        $uri = "summary_reports.xml?" . $report->getSummaryParams();
        print_r($uri);
        return new DataRequest(self::ALL,$uri,'');
    }

    public static function returnData($item):LineItem
    {
        $tU = new LineItem();
        if(array_key_exists('user_id',$item))
            $tU->setUserId($item['user_id']);
        if(array_key_exists('user_name',$item))
            $tU->setUserName($item['user_name']);
        $tU->setProjectId($item['project_id']);
        $tU->setProjectName($item['project_name']);
        $tU->setDurationInMinutes($item['duration_in_minutes']);
        $tU->setType($item['type']);
        $tU->setTaskId($item['task_id']);
        $tU->setTaskName($item['task_name']);
        return $tU;
    }
    public static function returnCsvData($item):string
    {
        return implode(";",$item);
    }
}