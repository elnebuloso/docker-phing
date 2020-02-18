<?php

namespace elnebuloso\Phing\Task;

use IOException;

/**
 * Class PropertiesLoaderGitversionTask
 */
class PropertiesLoaderGitversionTask extends AbstractPropertiesLoaderTask
{
    /**
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        if (!file_exists($this->getProjectRoot() . '/.git')) {
            $this->logPropertiesLoaded(false);

            return;
        }

        exec("GitVersion", $output);

        foreach ((array) json_decode(implode('', $output), true) as $key => $value) {
            $this->setProperty($key, $value, self::PROPERTY_GROUP_CI_GITVERSION);
        }

        $this->logPropertiesLoaded(true);

        $this->cleanup();
    }
}
