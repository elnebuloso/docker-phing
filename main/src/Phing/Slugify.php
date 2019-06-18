<?php

namespace elnebuloso\Phing;

use BuildException;
use Exception;
use Cocur\Slugify\Slugify as SlugGenerator;

/**
 * Class Slugify
 */
class Slugify extends AbstractTask
{
    /**
     * @var string
     */
    private $string;

    /**
     * @var string
     */
    private $slug;

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
     * @throws BuildException
     * @throws Exception
     */
    public function main()
    {
        $this->prepare();

        $this->getProject()->setProperty($this->slug, (new SlugGenerator())->slugify($this->string));

        $this->cleanup();
    }
}
