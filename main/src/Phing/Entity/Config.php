<?php

namespace elnebuloso\Phing\Entity;

/**
 * Class Config
 */
class Config
{
    /**
     * @var Project
     */
    private Project $project;

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void
    {
        $this->project = $project;
    }
}
