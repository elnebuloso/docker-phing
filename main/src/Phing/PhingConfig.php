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
     * @var array
     */
    private array $propertiesByGroup = [];

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
     * @param string $key
     * @param mixed $value
     */
    public function addProperty(string $key, $value): void
    {
        $this->properties[$key] = $this->getPropertyValue($value);
    }

    /**
     * @param array $properties
     */
    public function addProperties(array $properties): void
    {
        foreach ($properties as $key => $value) {
            $this->addProperty($key, $value);
        }
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        ksort($this->properties, SORT_NATURAL);

        return $this->properties;
    }

    /**
     * @param string $group
     * @param string $key
     * @param mixed $value
     */
    public function addPropertyByGroup(string $group, string $key, $value): void
    {
        $this->propertiesByGroup[$group][$this->getPropertyKeyByGroup($group, $key)] = $this->getPropertyValue($value);
    }

    /**
     * @param string $group
     * @param string $key
     * @return string
     */
    public function getPropertyByGroup(string $group, string $key): ?string
    {
        return $this->propertiesByGroup[$group][$this->getPropertyKeyByGroup($group, $key)];
    }

    /**
     * @param string $group
     * @param array $properties
     */
    public function addPropertiesByGroup(string $group, array $properties): void
    {
        foreach ($properties as $key => $value) {
            $this->addPropertyByGroup($group, $key, $value);
        }
    }

    /**
     * @param string $group
     * @return array
     */
    public function getPropertiesByGroup($group): array
    {
        ksort($this->propertiesByGroup[$group], SORT_NATURAL);

        return isset($this->propertiesByGroup[$group]) ? $this->propertiesByGroup[$group] : [];
    }

    /**
     * @param string $group
     * @param string $key
     * @return string
     */
    private function getPropertyKeyByGroup($group, $key): string
    {
        return str_replace('/', '_', $group) . '_' . PhingService::camelCaseToUnderscore($key);
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function getPropertyValue($value): string
    {
        if (is_array($value)) {
            return implode(',', array_filter(array_map('trim', $value)));
        }

        return trim($value);
    }
}
