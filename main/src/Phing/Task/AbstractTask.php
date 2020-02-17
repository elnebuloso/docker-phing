<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace elnebuloso\Phing\Task;

use BuildException;
use elnebuloso\Phing\PhingService;
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
    protected function getPhingRoot(): string
    {
        return $this->getProject()->getProperty(self::PHING_COMMONS_ROOT);
    }

    /**
     * @return string
     */
    protected function getProjectRoot(): string
    {
        return $this->getProject()->getProperty(self::PROJECT_ROOT);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string $prefix
     */
    protected function setProperty(string $key, $value, string $prefix = ''): void
    {
        if (is_array($value)) {
            $value = implode(',', array_filter(array_map('trim', $value)));
        }

        $this->getProject()->setProperty($this->getPropertyKey($key, $prefix), $value);
    }

    /**
     * @param string $key
     * @param string $prefix
     * @return string
     */
    protected function getProperty(string $key, string $prefix = '')
    {
        return $this->getProject()->getProperty($this->getPropertyKey($key, $prefix));
    }

    /**
     * @param string $prefix
     * @return array
     */
    protected function getProperties(string $prefix = '')
    {
        $properties = [];

        foreach ($this->getProject()->getProperties() as $key => $value) {
            if (strpos($key, $prefix) !== false) {
                $properties[$key] = $value;
            }
        }

        ksort($properties, SORT_NATURAL);

        return $properties;
    }

    /**
     * @param string $key
     * @param string $prefix
     * @return string
     */
    private function getPropertyKey(string $key, string $prefix = '')
    {
        $key = str_replace('-', '_', $key);
        $key = $this->camelCaseToUnderscore($key);

        return $prefix !== '' ? $prefix . '_' . $key : $key;
    }

    /**
     * @param string $input
     * @return string
     */
    private function camelCaseToUnderscore(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
