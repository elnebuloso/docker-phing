<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use elnebuloso\Phing\Properties;
use IOException;

/**
 * Class PHPMetrics2DirectoriesTask
 */
class PHPMetrics2DirectoriesTask extends AbstractTask implements Properties
{
    /**
     * @var string
     */
    private string $included;

    /**
     * @param string $included
     */
    public function setIncluded($included): void
    {
        $this->included = $included;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        // sanitize directories for phpmetrics2 configuration
        $directories = explode(',', $this->getProject()->getProperty(self::REPORT_PHPMETRICS_DIRECTORIES));
        $directories = array_filter(array_map('trim', $directories));

        $this->getProject()->setProperty($this->included, implode(',', $directories));

        $this->cleanup();
    }
}
