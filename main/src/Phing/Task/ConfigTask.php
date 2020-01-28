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

        $this->config = (new ConfigFactory())->createFromArray(Yaml::parseFile($this->getProjectRoot() . '/build.yml'));
        $this->populateProperties();

        $this->cleanup();
    }

    /**
     * @return void
     */
    private function populateProperties(): void
    {
        $this->getProject()->setProperty('project_name', $this->config->getProject()->getName());
    }
}
