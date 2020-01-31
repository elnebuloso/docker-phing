<?php

namespace elnebuloso\Phing\Task;

use IOException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigTask
 */
class ConfigTask extends AbstractTask
{
    /**
     * @var array
     */
    private array $values = [];

    /**
     * @return void
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        $this->loadDefaultConfig();
        $this->loadProjectConfig();
        $this->loadProjectLocalConfig();
        $this->populateProperties();

        $this->cleanup();
    }

    /**
     * @return void
     */
    private function loadDefaultConfig(): void
    {
        $this->values = Yaml::parseFile($this->getPhingRoot() . '/resources/build.default.yml');
        $this->log('default config loaded');
    }

    /**
     * @return void
     */
    private function loadProjectConfig(): void
    {
        $this->values = array_replace_recursive($this->values, Yaml::parseFile($this->getProjectRoot() . '/build.yml'));
        $this->log('project config loaded');
    }

    /**
     * @return void
     */
    private function loadProjectLocalConfig(): void
    {
        if (file_exists($this->getProjectRoot() . '/build.local.yml')) {
            $this->values = array_replace_recursive($this->values, Yaml::parseFile($this->getProjectRoot() . '/build.local.yml'));
            $this->log('project local config loaded');
        }
    }

    /**
     * @return void
     */
    private function populateProperties(): void
    {
        foreach ($this->values['phing']['properties'] as $key => $value) {


            if (self::COMPOSER_COMMANDS_BEFORE === $key) {
                $this->getProject()->setProperty($key, implode(',', array_filter(array_map('trim', $value))));
                continue;
            }

            $this->getProject()->setProperty($key, trim($value));
        }
    }
}
