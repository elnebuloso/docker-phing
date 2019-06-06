<?php

namespace elnebuloso\Phing;

use BuildException;
use IOException;
use PhingFile;
use Task;

/**
 * Class AbstractTask
 */
abstract class AbstractTask extends Task
{
    /**
     * @var PhingFile
     */
    protected $dir;

    /**
     * @var string
     */
    protected $currentDir;

    /**
     * @param PhingFile $dir Working directory
     */
    public function setDir(PhingFile $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    protected function prepare()
    {
        if ($this->dir === null) {
            return;
        }

        // expand any symbolic links first
        if (!$this->dir->getCanonicalFile()->isDirectory()) {
            throw new BuildException("'" . (string) $this->dir . "' is not a valid directory");
        }

        $this->currentDir = getcwd();
        @chdir($this->dir->getPath());
    }

    /**
     * @return void
     */
    protected function cleanup()
    {
        if ($this->dir !== null) {
            @chdir($this->currentDir);
        }
    }

    /**
     * @return string
     */
    protected function getProjectStepFileName()
    {
        return $this->getProject()->getProperty('projectDirBuildTmp') . '/phing.steps.json';
    }
}
