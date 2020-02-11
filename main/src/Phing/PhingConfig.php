<?php

namespace elnebuloso\Phing;

/**
 * Class Config
 */
final class PhingConfig
{
    /**
     * @var PhingConfig
     */
    private static ?PhingConfig $instance = null;

    /**
     * @var array
     */
    private array $properties = [];

    /**
     * @return PhingConfig
     */
    public static function getInstance(): PhingConfig
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param string $group
     * @param string $key
     * @param string $value
     */
    public function addProperty($group, $key, $value)
    {
        $this->properties[$group][$this->getPropertyKey($group, $key)] = trim($value);
    }

    /**
     * @param string $group
     *
     * @return array
     */
    public function getProperties($group)
    {
        return isset($this->properties[$group]) ? $this->properties[$group] : [];
    }

    /**
     * @return int
     */
    public function getLengthOfLongestProperty()
    {
        $length = 0;

        foreach ($this->properties as $key => $group) {
            $current = $this->getLengthOfLongestPropertyInGroup($key);

            if ($current > $length) {
                $length = $current;
            }
        }

        return $length;
    }

    /**
     * @param string $group
     *
     * @return int
     */
    public function getLengthOfLongestPropertyInGroup($group)
    {
        $length = 0;

        foreach ($this->properties[$group] as $key => $value) {
            if (strlen($key) > $length) {
                $length = strlen($key);
            }
        }

        return $length;
    }

    /**
     * @param string $group
     * @param string $key
     *
     * @return string
     */
    private function getPropertyKey($group, $key)
    {
        return str_replace('/', '_', $group) . '_' . PhingService::camelCaseToUnderscore($key);
    }
}
