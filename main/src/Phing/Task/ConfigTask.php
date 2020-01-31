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

        $this->loadPropertiesFromGit();
        $this->loadPropertiesFromGitVersion();
        $this->loadPropertiesFromFileVersion();
        $this->loadDefaultConfig();
        $this->loadProjectConfig();
        $this->loadProjectLocalConfig();
        $this->populateProperties();

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
        PhingConfig::getInstance()->addProperty('ci/base', 'branch_name', trim(implode('', $output)));

        $output = null;
        exec("git rev-parse HEAD", $output);
        PhingConfig::getInstance()->addProperty('ci/base', 'sha1', trim(implode('', $output)));

        $output = null;
        exec("git rev-parse --short HEAD", $output);
        PhingConfig::getInstance()->addProperty('ci/base', 'sha1_short', trim(implode('', $output)));

        foreach (PhingConfig::getInstance()->getProperties('ci/base') as $key => $value) {
            $this->getProject()->setProperty($key, $value);
        }
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

        $properties = json_decode(implode('', $output), true);

        if ($properties !== null) {
            foreach ($properties as $key => $value) {
                PhingConfig::getInstance()->addProperty('ci/gitversion', $key, $value);
            }
        }

        foreach (PhingConfig::getInstance()->getProperties('ci/gitversion') as $key => $value) {
            $this->getProject()->setProperty($key, $value);
        }

        $this->log('ci/gitversion properties loaded');
    }

    /**
     * @return void
     */
    private function loadPropertiesFromFileVersion(): void
    {
        $version = trim(file_get_contents($this->getProjectRoot() . '/VERSION'));

        if (empty($version)) {
            return;
        }

        if (!preg_match('#((\d{1,}).(\d{1,}).(\d{1,}))#', $version, $matches)) {
            return;
        }

        PhingConfig::getInstance()->addProperty('ci/fileversion', 'major', $matches[2]);
        PhingConfig::getInstance()->addProperty('ci/fileversion', 'minor', $matches[3]);
        PhingConfig::getInstance()->addProperty('ci/fileversion', 'patch', $matches[4]);
        PhingConfig::getInstance()->addProperty('ci/fileversion', 'semver', $matches[1]);
        PhingConfig::getInstance()->addProperty('ci/fileversion', 'semver_major', $matches[2]);
        PhingConfig::getInstance()->addProperty('ci/fileversion', 'semver_minor', $matches[2] . '.' . $matches[3]);
        PhingConfig::getInstance()->addProperty('ci/fileversion', 'semver_patch', $matches[2] . '.' . $matches[3] . '.' . $matches[4]);

        foreach (PhingConfig::getInstance()->getProperties('ci/fileversion') as $key => $value) {
            $this->getProject()->setProperty($key, $value);
        }

        $this->log('ci/fileversion properties loaded');
    }

    /**
     * @return void
     */
    private function loadDefaultConfig(): void
    {
        $this->values = Yaml::parseFile($this->getPhingRoot() . '/resources/build.default.yml');
        $this->log('phing default config loaded');
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
        if (!file_exists($this->getProjectRoot() . '/build.local.yml')) {
            return;
        }

        $this->values = array_replace_recursive($this->values, Yaml::parseFile($this->getProjectRoot() . '/build.local.yml'));
        $this->log('project local config loaded');
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
