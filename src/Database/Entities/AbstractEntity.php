<?php
declare(strict_types=1);

namespace App\Database\Entities;

use Doctrine\Common\Inflector\Inflector;

abstract class AbstractEntity
{
    /**
     * AbstractEntity constructor.
     *
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        $this->fill($data ?? []);
    }

    /**
     * Fill up entity with given data.
     *
     * @param array $data
     *
     * @return \App\Database\Entities\AbstractEntity
     */
    public function fill(array $data): self
    {
        foreach ($data as $property => $value) {
            $setter = \sprintf('set%s', Inflector::classify($property));

            if (\method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }

    /**
     * Get validation failed exception class.
     *
     * @return string
     */
    abstract public function getValidationFailedException(): string;
}
