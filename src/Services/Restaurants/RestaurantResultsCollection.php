<?php
declare(strict_types=1);

namespace App\Services\Restaurants;

use App\Helpers\AbstractCollection;
use App\Services\Restaurants\Interfaces\RestaurantResultInterface;
use App\Services\Restaurants\Interfaces\RestaurantResultsCollectionInterface;

class RestaurantResultsCollection extends AbstractCollection implements RestaurantResultsCollectionInterface
{
    /**
     * RestaurantResultsCollection constructor.
     *
     * @param array|null $elements
     */
    public function __construct(?array $elements = null)
    {
        $results = [];

        foreach ($elements ?? [] as $element) {
            if ($element instanceof RestaurantResultInterface) {
                $results[] = $element;
            }

            if (\is_array($element)) {
                $results[] = new RestaurantResult($element);
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
            /** @var \App\Services\Restaurants\Interfaces\RestaurantResultInterface $restaurant */
            $array[] = $restaurant->toArray();
        }

        return $array;
    }
}
