<?php

namespace elnebuloso\Phing\Entity\Versioning;

/**
 * Interface Version
 */
interface Version
{
    /**
     * @return string
     */
    public function getMajor(): string;

    /**
     * @return string
     */
    public function getMinor(): string;

    /**
     * @return string
     */
    public function getPatch(): string;
}
