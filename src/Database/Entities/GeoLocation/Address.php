<?php
declare(strict_types=1);

namespace App\Database\Entities\GeoLocation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="geolocation_addresses")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $addressId;

    /**
     * @ORM\Column(name="formatted_address", type="string")
     *
     * @var string
     */
    private $formattedAddress;

    /**
     * @ORM\Column(name="latitude", type="string")
     *
     * @var string
     */
    private $latitude;

    /**
     * @ORM\Column(name="longitude", type="string")
     *
     * @var string
     */
    private $longitude;

    /**
     * @ORM\Column(name="slug", type="string")
     *
     * @var string
     */
    private $slug;

    /**
     * Get formatted address.
     *
     * @return string
     */
    public function getFormattedAddress(): ?string
    {
        return $this->formattedAddress;
    }

    /**
     * Get id.
     *
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->addressId;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set formatted address.
     *
     * @param string $formattedAddress
     *
     * @return Address
     */
    public function setFormattedAddress(string $formattedAddress): Address
    {
        $this->formattedAddress = $formattedAddress;

        return $this;
    }

    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return Address
     */
    public function setLatitude(string $latitude): Address
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Set longitude.
     *
     * @param string $longitude
     *
     * @return Address
     */
    public function setLongitude(string $longitude): Address
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Address
     */
    public function setSlug(string $slug): Address
    {
        $this->slug = $slug;

        return $this;
    }
}
