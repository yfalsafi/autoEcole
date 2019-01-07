<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 *
 * @ORM\Table(name="planning")
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning
{
    /**
     * @var int
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idc;

    /**
     * @var int
     *
     * @ORM\Column(name="idI", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idi;

    /**
     * @var int
     *
     * @ORM\Column(name="idL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Lesson")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idl", referencedColumnName="idl")
     * })
     */
    private $idl;

    public function getIdc(): ?int
    {
        return $this->idc;
    }

    public function getIdi(): ?int
    {
        return $this->idi;
    }

    public function getIdl(): ?int
    {
        return $this->idl;
    }

    public function setIdc(int $idc): self
    {
        $this->idc=$idc;
        return $this;
    }

    public function setIdi(int $idi): self
    {
        $this->idi=$idi;
        return $this;
    }

    public function setIdl(int $idl): self
    {
        $this->idl=$idl;
        return $this;
    }



}
