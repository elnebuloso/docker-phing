<?php

namespace elnebuloso\Phing;

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
     * @throws \IOException
     */
    public function main()
    {
        $this->prepare();

        if (!preg_match('#((\d{1,}).(\d{1,}).(\d{1,}))#', $this->getProject()->getProperty('projectVersion'), $matches)) {
            throw new \BuildException('projectVersion ist not in the correct format');
        }

        $this->major = $matches[2];
        $this->minor = $matches[3];
        $this->patch = $matches[4];

        $this->getProject()->setProperty('dockerConfigImageVersion', $this->dockerConfigImageVersion());
        $this->getProject()->setProperty('dockerConfigImage', $this->dockerConfigImage());
        $this->getProject()->setProperty('dockerConfigImageTag', $this->dockerConfigImageTag());
        $this->getProject()->setProperty('dockerConfigImageTagLatest', $this->dockerConfigImageTagLatest());
        $this->getProject()->setProperty('dockerConfigImageTagMajor', $this->dockerConfigImageTagMajor());
        $this->getProject()->setProperty('dockerConfigImageTagMinor', $this->dockerConfigImageTagMinor());
        $this->getProject()->setProperty('dockerConfigImageTagPatch', $this->dockerConfigImageTagPatch());

        $this->cleanup();
    }

    /**
     * @return string
     */
    private function dockerConfigImageVersion()
    {
        $info = [];
        $info[] = $this->getProject()->getProperty('dockerImageVersion');

        // append given branchName only when not the defined master branch
        if (strtolower($this->getProject()->getProperty('branchName')) !== strtolower($this->getProject()->getProperty('branchNameMaster'))) {
            $info[] = $this->getProject()->getProperty('branchName');
        }

        $info[] = $this->getProject()->getProperty('buildNumber');

        return implode('-', array_filter($info));
    }

    /**
     * @return string
     */
    private function dockerConfigImage()
    {
        return implode(':', [$this->getDockerImageName(), $this->dockerConfigImageVersion()]);
    }

    /**
     * @return string
     */
    private function dockerConfigImageTag()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), $this->dockerConfigImage()])));
    }

    /**
     * @return string
     */
    private function dockerConfigImageTagLatest()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), 'latest'])])));
    }

    /**
     * @return string
     */
    private function dockerConfigImageTagMajor()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), implode('.', [$this->major])])])));
    }

    /**
     * @return string
     */
    private function dockerConfigImageTagMinor()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), implode('.', [$this->major, $this->minor])])])));
    }

    /**
     * @return string
     */
    private function dockerConfigImageTagPatch()
    {
        return strtolower(implode('/', array_filter([$this->getDockerRegistry(), $this->getDockerRegistryNamespace(), implode(':', [$this->getDockerImageName(), implode('.', [$this->major, $this->minor, $this->patch])])])));
    }

    /**
     * @return string
     */
    private function getDockerRegistry()
    {
        return strtolower(trim($this->getProject()->getProperty('dockerRegistry')));
    }

    /**
     * @return string
     */
    private function getDockerRegistryNamespace()
    {
        return strtolower(trim($this->getProject()->getProperty('dockerRegistryNamespace')));
    }

    /**
     * @return string
     */
    private function getDockerImageName()
    {
        return strtolower(trim($this->getProject()->getProperty('dockerImageName')));
    }
}
