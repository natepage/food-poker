<?php
declare(strict_types=1);

namespace App\Helpers;

abstract class AbstractDataTransferObject
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * AbstractRepository constructor.
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        $data = $data ?? [];
        foreach ($this->initAttributes() as $attribute) {
            if (isset($data[$attribute])) {
                $this->data[$attribute] = $data[$attribute];
            }
        }
    }

    /**
     * Get value for given key or fallback to default.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Set value for given key.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return \App\Helpers\AbstractDataTransferObject
     */
    public function set(string $key, $value): self
    {
        if (\in_array($key, $this->initAttributes(), true) === false) {
            return $this;
        }

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get array representation.
     *
     * @param array|null $defaults
     *
     * @return array
     */
    public function toArray(?array $defaults = null): array
    {
        $array = [];
        $defaults = $defaults ?? [];

        foreach ($this->initAttributes() as $attribute) {
            $array[$attribute] = $this->get($attribute, $defaults[$attribute] ?? null);
        }

        return $array;
    }

    /**
     * Initiate attributes.
     *
     * @return array
     */
    abstract protected function initAttributes(): array;
}
