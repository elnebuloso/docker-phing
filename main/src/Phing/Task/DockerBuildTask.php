<?php

namespace elnebuloso\Phing\Task;

use ExecTask;

/**
 * Class DockerBuildTask
 */
class DockerBuildTask extends ExecTask
{
    /**
     * @var string
     */
    private string $file;

    /**
     * @var string
     */
    private string $args;

    /**
     * @var string
     */
    private string $ctx;

    /**
     * @param string $file
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * @param string $args
     */
    public function setArgs(string $args): void
    {
        $this->args = $args;
    }

    /**
     * @param string $ctx
     */
    public function setCtx(string $ctx): void
    {
        $this->ctx = $ctx;
    }
}
