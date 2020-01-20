<?php

namespace elnebuloso\Phing;

use BuildException;
use IOException;

/**
 * Class DockerConfigTask
 */
class DockerConfigTask extends AbstractTask
{
    /**
     * @var int
     */
    private $major;

    /**
     * @var int
     */
    private $minor;

    /**
     * @var int
     */
    private $patch;

    /**
     * @throws BuildException
     * @throws IOException
     */
    public function main()
    {
        $this->prepare();

        if (!preg_match('#((\d{1,}).(\d{1,}).(\d{1,}))#', $this->getProject()->getProperty('project_version'), $matches)) {
            throw new BuildException('project_version ist not in the correct format');
        }

        $this->major = $matches[2];
        $this->minor = $matches[3];
        $this->patch = $matches[4];

        $this->getProject()->setProperty('docker_config_image_version', $this->getDockerConfigImageVersion());
        $this->getProject()->setProperty('docker_config_image', $this->getDockerConfigImage());
        $this->getProject()->setProperty('docker_config_image_tag', $this->getDockerConfigImageTag());
        $this->getProject()->setProperty('docker_config_image_tag_branch', $this->getDockerConfigImageTagBranch());
        $this->getProject()->setProperty('docker_config_image_tag_latest', $this->getDockerConfigImageTagLatest());
        $this->getProject()->setProperty('docker_config_image_tag_major', $this->getDockerConfigImageTagMajor());
        $this->getProject()->setProperty('docker_config_image_tag_minor', $this->getDockerConfigImageTagMinor());
        $this->getProject()->setProperty('docker_config_image_tag_patch', $this->getDockerConfigImageTagPatch());

        $this->cleanup();
    }

    /**
     * @return string
     */
    private function getDockerConfigImageVersion()
    {
        $info = [];
        $info[] = $this->getProject()->getProperty('docker_image_version');

        // append given branch_name only when not the defined master branch
        if ($this->getBranchName() !== $this->getBranchNameRelease()) {
            $info[] = $this->getProject()->getProperty('branch_name');
        }

        $info[] = $this->getProject()->getProperty('build_number');

        return implode('-', array_filter($info));
    }

    /**
     * @return string
     */
    private function getDockerConfigImage()
    {
        return implode(':', [$this->getDockerImageName(), $this->getDockerConfigImageVersion()]);
    }

    /**
     * @return string
     */
    private function getDockerConfigImageTag()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), $this->getDockerConfigImage()])));
    }

    /**
     * @return string
     */
    private function getDockerConfigImageTagBranch()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), $this->getBranchName()])])));
    }

    /**
     * @return string
     */
    private function getDockerConfigImageTagLatest()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), 'latest'])])));
    }

    /**
     * @return string
     */
    private function getDockerConfigImageTagMajor()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), implode('.', [$this->major])])])));
    }

    /**
     * @return string
     */
    private function getDockerConfigImageTagMinor()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), implode('.', [$this->major, $this->minor])])])));
    }

    /**
     * @return string
     */
    private function getDockerConfigImageTagPatch()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), implode('.', [$this->major, $this->minor, $this->patch])])])));
    }

    /**
     * @return string
     */
    private function getDockerRegistry()
    {
        return strtolower(trim($this->getProject()->getProperty('docker_registry')));
    }

    /**
     * @return string
     */
    private function getDockerRegistryNamespace()
    {
        return strtolower(trim($this->getProject()->getProperty('docker_registry_namespace')));
    }

    /**
     * @return string
     */
    private function getDockerImageName()
    {
        return strtolower(trim($this->getProject()->getProperty('docker_image_name')));
    }

    /**
     * @return string
     */
    private function getBranchName()
    {
        return strtolower(trim($this->getProject()->getProperty('branch_name')));
    }

    /**
     * @return string
     */
    private function getBranchNameRelease()
    {
        return strtolower(trim($this->getProject()->getProperty('branch_name_release')));
    }
}
