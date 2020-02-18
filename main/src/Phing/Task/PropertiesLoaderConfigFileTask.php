<?php

namespace elnebuloso\Phing\Task;

use IOException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class PropertiesLoaderConfigFileTask
 */
class PropertiesLoaderConfigFileTask extends AbstractPropertiesLoaderTask
{
    /**
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        $this->loadConfigFile($this->getPhingRoot() . '/resources/build.default.yml');
        $this->loadConfigFile($this->getProjectRoot() . '/build.yml');
        $this->loadConfigFile($this->getProjectRoot() . '/build.local.yml');

        $this->cleanup();
    }

    /**
     * @param string $config
     */
    private function loadConfigFile(string $config): void
    {
        if (!file_exists($config)) {
            $this->logPropertiesLoaded(false, $config);

            return;
        }

        $properties = (array) Yaml::parseFile($config);

        if (isset($properties['phing']['properties']) && is_array($properties['phing']['properties'])) {
            $this->loadConfigFileProperties($properties['phing']['properties']);
        }

        if (isset($properties['phing']['branches']) && is_array($properties['phing']['branches'])) {
            $this->loadConfigFilePropertiesByBranches($properties['phing']['branches']);
        }

        $this->logPropertiesLoaded(true, $config);
    }

    /**
     * @param array $properties
     */
    private function loadConfigFileProperties(array $properties): void
    {
        foreach ($properties as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    /**
     * @param array $branches
     */
    private function loadConfigFilePropertiesByBranches(array $branches): void
    {
        $branchName = $this->getProperty('branch_name', self::PROPERTY_GROUP_CI_GIT);
        $branchName = $branchName === null ? 'master' : $branchName;

        foreach ($branches as $name => $branch) {
            if (!isset($branch['regex'])) {
                continue;
            }

            if (!preg_match("|" . $branch['regex'] . "|", $branchName)) {
                continue;
            }

            if (isset($branch['properties']) && is_array($branch['properties'])) {
                $this->loadConfigFileProperties($branch['properties']);
            }

            if (isset($branch['docker_tags']) && is_array($branch['docker_tags'])) {
                $this->loadConfigFileDockerTags($branch['docker_tags']);
            }
        }
    }

    /**
     * @param array $tags
     */
    private function loadConfigFileDockerTags(array $tags): void
    {
        foreach ($tags as $key => $tag) {
            $dockerRegistry = trim($this->project->getProperty('docker_registry'), '/');
            $dockerRegistryNamespace = trim($this->project->getProperty('docker_registry_namespace'), '/');
            $name = $this->project->getProperty('project_name');
            $base = implode('/', array_filter([$dockerRegistry, $dockerRegistryNamespace, $name]));

            $this->setProperty($key, $base . ':' . $tag, self::PROPERTY_GROUP_DOCKER_TAG);
        }
    }
}
