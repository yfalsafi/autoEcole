<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Instructor
 *
 * @ORM\Table(name="instructor")
 * @ORM\Entity(repositoryClass="App\Repository\InstructorRepository")
 */
class Instructor
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
//    /**
//     * @ORM\OneToOne(targetEntity="App\Entity\Car", cascade={"persist", "remove"})
//     */
//    private $car;
//
//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Candidate", mappedBy="instructor")
//     */
//    private $candidates;
//
//    public function __construct()
//    {
//        parent::__construct();
//        $this->candidates = new ArrayCollection();
//    }
//
//    public function getCar(): ?Car
//    {
//        return $this->car;
//    }
//
//    public function setCar(?Car $car): self
//    {
//        $this->car = $car;
//
//        return $this;
//    }
//
//    /**
//     * @return Collection|Candidate[]
//     */
//    public function getCandidates(): Collection
//    {
//        return $this->candidates;
//    }
//
//    public function addCandidate(Candidate $candidate): self
//    {
//        if (!$this->candidates->contains($candidate)) {
//            $this->candidates[] = $candidate;
//            $candidate->setInstructor($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCandidate(Candidate $candidate): self
//    {
//        if ($this->candidates->contains($candidate)) {
//            $this->candidates->removeElement($candidate);
//            // set the owning side to null (unless already changed)
//            if ($candidate->getInstructor() === $this) {
//                $candidate->setInstructor(null);
//            }
//        }
//
//        return $this;
//    }
}
