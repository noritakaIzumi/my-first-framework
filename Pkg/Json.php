<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/10/30
 * Time: 09:41
 */

namespace Pkg;

use JsonException;

class Json
{
    public static function marshal(mixed $value): string
    {
        try {
            $body = json_encode($value, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            $logger = logger();
            $logger->error('Json error occurred.');
            $logger->info($exception->getMessage());
            $body = '';
        }

        return $body;
    }
}
