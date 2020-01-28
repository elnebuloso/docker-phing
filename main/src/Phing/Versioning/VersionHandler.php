<?php

namespace elnebuloso\Phing\Versioning;

use elnebuloso\Phing\Entity\Versioning\BaseVersion;

interface VersionHandler
{
    /**
     * @return \elnebuloso\Phing\Entity\Versioning\BaseVersion
     */
    public function getVersion(): BaseVersion;
}
