<?php
declare(strict_types=1);

class Bundles {
    /**
     * Get bundles array.
     *
     * @return array
     */
    public function getBundles(): array
    {
        return [
            Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true]
        ];
    }
}
