<?php

namespace elnebuloso\Phing\Task;

use elnebuloso\Phing\Entity\Config;
use elnebuloso\Phing\Entity\ConfigFactory;
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
    private array $values;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @return void
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        $this->values = [];
        $this->values = Yaml::parseFile($this->getPhingRoot() . '/resources/build.default.yml');
        $this->values = array_replace_recursive($this->values, Yaml::parseFile($this->getProjectRoot() . '/build.yml'));

        if (file_exists($this->getProjectRoot() . '/build.local.yml')) {
            $this->values = array_replace_recursive($this->values, Yaml::parseFile($this->getProjectRoot() . '/build.local.yml'));
        }

        $this->config = (new ConfigFactory())->createFromArray($this->values);
        $this->populateProperties();
        $this->populateConfig();

        $this->cleanup();
    }

    /**
     * @return void
     */
    private function populateProperties(): void
    {
        foreach ($this->values['phing']['properties'] as $key => $value) {
            $this->getProject()->setProperty($key, trim($value));
        }
    }

    /**
     * @return void
     */
    private function populateConfig(): void
    {
        $this->getProject()->setProperty('project_name', $this->config->getProject()->getName());
    }
}
