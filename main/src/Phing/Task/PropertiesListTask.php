<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use IOException;

/**
 * Class PropertiesListTask
 */
class PropertiesListTask extends AbstractTask
{
    /**
     * @var string
     */
    private string $prefix;

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        $length = 0;
        $properties = $this->getProperties($this->prefix);

        foreach ($properties as $key => $value) {
            if (strlen($key) > $length) {
                $length = strlen($key) + 4;
            }
        }

        foreach ($properties as $key => $value) {
            $this->log(str_pad($key, $length, ' ', STR_PAD_RIGHT) . $value);
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
