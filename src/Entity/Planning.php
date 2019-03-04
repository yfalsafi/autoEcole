<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="planningsC")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="planningsI")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson")
     */
    private $idl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdc(): ?User
    {
        return $this->idc;
    }

    public function setIdc(?User $idc): self
    {
        $this->idc = $idc;

        return $this;
    }

    public function getIdi(): ?User
    {
        return $this->idi;
    }

    public function setIdi(?User $idi): self
    {
        $this->idi = $idi;

        return $this;
    }

    public function getIdl(): ?Lesson
    {
        return $this->idl;
    }

    public function setIdl(?Lesson $idl): self
    {
        $this->idl = $idl;

        return $this;
    }
}
