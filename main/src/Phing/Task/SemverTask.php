<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use IOException;

/**
 * Class SemverTask
 */
class SemverTask extends AbstractTask
{
    /**
     * @var string
     */
    private string $string;

    /**
     * @var string
     */
    private string $version;

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
     * @param string $string
     */
    public function setString($string): void
    {
        $this->string = $string;
    }

    /**
     * @param string $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }

    /**
     * @param string $major
     */
    public function setMajor($major): void
    {
        $this->major = $major;
    }

    /**
     * @param string $minor
     */
    public function setMinor($minor): void
    {
        $this->minor = $minor;
    }

    /**
     * @param string $patch
     */
    public function setPatch($patch): void
    {
        $this->patch = $patch;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        if (!preg_match('#((\d{1,}).(\d{1,}).(\d{1,}))#', $this->string, $matches)) {
            throw new BuildException('version ist not in the correct format');
        }

        $this->getProject()->setProperty($this->version, $matches[1]);
        $this->getProject()->setProperty($this->major, $matches[2]);
        $this->getProject()->setProperty($this->minor, $matches[3]);
        $this->getProject()->setProperty($this->patch, $matches[4]);

        $this->cleanup();
    }
}
