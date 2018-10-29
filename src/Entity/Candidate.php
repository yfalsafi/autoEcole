<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity
 */
class Candidate
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCandidate", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcandidate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nameC", type="string", length=50, nullable=true)
     */
    private $namec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surnameC", type="string", length=50, nullable=true)
     */
    private $surnamec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adress", type="string", length=150, nullable=true)
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
     * @ORM\Column(name="registrationDate", type="date", nullable=true)
     */
    private $registrationdate;

    public function getIdcandidate(): ?int
    {
        return $this->idcandidate;
    }

    public function getNamec(): ?string
    {
        return $this->namec;
    }

    public function setNamec(?string $namec): self
    {
        $this->namec = $namec;

        return $this;
    }

    public function getSurnamec(): ?string
    {
        return $this->surnamec;
    }

    public function setSurnamec(?string $surnamec): self
    {
        $this->surnamec = $surnamec;

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

    public function getRegistrationdate(): ?\DateTimeInterface
    {
        return $this->registrationdate;
    }

    public function setRegistrationdate(?\DateTimeInterface $registrationdate): self
    {
        $this->registrationdate = $registrationdate;

        return $this;
    }


}
