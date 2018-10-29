<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car", indexes={@ORM\Index(name="idI", columns={"idI"})})
 * @ORM\Entity
 */
class Car
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCar", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idcar;

    /**
     * @var int
     *
     * @ORM\Column(name="idI", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idi;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="purchaseDate", type="date", nullable=true)
     */
    private $purchasedate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="km", type="integer", nullable=true)
     */
    private $km;

    public function getIdcar(): ?int
    {
        return $this->idcar;
    }

    public function getIdi(): ?int
    {
        return $this->idi;
    }

    public function getPurchasedate(): ?\DateTimeInterface
    {
        return $this->purchasedate;
    }

    public function setPurchasedate(?\DateTimeInterface $purchasedate): self
    {
        $this->purchasedate = $purchasedate;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(?int $km): self
    {
        $this->km = $km;

        return $this;
    }


}
