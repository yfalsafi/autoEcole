<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 *
 * @ORM\Table(name="planning")
 * @ORM\Entity
 */
class Planning
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure", type="date", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $departure;

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
     */
    private $idl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end", type="date", nullable=true)
     */
    private $end;

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

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

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }


}
