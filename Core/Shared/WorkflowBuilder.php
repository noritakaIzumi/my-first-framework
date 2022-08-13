<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/08/09
 * Time: 06:34
 */

namespace Core\Shared;

use Core\Component\AbstractJob;
use Core\Component\MatchedPath;
use Core\Component\Workflow;
use Core\Factory\ComponentFactory;

class WorkflowBuilder
{
    public function build(MatchedPath $matchedPath): Workflow
    {
        /** @var Workflow $workflow */
        $workflow = ComponentFactory::getInstance(Workflow::class);
        $workflow->firstArguments = $matchedPath->firstArguments;

        while (true) {
            $callback = array_pop($matchedPath->callbacks);
            if ($callback === null) {
                break;
            }

            $_job = match (true) {
                $callback instanceof AbstractJob => $callback,
                is_callable($callback) => new class($callback) extends AbstractJob {
                    public function execute(array $artifacts, ...$args): array
                    {
                        if ($this->func === null) {
                            return [];
                        }

                        return call_user_func($this->func, $artifacts, ...$args);
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
