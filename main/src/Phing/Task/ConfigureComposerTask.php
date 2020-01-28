<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use elnebuloso\Phing\Properties;
use IOException;
use Jasny\DotKey;

/**
 * Class ConfigureComposerTask
 */
class ConfigureComposerTask extends AbstractTask implements Properties
{
    /**
     * @var string
     */
    private string $selector;

    /**
     * @var string
     */
    private string $value;

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
     * @throws IOException
     * @throws BuildException
     */
    public function main(): void
    {
        $this->prepare();

        $file = $this->getProject()->getProperty(self::PROJECT_DIR_MAIN_COMPOSER) . '/composer.json';
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
