<?php

namespace elnebuloso\Phing;

use BuildException;
use Exception;
use Adbar\Dot;

/**
 * Class ConfigureComposer
 */
class ConfigureComposer extends AbstractTask
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
     * @throws Exception
     */
    public function main()
    {
        $this->prepare();

        $file = $this->getProject()->getProperty('projectDirMainComposer') . '/composer.json';
        $content = file_get_contents($file);
        $content = json_decode($content);

        if ($content === false) {
            throw new BuildException('invalid composer.json');
        }

        $dot = new Dot((array) $content);
        $dot->set($this->selector, $this->value);

        file_put_contents($file, json_encode($dot, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->cleanup();
    }
}