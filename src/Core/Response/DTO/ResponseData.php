<?php

declare(strict_types=1);

namespace Worksnaps\SDK\Core\Response\DTO;

/**
 * Class ResponseData
 *
 * @package Worksnaps\SDK\Core\Response\DTO
 */
class ResponseData
{
    /**
     * @var Result
     */
    protected $result;


    /**
     * Response constructor.
     *
     * @param Result $result
     */
    public function __construct(Result $result)
    {
        $this->result = $result;
    }


    /**
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->result;
    }
}