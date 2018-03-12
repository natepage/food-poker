<?php
declare(strict_types=1);

namespace App\Helpers\Interfaces;

interface RepositoryHelperInterface
{
    /**
     * Get value for given key or fallback to default.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Get array representation.
     *
     * @param array|null $defaults
     *
     * @return array
     */
    public function toArray(?array $defaults = null): array;
}
