<?php
declare(strict_types=1);

namespace Worksnaps\SDK\Services\Calls;


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Worksnaps\SDK\Core\Collection\Collection;
use Worksnaps\SDK\Core\Exceptions\BaseException;
use Worksnaps\SDK\Core\Request\DataRequest;
use Worksnaps\SDK\Core\Response\Response;
use Worksnaps\SDK\Services\Model\Project\Project as Proj;
use Worksnaps\SDK\Services\Model\UserAssignment\UserAssignment;

class Projects
{
    const URL = 'projects';
    const EXT = '.xml';
    const ALL = 'GET';
    const CREATE = 'POST';
    const GET_ONE = 'GET';
    const UPDATE = 'PUT';
    const DELETE = 'DELETE';

    /**
     * @var Collection $projectUserAssign
     */
    protected static $projectUserAssign;

    public static  function getList(bool $includeUserAssignment = false):DataRequest
    {
        $url =self::URL.self::EXT;
        if ($includeUserAssignment)
            $url .= "?include_user_assignment=1";

        return new DataRequest(self::ALL,$url);
    }

    public static function create(Proj $project): DataRequest
    {
        $body = '<project>';
        $body .= "<name>{$project->getName()}</name>";
        $body .= "<description>{$project->getDescription()}</description>";
        $body .= "</project>";
        return new DataRequest(self::CREATE,self::URL.self::EXT,$body);
    }

    public static function getById(Proj $project, bool $includeUserAssigment = false): DataRequest
    {
        $uri = self::URL . "/{$project->getId()}" . self::EXT;
        if ($includeUserAssigment) {
            $uri .= "?include_user_assignment=1";
        }
        return new DataRequest(self::GET_ONE,$uri,'');
    }

    public static function update(Proj $project): DataRequest
    {
        $body = '<project>';
        $body .= "<name>{$project->getName()}</name>";
        $body .= "<description>{$project->getDescription()}</description>";
        $body .= "</project>";
        $uri = self::URL . "/{$project->getId()}" . self::EXT;

        return new DataRequest(self::UPDATE,$uri,$body);
    }

    public static function delete(Proj $project): DataRequest
    {
        $uri = self::URL . "/{$project->getId()}" . self::EXT;
        return new DataRequest(self::DELETE,$uri,'');
    }

    public static function returnData(Response $response):Collection
    {
        $collection = new Collection('Worksnaps\SDK\Services\Model\Project\Project');
        try {
            $arResult = $response->getResponseData()->getResult()->getResultData();
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        } catch (BaseException $e) {
        }
        if(array_key_exists('project',$arResult)) {
            $arResult = $arResult['project'];
        }
        if(array_key_exists('status',$arResult) && count($arResult)==1){
            unset($arResult['status']);
        }
        Response::notArray($arResult);
        if(count($arResult)>0) {
            self::$projectUserAssign = new Collection('Worksnaps\SDK\Services\Model\UserAssignment\UserAssignment');
            foreach ($arResult as $item) {
                self::$projectUserAssign->clear();
                /**
                 * @var string $description
                 */
                $description = is_array($item['description']) ? implode(" ",$item['description']) : $item['description'];
                if(array_key_exists('user_assignments',$item) && array_key_exists('user_assignment',$item['user_assignments'])){
                    foreach($item['user_assignments']['user_assignment'] as $ua) {
                        $userAssign = new UserAssignment();
                        $userAssign->setId((int)$ua['id']);
                        $userAssign->setProjectId($ua['project_id']);
                        $userAssign->setUserId($ua['user_id']);
                        $userAssign->setRole($ua['role']);
                        $userAssign->setFlagAllowLoggingTime($ua['flag_allow_logging_time']);
                        $userAssign->setWindowForAddingOfflineTime($ua['window_for_adding_offline_time']);
                        $userAssign->setWindowForDeletingTime($ua['window_for_deleting_time']);
                        $userAssign->setUserFirstName($ua['user_first_name']);
                        $userAssign->setUserLastName($ua['user_last_name']);
                        $userAssign->setUserName($ua['user_name']);
                        $userAssign->setUserEmail($ua['user_email']);
                        $userAssign->setHourlyRate($ua['hourly_rate']);
                        self::$projectUserAssign->add($userAssign);
                    }
                }
                $collection->add(
                    new Proj(
                        self::$projectUserAssign,
                        (int)$item['id'],
                        $item['name'],
                        $description,
                        $item['status'],
                    )
                );
                unset($description);
            }
        }
        return $collection;
    }
}