<?php
declare(strict_types=1);

namespace App\Database\Entities;

use App\Interfaces\EntityInterface;
use Doctrine\Common\Inflector\Inflector;

abstract class AbstractEntity implements EntityInterface
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
     * @return \App\Interfaces\EntityInterface
     */
    public function fill(array $data): EntityInterface
    {
        foreach ($data as $property => $value) {
            $setter = \sprintf('set%s', Inflector::classify($property));

            if (\method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        return $this;
    }
}
