<?php
declare(strict_types=1);

namespace Worksnaps\SDK\Services\Model\UserAssignment;


class UserAssignment
{
    /**
     * $var int $id
     */
    protected $id;
    /**
     * @var string $projectId
     */
    protected $projectId;
    /**
     * @var string $userId
     */
    protected $userId;
    /**
     * @var string $role
     */
    protected $role;
    /**
     * @var string $flagAllowLoggingTime
     */
    protected $flagAllowLoggingTime;
    /**
     * @var string $windowForAddingOfflineTime
     */
    protected $windowForAddingOfflineTime;

    /**
     * @var string $windowForDeletingTime
     */
    protected $windowForDeletingTime;

    /**
     * @var string $userFirstName
     */
    protected $userFirstName;
    /**
     * @var string $userLastName
     */
    protected $userLastName;
    /**
     * @var string $userName
     */
    protected $userName;
    /**
     * @var string $userEmail
     */
    protected $userEmail;
    /**
     * @var string $hourlyRate
     */
    protected $hourlyRate;

    /**
     * UserAssignment constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getFlagAllowLoggingTime(): string
    {
        return $this->flagAllowLoggingTime;
    }

    /**
     * @param string $flagAllowLoggingTime
     */
    public function setFlagAllowLoggingTime(string $flagAllowLoggingTime): void
    {
        $this->flagAllowLoggingTime = $flagAllowLoggingTime;
    }

    /**
     * @return string
     */
    public function getWindowForAddingOfflineTime(): string
    {
        return $this->windowForAddingOfflineTime;
    }

    /**
     * @param string $windowForAddingOfflineTime
     */
    public function setWindowForAddingOfflineTime(string $windowForAddingOfflineTime): void
    {
        $this->windowForAddingOfflineTime = $windowForAddingOfflineTime;
    }

    /**
     * @return string
     */
    public function getUserFirstName(): string
    {
        return $this->userFirstName;
    }

    /**
     * @param string $userFirstName
     */
    public function setUserFirstName(string $userFirstName): void
    {
        $this->userFirstName = $userFirstName;
    }

    /**
     * @return string
     */
    public function getUserLastName(): string
    {
        return $this->userLastName;
    }

    /**
     * @param string $userLastName
     */
    public function setUserLastName(string $userLastName): void
    {
        $this->userLastName = $userLastName;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    /**
     * @param string $userEmail
     */
    public function setUserEmail(string $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getHourlyRate(): string
    {
        return $this->hourlyRate;
    }

    /**
     * @param string $hourlyRate
     */
    public function setHourlyRate(string $hourlyRate): void
    {
        $this->hourlyRate = $hourlyRate;
    }

    /**
     * @return string
     */
    public function getWindowForDeletingTime(): string
    {
        return $this->windowForDeletingTime;
    }

    /**
     * @param string $windowForDeletingTime
     */
    public function setWindowForDeletingTime(string $windowForDeletingTime): void
    {
        $this->windowForDeletingTime = $windowForDeletingTime;
    }

}