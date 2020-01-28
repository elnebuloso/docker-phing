<?php

namespace elnebuloso\Phing\Task;

use BuildException;
use Cocur\Slugify\Slugify as SlugGenerator;
use IOException;

/**
 * Class SlugifyTask
 */
class SlugifyTask extends AbstractTask
{
    /**
     * @var string
     */
    private string $string;

    /**
     * @var string
     */
    private string $slug;

    /**
     * @param string $string
     */
    public function setString(string $string): void
    {
        $this->string = $string;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @throws IOException
     * @throws BuildException
     */
    public function main(): void
    {
        $this->prepare();

        $this->getProject()->setProperty($this->slug, (new SlugGenerator())->slugify($this->string));

        $this->cleanup();
    }
}
