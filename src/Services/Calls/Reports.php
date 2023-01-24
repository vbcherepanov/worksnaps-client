<?php
declare(strict_types=1);

namespace Worksnaps\SDK\Services\Calls;


use Worksnaps\SDK\Core\Request\DataRequest;
use Worksnaps\SDK\Services\Model\Project\Report;
use Worksnaps\SDK\Services\Model\TimeEntry\TimeEntry;

class Reports
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
        $uri = "projects/{$report->getProjectId()}/reports?" . $report->getParams();
        print_r($uri);
        return new DataRequest(self::ALL,$uri,'');
    }

    public static function returnData($item):TimeEntry
    {
        $tU = new TimeEntry();
        $tU->setId($item['id']);
        $tU->setLoggedTimestamp($item['logged_timestamp']);
        $tU->setFromTimestamp($item['from_timestamp']);
        $tU->setDurationInMinutes($item['duration_in_minutes']);
        $tU->setType($item['type']);
        $tU->setProjectId($item['project_id']);
        $tU->setUserId($item['user_id']);
        $tU->setTaskId($item['task_id']);
        $tU->setTaskName($item['task_name']);
        $tU->setUserComment((string) (is_array($item['user_comment']) ? current($item['user_comment']) : $item['user_comment']));
        $tU->setUserIp($item['user_ip']);
        $tU->setThumbnailUrl($item['thumbnail_url']);
        $tU->setFullResolutionUrl($item['full_resolution_url']);
        $tU->setActivityLevel($item['activity_level']);
        return $tU;
    }

}