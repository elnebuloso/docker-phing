<?php

namespace elnebuloso\Phing\Task;

use IOException;

/**
 * Class ConfigTask
 */
class PropertiesLoaderFileversionTask extends AbstractPropertiesLoaderTask
{
    /**
     * @throws IOException
     */
    public function main(): void
    {
        $this->prepare();

        if (!file_exists($this->getProjectRoot() . '/VERSION')) {
            $this->logPropertiesLoaded(false);

            return;
        }

        $version = trim(file_get_contents($this->getProjectRoot() . '/VERSION'));

        if (empty($version)) {
            $this->logPropertiesLoaded(false);

            return;
        }

        if (!preg_match('#((\d{1,}).(\d{1,}).(\d{1,}))#', $version, $matches)) {
            $this->logPropertiesLoaded(false);

            return;
        }

        $this->setProperty('major', $matches[2], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('minor', $matches[3], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('patch', $matches[4], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver', $matches[1], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver_major', $matches[2], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver_minor', $matches[2] . '.' . $matches[3], self::PROPERTY_GROUP_CI_FILEVERSION);
        $this->setProperty('semver_patch', $matches[2] . '.' . $matches[3] . '.' . $matches[4], self::PROPERTY_GROUP_CI_FILEVERSION);

        $this->logPropertiesLoaded(true);

        $this->cleanup();
    }
}
