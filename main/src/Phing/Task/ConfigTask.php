<?php

namespace elnebuloso\Phing\Task;

use elnebuloso\Phing\PhingConfig;
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
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_GIT, 'branch_name', implode('', $output));

        $output = null;
        exec("git rev-parse HEAD", $output);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_GIT, 'sha1', implode('', $output));

        $output = null;
        exec("git rev-parse --short HEAD", $output);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_GIT, 'sha1_short', implode('', $output));

        $output = null;
        exec("git show -s --format=%ct " . PhingConfig::getInstance()->getPropertyByGroup(self::PROPERTY_GROUP_CI_GIT, 'sha1'), $output);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_GIT, 'commit_time', implode('', $output));

        $this->populatePropertiesByGroup(self::PROPERTY_GROUP_CI_GIT);
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

        PhingConfig::getInstance()->addPropertiesByGroup(self::PROPERTY_GROUP_CI_GITVERSION, (array) json_decode(implode('', $output), true));

        $this->populatePropertiesByGroup(self::PROPERTY_GROUP_CI_GITVERSION);
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

        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'major', $matches[2]);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'minor', $matches[3]);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'patch', $matches[4]);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'semver', $matches[1]);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'semver_major', $matches[2]);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'semver_minor', $matches[2] . '.' . $matches[3]);
        PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_CI_FILEVERSION, 'semver_patch', $matches[2] . '.' . $matches[3] . '.' . $matches[4]);

        $this->populatePropertiesByGroup(self::PROPERTY_GROUP_CI_FILEVERSION);
    }

    /**
     * @param string $config
     * @return void
     */
    private function loadConfigFile(string $config): void
    {
        if (!file_exists($config)) {
            return;
        }

        $properties = (array) Yaml::parseFile($config);

        if (!isset($properties['phing']['properties'])) {
            return;
        }

        PhingConfig::getInstance()->addProperties($properties['phing']['properties']);

        $this->populateProperties();
        $this->mergePropertiesByBranchName($properties);
        $this->logPropertiesLoaded($config);
    }

    /**
     * @param array $properties
     */
    private function mergePropertiesByBranchName(array $properties): void
    {
        $branchName = PhingConfig::getInstance()->getPropertyByGroup(self::PROPERTY_GROUP_CI_GIT, 'branch_name');
        $branchName = $branchName === null ? 'master' : $branchName;

        foreach ((array) $properties['phing']['branches'] as $key => $branch) {
            if (!isset($branch['regex'])) {
                continue;
            }

            if (!preg_match("|" . $branch['regex'] . "|", $branchName)) {
                continue;
            }

            if (!isset($branch['properties'])) {
                continue;
            }

            PhingConfig::getInstance()->addProperties($branch['properties']);

            if (!isset($branch['docker_tags'])) {
                continue;
            }

            foreach ((array) $branch['docker_tags'] as $tagName => $tag) {
                $dockerRegistry = trim($this->project->getProperty('docker_registry'), '/');
                $dockerRegistryNamespace = trim($this->project->getProperty('docker_registry_namespace'), '/');
                $name = $this->project->getProperty('project_name');
                $base = implode('/', array_filter([$dockerRegistry, $dockerRegistryNamespace, $name]));

                var_dump($name);
                PhingConfig::getInstance()->addPropertyByGroup(self::PROPERTY_GROUP_DOCKER_TAG, $tagName, $base . ':' . $tag);
            }

            $this->populatePropertiesByGroup(self::PROPERTY_GROUP_DOCKER_TAG);
        }
    }

    /**
     * @return void
     */
    private function populateProperties(): void
    {
        foreach (PhingConfig::getInstance()->getProperties() as $key => $value) {
            $this->getProject()->setProperty($key, $value);
        }
    }

    /**
     * @param string $group
     */
    private function populatePropertiesByGroup(string $group): void
    {
        foreach (PhingConfig::getInstance()->getPropertiesByGroup($group) as $key => $value) {
            $this->getProject()->setProperty($key, $value);
        }

        $this->logPropertiesLoaded($group);
    }

    /**
     * @param string $name
     */
    private function logPropertiesLoaded(string $name): void
    {
        $this->log('properties loaded: ' . $name);
    }
}
