<?php

namespace elnebuloso\Phing;

use BuildException;
use Exception;
use IOException;

/**
 * Class PHPMetrics2DirectoriesTask
 */
class PHPMetrics2DirectoriesTask extends AbstractTask
{
    /**
     * @var string
     */
    private $included;

    /**
     * @param string $included
     */
    public function setIncluded($included)
    {
        $this->included = $included;
    }

    /**
     * @throws BuildException
     * @throws IOException
     * @throws Exception
     */
    public function main()
    {
        $this->prepare();

        // sanitize directories for phpmetrics2 configuration
        $directories = explode(',', $this->getProject()->getProperty('report_phpmetrics_directories'));
        $directories = array_filter(array_map('trim', $directories));

        $this->getProject()->setProperty($this->included, implode(',', $directories));

        $this->cleanup();
    }
}
