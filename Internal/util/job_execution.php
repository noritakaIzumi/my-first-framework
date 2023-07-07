<?php

use Internal\Component\Job\Job;
use Internal\Component\Job\JobInterface;

if (!function_exists('jobCreate')) {
    /**
     * @template _T
     *
     * @param class-string<_T> $jobClass
     *
     * @return _T
     */
    function jobCreate(string $jobClass = Job::class): JobInterface
    {
        if (!class_exists($jobClass)) {
            trigger_error("class $jobClass not exists", E_USER_ERROR);
        }

        $implements = class_implements($jobClass);
        if (!isset($implements[JobInterface::class])) {
            trigger_error("class $jobClass does not implement JobInterface", E_USER_ERROR);
        }

        /** @var JobInterface $job */
        $job = component($jobClass);

        return $job;
    }
}
