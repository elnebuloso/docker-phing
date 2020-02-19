<?php

namespace elnebuloso\Phing\Task;

use IOException;

/**
 * Class PropertiesLoaderGitTask
 */
class PropertiesLoaderGitTask extends AbstractPropertiesLoaderTask
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

        exec("git rev-parse --verify HEAD");

        $output = null;
        exec("git rev-parse --abbrev-ref HEAD", $output);
        $this->setProperty('branch_name', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git rev-parse HEAD", $output);
        $this->setProperty('sha1', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git rev-parse --short HEAD", $output);
        $this->setProperty('sha1_short', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git show -s --format=%ct " . $this->getProperty('sha1', self::PROPERTY_GROUP_CI_GIT), $output);
        $this->setProperty('commit_time', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $this->logPropertiesLoaded(true);

        $this->cleanup();
    }
}
