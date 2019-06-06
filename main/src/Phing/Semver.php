<?php

namespace elnebuloso\Phing;

use BuildException;
use Exception;

/**
 * Class Semver
 */
class Semver extends AbstractTask
{
    /**
     * @var string
     */
    private $string;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $major;

    /**
     * @var string
     */
    private $minor;

    /**
     * @var string
     */
    private $patch;

    /**
     * @param string $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @param string $major
     */
    public function setMajor($major)
    {
        $this->major = $major;
    }

    /**
     * @param string $minor
     */
    public function setMinor($minor)
    {
        $this->minor = $minor;
    }

    /**
     * @param string $patch
     */
    public function setPatch($patch)
    {
        $this->patch = $patch;
    }

    /**
     * @throws BuildException
     * @throws Exception
     */
    public function main()
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
