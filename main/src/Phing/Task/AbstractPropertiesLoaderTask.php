<?php

namespace elnebuloso\Phing\Task;

/**
 * Class AbstractPropertiesLoaderTask
 */
abstract class AbstractPropertiesLoaderTask extends AbstractTask
{
    /**
     * @param bool $state
     * @param string $name
     */
    protected function logPropertiesLoaded(bool $state, string $name = ''): void
    {
        $message = $state ? 'loaded' : 'missing';
        $message = $name !== '' ? $name . ', ' . $message : $message;

        $this->log($message);
    }
}
