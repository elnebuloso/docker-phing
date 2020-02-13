<?php

namespace elnebuloso\Phing\Task;

/**
 * Class AbstractDockerTask
 */
abstract class AbstractDockerTask extends AbstractTask
{
    /**
     * @return array
     */
    protected function getDockerTags(): array
    {
        $tags = [];

        $dockerRegistry = trim($this->project->getProperty('docker_registry'), '/');
        $dockerRegistryNamespace = trim($this->project->getProperty('docker_registry_namespace'), '/');
        $name = $this->project->getProperty('project_name');
        $base = implode('/', array_filter([$dockerRegistry, $dockerRegistryNamespace, $name]));

        foreach (explode(',', $this->project->getProperty('docker_tag_versions')) as $version) {
            $tags[] = strtolower($base . ':' . $version);
        }

        return $tags;
    }
}
