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

        $this->setProperty('branch_name', $this->getProject()->getProperty('ci_gitversion_branch_name'), self::PROPERTY_GROUP_CI_GIT);
        $this->setProperty('sha1', $this->getProject()->getProperty('ci_gitversion_sha'), self::PROPERTY_GROUP_CI_GIT);
        $this->setProperty('sha1_short', $this->getProject()->getProperty('ci_gitversion_short_sha'), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git show -s --format=%ct " . $this->getProject()->getProperty('ci_gitversion_sha'), $output);
        $this->setProperty('commit_time', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $this->logPropertiesLoaded(true);

        $this->cleanup();
    }
}
