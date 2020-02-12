<?php

namespace elnebuloso\Phing;

/**
 * Class PhingService
 */
final class PhingService
{
    /**
     * @param string $input
     * @return string
     */
    public static function camelCaseToUnderscore(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
