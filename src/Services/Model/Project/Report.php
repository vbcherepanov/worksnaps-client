<?php
declare(strict_types=1);

namespace Worksnaps\SDK\Services\Model\Project;


class Report
{
    /**
     * @var int
     */
    protected $projectId;
    /**
     * @var \DateTimeImmutable
     */
    protected $from_timestamp;

    /**
     * @var \DateTimeImmutable
     */
    protected $to_timestamp;

    /**
     * @var array
     */
    protected $userIds;
    /**
     * @var array
     */
    protected $taskIds;
    /**
     * @var string
     */
    protected $timeEntityType;
    /**
     * @var string
     */
    protected $name;

    public function __construct(Project $project)
    {
        $this->projectId = $project->getId();
        $this->userIds = [];
        $this->taskIds = [];
        $this->timeEntityType = '';
        $this->name = 'time_entries';
    }

    /**
     * @param \DateTimeImmutable $from_timestamp
     */
    public function setFromTimestamp(\DateTimeImmutable $from_timestamp): void
    {
        $this->from_timestamp = $from_timestamp;
    }

    /**
     * @param \DateTimeImmutable $to_timestamp
     */
    public function setToTimestamp(\DateTimeImmutable $to_timestamp): void
    {
        $this->to_timestamp = $to_timestamp;
    }

    public function setUser(int $userId): void
    {
        if(!in_array($userId,$this->userIds))
            $this->userIds[] = $userId;
    }

    /**
     * @param int $task_ids
     */
    public function setTask(int $task_ids): void
    {
        $this->taskIds[] = $task_ids;
    }

    /**
     * @param string $time_entry_type
     */
    public function setTimeEntryType(string $time_entry_type): void
    {
        $this->timeEntityType = $time_entry_type;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getParams(): string
    {
        $params = [
            'from_timestamp' => $this->from_timestamp->getTimestamp(),
            'to_timestamp' => $this->to_timestamp->getTimestamp(),
            'user_ids' => implode(";",$this->userIds),
            'task_ids' => implode(";",$this->taskIds),
            'name' => $this->name,
            'time_entry_type' =>$this->timeEntityType,
        ];
        $params = array_filter($params);
        return http_build_query($params);
    }
    public function getSummaryParams(): string
    {
        $params = [
            'from_date' => $this->from_timestamp->format('Y-m-d'),
            'to_date' => $this->to_timestamp->format('Y-m-d'),
            'timezone_offset' => '',
            'name' => 'manager_report',
            'project_ids'=>'',
        ];
        if(count($this->userIds)>0){
            $params['user_ids'] = implode(";",$this->userIds);
        }
        $params = array_filter($params);
        return http_build_query($params);
    }

}