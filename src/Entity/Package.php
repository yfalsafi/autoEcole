<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 *
 * @ORM\Table(name="package")
 * @ORM\Entity
 */
class Package
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price", type="integer", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPackage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbHours;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsPackage(): ?bool
    {
        return $this->isPackage;
    }

    public function setIsPackage(?bool $isPackage): self
    {
        $this->isPackage = $isPackage;

        return $this;
    }

    public function getNbHours(): ?int
    {
        return $this->nbHours;
    }

    public function setNbHours(?int $nbHours): self
    {
        $this->nbHours = $nbHours;

        return $this;
    }

}
