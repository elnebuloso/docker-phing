<?php

namespace elnebuloso\Phing\Task;

/**
 * Class DockerPushTask
 */
class DockerPushTask extends AbstractDockerTask
{
    public function main(): void
    {
        $this->prepare();

        var_dump(__METHOD__);

        $this->cleanup();
    }
}
