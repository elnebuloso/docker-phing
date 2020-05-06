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

        $branchName = null;
        exec("git rev-parse --abbrev-ref HEAD", $branchName);
        $this->setProperty('branch_name', implode('', $branchName), self::PROPERTY_GROUP_CI_GIT);

        $sha1 = null;
        exec("git rev-parse HEAD", $sha1);
        $this->setProperty('sha1', implode('', $sha1), self::PROPERTY_GROUP_CI_GIT);

        $sha1Short = null;
        exec("git rev-parse HEAD | cut -c 1-8", $sha1Short);
        $this->setProperty('sha1_short', implode('', $sha1Short), self::PROPERTY_GROUP_CI_GIT);

        $commitTime = null;
        exec("git show -s --format=%ct " . $this->getProject()->getProperty('ci_git_sha1'), $commitTime);
        $this->setProperty('commit_time', implode('', $commitTime), self::PROPERTY_GROUP_CI_GIT);

        $this->logPropertiesLoaded(true);

        $this->cleanup();
    }
}
