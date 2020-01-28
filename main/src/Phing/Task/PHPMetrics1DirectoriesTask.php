<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use elnebuloso\Phing\Properties;
use IOException;

/**
 * Class PHPMetrics1DirectoriesTask
 */
class PHPMetrics1DirectoriesTask extends AbstractTask implements Properties
{
    /**
     * @var string
     */
    private string $excluded;

    /**
     * @param string $excluded
     */
    public function setExcluded($excluded): void
    {
        $this->excluded = $excluded;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        // all directories in current directory
        $all = array_filter(glob('*'), 'is_dir');

        // sanitize directories for phpmetrics2 configuration
        $directories = explode(',', $this->getProject()->getProperty(self::REPORT_PHPMETRICS_DIRECTORIES));
        $directories = array_filter(array_map('trim', $directories));
        $directories = array_diff($all, $directories);

        $this->getProject()->setProperty($this->excluded, implode('\|', $directories));

        $this->cleanup();
    }
}
