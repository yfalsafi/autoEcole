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
     * @var int
     *
     * @ORM\Column(name="id_instructor", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idInstructor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=50, nullable=true)
     */
    private $surname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=50, nullable=true)
     */
    private $firstname;

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
    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=true)
     */
    private $status;

    /**
     * @var User
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="instructor")
     */
    private $users;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getIdInstructor(): ?int
    {
        return $this->idInstructor;
    }
    public function setIdInstructor(?int $idInstructor): self
    {
        $this->idInstructor= $idInstructor;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setInstructor($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getInstructor() === $this) {
                $user->setInstructor(null);
            }
        }

        return $this;
    }



}
