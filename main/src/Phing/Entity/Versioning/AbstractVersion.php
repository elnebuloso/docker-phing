<?php

namespace elnebuloso\Phing\Entity\Versioning;

/**
 * Class AbstractVersion
 */
abstract class AbstractVersion
{
    /**
     * @var string
     */
    private string $major;

    /**
     * @var string
     */
    private string $minor;

    /**
     * @var string
     */
    private string $patch;

    /**
     * @return string
     */
    public function getMajor(): string
    {
        return $this->major;
    }

    /**
     * @param string $major
     */
    public function setMajor(string $major): void
    {
        $this->major = $major;
    }

    /**
     * @return string
     */
    public function getMinor(): string
    {
        return $this->minor;
    }

    /**
     * @param string $minor
     */
    public function setMinor(string $minor): void
    {
        $this->minor = $minor;
    }

    /**
     * @return string
     */
    public function getPatch(): string
    {
        return $this->patch;
    }

    /**
     * @param string $patch
     */
    public function setPatch(string $patch): void
    {
        $this->patch = $patch;
    }
}
