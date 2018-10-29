<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instructor
 *
 * @ORM\Table(name="instructor")
 * @ORM\Entity
 */
class Instructor
{
    /**
     * @var int
     *
     * @ORM\Column(name="idInstructor", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idinstructor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nameI", type="string", length=50, nullable=true)
     */
    private $namei;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surnameI", type="string", length=50, nullable=true)
     */
    private $surnamei;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adress", type="string", length=250, nullable=true)
     */
    private $adress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="hiringDate", type="date", nullable=true)
     */
    private $hiringdate;

    public function getIdinstructor(): ?int
    {
        return $this->idinstructor;
    }

    public function getNamei(): ?string
    {
        return $this->namei;
    }

    public function setNamei(?string $namei): self
    {
        $this->namei = $namei;

        return $this;
    }

    public function getSurnamei(): ?string
    {
        return $this->surnamei;
    }

    public function setSurnamei(?string $surnamei): self
    {
        $this->surnamei = $surnamei;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getHiringdate(): ?\DateTimeInterface
    {
        return $this->hiringdate;
    }

    public function setHiringdate(?\DateTimeInterface $hiringdate): self
    {
        $this->hiringdate = $hiringdate;

        return $this;
    }


}
