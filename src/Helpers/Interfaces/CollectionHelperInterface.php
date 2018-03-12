<?php
declare(strict_types=1);

namespace App\Helpers\Interfaces;

use Doctrine\Common\Collections\Collection;

interface CollectionHelperInterface extends Collection
{
    /**
     * Returns restaurant results randomly.
     *
     * @param int|null $number
     *
     * @return self
     */
    public function random(?int $number = null): self;
}
