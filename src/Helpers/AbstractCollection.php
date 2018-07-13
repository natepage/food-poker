<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Interfaces\CollectionHelperInterface;
use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractCollection extends ArrayCollection implements CollectionHelperInterface
{
    /**
     * Returns restaurant results randomly.
     *
     * @param int|null $number
     *
     * @return self
     */
    public function random(?int $number = null): CollectionHelperInterface
    {
        // If collection empty, returns it
        if (empty($this->getIterator()->getArrayCopy())) {
            return $this;
        }

        $number = $number ?? 1;

        // If number is 0, returns empty collection
        if (0 === $number) {
            return new static();
        }
        // If number is 1, returns collection with only one result
        if (1 === $number) {
            return new static([$this->get(\array_rand($this->getIterator()->getArrayCopy(), $number))]);
        }
        // If number greater than count, returns full collection
        if ($number > $this->count()) {
            return $this;
        }
        // Otherwise return new collection with random results
        $randoms = [];
        foreach (\array_rand($this->getIterator()->getArrayCopy(), $number) as $key) {
            $randoms[] = $this->get($key);
        }

        return new static($randoms);
    }
}
