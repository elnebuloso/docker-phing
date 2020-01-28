<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace elnebuloso\Phing\Task;

use BuildException;
use elnebuloso\Phing\Properties;
use IOException;
use PhingFile;
use Task;

/**
 * Class AbstractTask
 */
abstract class AbstractTask extends Task implements Properties
{
    /**
     * @var PhingFile
     */
    protected $dir;

    /**
     * @var string
     */
    protected string $currentDir;

    /**
     * @param PhingFile $dir Working directory
     */
    public function setDir(PhingFile $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return void
     * @throws IOException
     * @throws BuildException
     */
    protected function prepare(): void
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
    protected function cleanup(): void
    {
        if ($this->dir !== null) {
            @chdir($this->currentDir);
        }
    }

    /**
     * @return string
     */
    protected function getProjectRoot(): string
    {
        return $this->getProject()->getProperty(self::PROJECT_ROOT);
    }
}
