<?php

namespace elnebuloso\Phing;

use BuildException;
use IOException;

/**
 * Class PHPMetrics1DirectoriesTask
 */
class PHPMetrics1DirectoriesTask extends AbstractTask
{
    /**
     * @var string
     */
    private $excluded;

    /**
     * @param string $excluded
     */
    public function setExcluded($excluded)
    {
        $this->excluded = $excluded;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main()
    {
        $this->prepare();

        // all directories in current directory
        $all = array_filter(glob('*'), 'is_dir');

        // sanitize directories for phpmetrics2 configuration
        $directories = explode(',', $this->getProject()->getProperty('report_phpmetrics_directories'));
        $directories = array_filter(array_map('trim', $directories));
        $directories = array_diff($all, $directories);

        $this->getProject()->setProperty($this->excluded, implode('\|', $directories));

        $this->cleanup();
    }
}
