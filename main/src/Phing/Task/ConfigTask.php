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
     * @return void
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        $this->loadPropertiesFromGit();
        $this->loadPropertiesFromGitVersion();
        $this->loadPropertiesFromFileVersion();
        $this->loadConfigFile($this->getPhingRoot() . '/resources/build.default.yml');
        $this->loadConfigFile($this->getProjectRoot() . '/build.yml');
        $this->loadConfigFile($this->getProjectRoot() . '/build.local.yml');

        $this->cleanup();
    }

    /**
     * @return void
     */
    private function loadPropertiesFromGit(): void
    {
        if (!file_exists($this->getProjectRoot() . '/.git')) {
            return;
        }

        $output = null;
        exec("git rev-parse --abbrev-ref HEAD", $output);
        $this->setProperty('branch_name', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git rev-parse HEAD", $output);
        $this->setProperty('sha1', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git rev-parse --short HEAD", $output);
        $this->setProperty('sha1_short', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $output = null;
        exec("git show -s --format=%ct " . $this->getProperty('sha1', self::PROPERTY_GROUP_CI_GIT), $output);
        $this->setProperty('commit_time', implode('', $output), self::PROPERTY_GROUP_CI_GIT);

        $this->logPropertiesLoaded(self::PROPERTY_GROUP_CI_GIT);
    }

    /**
     * @return void
     */
    private function loadPropertiesFromGitVersion(): void
    {
        if (!file_exists($this->getProjectRoot() . '/.git')) {
            return;
        }

        exec("GitVersion", $output);

        foreach ((array) json_decode(implode('', $output), true) as $key => $value) {
            $this->setProperty($key, $value, self::PROPERTY_GROUP_CI_GITVERSION);
        }

        $this->logPropertiesLoaded(self::PROPERTY_GROUP_CI_GITVERSION);
    }

    /**
     * @return void
     */
    private function loadPropertiesFromFileVersion(): void
    {
        if (!file_exists($this->getProjectRoot() . '/VERSION')) {
            return;
        }

        $version = trim(file_get_contents($this->getProjectRoot() . '/VERSION'));

        if (empty($version)) {
            return;
        }

        if (!preg_match('#((\d{1,}).(\d{1,}).(\d{1,}))#', $version, $matches)) {
            return;
        }

        $this->setProperty('major', $matches[2], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('minor', $matches[3], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('patch', $matches[4], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver', $matches[1], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver_major', $matches[2], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver_minor', $matches[2] . '.' . $matches[3], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver_patch', $matches[2] . '.' . $matches[3] . '.' . $matches[4], self::PROPERTY_GROUP_CI_FILEVERSION);

        $this->logPropertiesLoaded(self::PROPERTY_GROUP_CI_FILEVERSION);
    }

    /**
     * @param string $config
     */
    private function loadConfigFile(string $config): void
    {
        if (!file_exists($config)) {
            return;
        }

        $properties = (array) Yaml::parseFile($config);

        if (isset($properties['phing']['properties']) && is_array($properties['phing']['properties'])) {
            $this->loadConfigFileProperties($properties['phing']['properties']);
        }

        if (isset($properties['phing']['branches']) && is_array($properties['phing']['branches'])) {
            $this->loadConfigFilePropertiesByBranches($properties['phing']['branches']);
        }

        $this->logPropertiesLoaded($config);
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

    /**
     * @param string $name
     */
    private function logPropertiesLoaded(string $name): void
    {
        $this->log('properties loaded: ' . $name);
    }
}
