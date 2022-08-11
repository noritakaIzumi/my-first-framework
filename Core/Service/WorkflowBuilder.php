<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 06:34
 */

namespace Core\Service;

use Core\Component\AbstractJob;
use Core\Component\Workflow;
use Core\Factory\ComponentFactory;

class WorkflowBuilder
{
    public function build(array $jobs): Workflow
    {
        /** @var Workflow $workflow */
        $workflow = ComponentFactory::get(Workflow::class);

        while (true) {
            $job = array_pop($jobs);
            if ($job === null) {
                break;
            }

            $_job = match (true) {
                $job instanceof AbstractJob => $job,
                is_callable($job) => new class($job) extends AbstractJob {
                    public function execute(array $artifacts): array
                    {
                        if ($this->func === null) {
                            return [];
                        }

                        return call_user_func($this->func, $artifacts);
                    }
                },
                default => trigger_error('the component is not a job instance nor a callable', E_USER_ERROR),
            };

            $_job->next = $workflow->head;
            $workflow->head = $_job;
        }

        return $workflow;
    }
}
