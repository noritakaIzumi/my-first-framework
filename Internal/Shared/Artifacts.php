<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/10/30
 * Time: 09:58
 */

namespace Internal\Shared;

use Internal\Component\Artifact;

class Artifacts
{
    /**
     * @var Artifact[]
     */
    protected static array $artifacts = [];

    public function getArtifact(string $name): Artifact
    {
        if (!isset(self::$artifacts[$name])) {
            self::$artifacts[$name] = component(Artifact::class);
        }

        return self::$artifacts[$name];
    }
}
