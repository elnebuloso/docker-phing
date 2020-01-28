<?php

namespace elnebuloso\Phing;

use Symfony\Component\Yaml\Yaml;

class ConfigTask extends AbstractTask
{
    public function main()
    {
        $this->prepare();
        $value = Yaml::parseFile($this->getProjectRoot() . '/build.yml');
        var_dump($value);
        $this->cleanup();
    }
}
