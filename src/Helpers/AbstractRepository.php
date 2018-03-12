<?php
declare(strict_types=1);

namespace App\Helpers;

abstract class AbstractRepository
{
    /**
     * @var array
     */
    protected $attributes = [];

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
        foreach ($this->attributes as $attribute) {
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

        foreach ($this->attributes as $attribute) {
            $array[$attribute] = $this->get($attribute, $defaults[$attribute] ?? null);
        }

        return $array;
    }
}
