<?php

namespace elnebuloso\Phing\Task;

use IOException;

/**
 * Class DockerPushTask
 */
class DockerPushTask extends AbstractTask
{
    /**
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        foreach ($this->getProperties(self::PROPERTY_GROUP_DOCKER_TAG) as $key => $value) {
            $this->getProject()->setProperty('run_docker_push_tag', $value);
            $this->getProject()->executeTarget('run:docker:push');
        }

        $this->cleanup();
    }
}
