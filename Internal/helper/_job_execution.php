<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 19:57
 */

use Internal\Component\Job\Job;
use Internal\Component\Job\JobInterface;
use Internal\Shared\Artifacts;

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

if (!function_exists('artifacts')) {
    /**
     * アーティファクトを取得します。
     *
     * @return Artifacts
     */
    function artifacts(): Artifacts
    {
        return shared(Artifacts::class);
    }
}
