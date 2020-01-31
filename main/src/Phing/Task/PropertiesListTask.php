<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use elnebuloso\Phing\PhingConfig;
use IOException;

/**
 * Class PropertiesListTask
 */
class PropertiesListTask extends AbstractTask
{
    /**
     * @var string
     */
    private string $group;

    /**
     * @param string $group
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        foreach (PhingConfig::getInstance()->getProperties($this->group) as $key => $value) {
            $length = PhingConfig::getInstance()->getLengthOfLongestPropertyInGroup($this->group) + 4;
            $key = str_pad($key, $length, ' ', STR_PAD_RIGHT);

            $this->log($key . $value);
        }

        $this->cleanup();
    }
}
