<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractCollection;
use App\Services\Restaurants\Interfaces\ResultInterface;
use App\Services\Restaurants\Interfaces\ResultsCollectionInterface;

class ResultsCollection extends AbstractCollection implements ResultsCollectionInterface
{
    /**
     * ResultsCollection constructor.
     *
     * @param array|null $elements
     */
    public function __construct(?array $elements = null)
    {
        $results = [];

        foreach ($elements ?? [] as $element) {
            if ($element instanceof ResultInterface) {
                $results[] = $element;
            }

            if (\is_array($element)) {
                $results[] = new Result($element);
            }
        }

        parent::__construct($results);
    }

    /**
     * Get array representation of each restaurant result.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach (parent::toArray() as $restaurant) {
            /** @var \App\Services\Restaurants\Interfaces\ResultInterface $restaurant */
            $array[] = $restaurant->toArray();
        }

        return $array;
    }
}
