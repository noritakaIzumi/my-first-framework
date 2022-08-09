<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 06:34
 */

namespace Core;

class WorkflowBuilder
{
    public static function build(array $functions): Workflow
    {
        /** @var Workflow $workflow */
        $workflow = Factory::get(Workflow::class);

        while (true) {
            $function = array_pop($functions);
            if ($function === null) {
                break;
            }

            $job = Factory::get(Job::class, [$function]);
            $job->next = $workflow->head;
            $workflow->head = $job;
        }

        return $workflow;
    }
}
