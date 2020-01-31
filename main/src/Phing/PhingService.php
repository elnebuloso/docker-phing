<?php

namespace elnebuloso\Phing;

/**
 * Class PhingService
 */
final class PhingService
{
    /**
     * @param $input
     *
     * @return string
     */
    public static function camelCaseToUnderscore($input)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
