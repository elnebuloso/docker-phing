<?php

namespace elnebuloso\Phing\Entity;

use elnebuloso\Phing\Properties;

/**
 * Class ConfigFactory
 */
class ConfigFactory implements Properties
{
    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param array $values
     *
     * @return Config
     */
    public function createFromArray(array $values)
    {
        $this->config = new Config();
        $this->setupProject($values);

        return $this->config;
    }

    /**
     * @param array $values
     */
    private function setupProject(array $values)
    {
        $project = new Project();
        $project->setName($values[self::PHING][self::PROJECT_NAME]);

        $this->config->setProject($project);
    }
}
