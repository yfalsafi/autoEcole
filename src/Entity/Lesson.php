<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lesson
 *
 * @ORM\Table(name="lesson")
 * @ORM\Entity
 */
class Lesson
{
    /**
     * @var int
     *
     * @ORM\Column(name="idL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idl;

    public function getIdl(): ?int
    {
        return $this->idl;
    }


}
