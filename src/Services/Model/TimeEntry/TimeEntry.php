<?php
declare(strict_types=1);

namespace Worksnaps\SDK\Services\Model\TimeEntry;


class TimeEntry
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $loggedTimestamp;
    /**
     * @var string
     */
    protected $fromTimestamp;

    /**
     * @var string
     */
    protected $durationInMinutes;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $projectId;
    /**
     * @var string
     */
    protected $userId;
    /**
     * @var string
     */
    protected $taskId;
    /**
     * @var string
     */
    protected $taskName;
    /**
     * @var string
     */
    protected $userComment;
    /**
     * @var string
     */
    protected $userIp;
    /**
     * @var string
     */
    protected $thumbnailUrl;
    /**
     * @var string
     */
    protected $fullResolutionUrl;
    /**
     * @var string
     */
    protected $activityLevel;

    /**
     * TimeEntry constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLoggedTimestamp(): string
    {
        return $this->loggedTimestamp;
    }

    /**
     * @param string $loggedTimestamp
     */
    public function setLoggedTimestamp(string $loggedTimestamp): void
    {
        $this->loggedTimestamp = $loggedTimestamp;
    }

    /**
     * @return string
     */
    public function getFromTimestamp(): string
    {
        return $this->fromTimestamp;
    }

    /**
     * @param string $fromTimestamp
     */
    public function setFromTimestamp(string $fromTimestamp): void
    {
        $this->fromTimestamp = $fromTimestamp;
    }

    /**
     * @return string
     */
    public function getDurationInMinutes(): string
    {
        return $this->durationInMinutes;
    }

    /**
     * @param string $durationInMinutes
     */
    public function setDurationInMinutes(string $durationInMinutes): void
    {
        $this->durationInMinutes = $durationInMinutes;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getProjectId(): string
    {
        return $this->projectId;
    }

    /**
     * @param string $projectId
     */
    public function setProjectId(string $projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getTaskId(): string
    {
        return $this->taskId;
    }

    /**
     * @param string $taskId
     */
    public function setTaskId(string $taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @return string
     */
    public function getTaskName(): string
    {
        return $this->taskName;
    }

    /**
     * @param string $taskName
     */
    public function setTaskName(string $taskName): void
    {
        $this->taskName = $taskName;
    }

    /**
     * @return string
     */
    public function getUserComment(): string
    {
        return $this->userComment;
    }

    /**
     * @param string $userComment
     */
    public function setUserComment(string $userComment): void
    {
        $this->userComment = $userComment;
    }

    /**
     * @return string
     */
    public function getUserIp(): string
    {
        return $this->userIp;
    }

    /**
     * @param string $userIp
     */
    public function setUserIp(string $userIp): void
    {
        $this->userIp = $userIp;
    }

    /**
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        return $this->thumbnailUrl;
    }

    /**
     * @param string $thumbnailUrl
     */
    public function setThumbnailUrl(string $thumbnailUrl): void
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    /**
     * @return string
     */
    public function getFullResolutionUrl(): string
    {
        return $this->fullResolutionUrl;
    }

    /**
     * @param string $fullResolutionUrl
     */
    public function setFullResolutionUrl(string $fullResolutionUrl): void
    {
        $this->fullResolutionUrl = $fullResolutionUrl;
    }

    /**
     * @return string
     */
    public function getActivityLevel(): string
    {
        return $this->activityLevel;
    }

    /**
     * @param string $activityLevel
     */
    public function setActivityLevel(string $activityLevel): void
    {
        $this->activityLevel = $activityLevel;
    }



}