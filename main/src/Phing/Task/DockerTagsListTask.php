<?php

namespace elnebuloso\Phing\Task;

use IOException;

/**
 * Class DockerTagsListTask
 */
class DockerTagsListTask extends AbstractDockerTask
{
    /**
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        foreach ($this->getDockerTags() as $dockerTag) {
            $this->log($dockerTag);
        }

        $this->cleanup();
    }
}