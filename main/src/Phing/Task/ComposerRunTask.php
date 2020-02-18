<?php

namespace elnebuloso\Phing\Task;

use IOException;

/**
 * Class ComposerRunTask
 */
class ComposerRunTask extends AbstractTask
{
    /**
     * @var string
     */
    private string $command = '';

    /**
     * @var string
     */
    private string $directory = '';

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * @param string $directory
     */
    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    /**
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        $target = $this->getProject()->getProperty('composer_runner') === 'docker' ? 'run:composer:docker' : 'run:composer:phing';
        $commands = array_filter(array_map('trim', explode(',', $this->getProject()->getProperty('composer_commands_before'))));
        $directory = $this->directory === '' ? $this->getProject()->getProperty('project_dir_main_composer') : $this->directory;

        if ($target === 'run:composer:docker') {
            $this->getProject()->executeTarget('run:composer:docker:build');
        }

        foreach ($commands as $command) {
            $this->getProject()->setProperty('run_composer_directory', $directory);
            $this->getProject()->setProperty('run_composer_command', $command);
            $this->getProject()->executeTarget($target);
        }

        $this->getProject()->setProperty('run_composer_directory', $directory);
        $this->getProject()->setProperty('run_composer_command', $this->command);
        $this->getProject()->executeTarget($target);

        $this->cleanup();
    }
}
