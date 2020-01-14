<?php

namespace elnebuloso\Phing;

use BuildException;
use IOException;
use Jasny\DotKey;

/**
 * Class ConfigureComposerTask
 */
class ConfigureComposerTask extends AbstractTask
{
    /**
     * @var string
     */
    private $selector;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $selector
     */
    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main()
    {
        $this->prepare();

        $file = $this->getProject()->getProperty('project_dir_main_composer') . '/composer.json';
        $content = file_get_contents($file);
        $content = json_decode($content, false);

        if ($content === false) {
            throw new BuildException('invalid composer.json');
        }

        DotKey::on($content)->put($this->selector, $this->value);

        file_put_contents($file, json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->cleanup();
    }
}