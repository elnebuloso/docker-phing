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

        foreach (PhingConfig::getInstance()->getPropertiesByGroup($this->group) as $key => $value) {
            $key = str_pad($key, $this->getPaddingLength(PhingConfig::getInstance()->getPropertiesByGroup($this->group)), ' ', STR_PAD_RIGHT);
            $this->log($key . $value);
        }

        $this->cleanup();
    }

    /**
     * @param array $properties
     * @param int $padding
     * @return int
     */
    private function getPaddingLength(array $properties, int $padding = 4): int
    {
        $length = 0;

        foreach ($properties as $key => $value) {
            if (strlen($key) > $length) {
                $length = strlen($key);
            }
        }

        return $length + $padding;
    }
}
