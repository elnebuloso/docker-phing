<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use IOException;

/**
 * Class RunTargetTask
 */
class RunTargetTask extends AbstractTask
{
    /**
     * @param string $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
    }

    /**
     * @throws IOException
     * @throws BuildException
     */
    public function main(): void
    {
        $this->prepare();

        if ($this->target == null) {
            throw new BuildException('target property required');
        }

        $this->getProject()->executeTarget($this->target);

        $this->cleanup();
    }
}
