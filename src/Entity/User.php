<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as Serializer;

/**
 * Users
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"user"})
     */
    protected $id;

    /**
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d{2,}).{6,}$/i", message="New password is required to be minimum 6 chars in length and to include at least one letter and one number.")
    */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"car","user", "planning"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"car","user","planning"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="date")
     * @Serializer\Groups({"user"})
     */
    private $birth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"user"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"user"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Groups({"user"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"user"})
     */
    private $registerAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="id")
     * @ORM\JoinColumn(name="instructor", referencedColumnName="id")
     * @Serializer\Groups({"user"})
     */
    private $instructor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Serializer\Groups({"user"})
     */
    private $isInstructor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="idc", orphanRemoval=true)
     */
    private $planningsC;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="idi", orphanRemoval=true)
     */
    private $planningsI;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Purchase", mappedBy="user", orphanRemoval=true)
     * @Serializer\Groups({"user"})
     */
    private $purchases;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"user"})
     */
    private $hoursDone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"user"})
     */
    private $hoursLeft;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Serializer\Groups({"user"})
     */
    private $IsAdmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pass", mappedBy="user", orphanRemoval=true)
     * @Serializer\Groups({"user"})
     */
    private $passes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="instructor")
     * @Serializer\Groups({"user"})
     */
    private $cars;




    public function __construct()
    {
        parent::__construct();
        $this->planningsC = new ArrayCollection();
        $this->planningsI = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->passes = new ArrayCollection();
        $this->cars = new ArrayCollection();
        // your own logic
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRegisterAt(): ?\DateTimeInterface
    {
        return $this->registerAt;
    }

    public function setRegisterAt(\DateTimeInterface $registerAt): self
    {
        $this->registerAt = $registerAt;

        return $this;
    }

    public function getInstructor(): ?User
    {
        return $this->instructor;
    }

    public function setInstructor(?User $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getIsInstructor(): ?bool
    {
        return $this->isInstructor;
    }

    public function setIsInstructor(?bool $isInstructor): self
    {
        $this->isInstructor = $isInstructor;

        return $this;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlanningsC(): Collection
    {
        return $this->planningsC;
    }

    public function addPlanningsC(Planning $planningsC): self
    {
        if (!$this->planningsC->contains($planningsC)) {
            $this->planningsC[] = $planningsC;
            $planningsC->setIdc($this);
        }

        return $this;
    }

    public function removePlanningsC(Planning $planningsC): self
    {
        if ($this->planningsC->contains($planningsC)) {
            $this->planningsC->removeElement($planningsC);
            // set the owning side to null (unless already changed)
            if ($planningsC->getIdc() === $this) {
                $planningsC->setIdc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlanningsI(): Collection
    {
        return $this->planningsI;
    }

    public function addPlanningsI(Planning $planningsI): self
    {
        if (!$this->planningsI->contains($planningsI)) {
            $this->planningsI[] = $planningsI;
            $planningsI->setIdi($this);
        }

        return $this;
    }

    public function removePlanningsI(Planning $planningsI): self
    {
        if ($this->planningsI->contains($planningsI)) {
            $this->planningsI->removeElement($planningsI);
            // set the owning side to null (unless already changed)
            if ($planningsI->getIdi() === $this) {
                $planningsI->setIdi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setUser($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->contains($purchase)) {
            $this->purchases->removeElement($purchase);
            // set the owning side to null (unless already changed)
            if ($purchase->getUser() === $this) {
                $purchase->setUser(null);
            }
        }

        return $this;
    }

    public function getHoursDone(): ?int
    {
        return $this->hoursDone;
    }

    public function setHoursDone(?int $hoursDone): self
    {
        $this->hoursDone = $hoursDone;

        return $this;
    }

    public function getHoursLeft(): ?int
    {
        return $this->hoursLeft;
    }

    public function setHoursLeft(?int $hoursLeft): self
    {
        $this->hoursLeft = $hoursLeft;

        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->IsAdmin;
    }

    public function setIsAdmin(?bool $IsAdmin): self
    {
        $this->IsAdmin = $IsAdmin;

        return $this;
    }

    /**
     * @return Collection|Pass[]
     */
    public function getPasses(): Collection
    {
        return $this->passes;
    }

    public function addPass(Pass $pass): self
    {
        if (!$this->passes->contains($pass)) {
            $this->passes[] = $pass;
            $pass->setUser($this);
        }

        return $this;
    }

    public function removePass(Pass $pass): self
    {
        if ($this->passes->contains($pass)) {
            $this->passes->removeElement($pass);
            // set the owning side to null (unless already changed)
            if ($pass->getUser() === $this) {
                $pass->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setInstructor($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->contains($car)) {
            $this->cars->removeElement($car);
            // set the owning side to null (unless already changed)
            if ($car->getInstructor() === $this) {
                $car->setInstructor(null);
            }
        }

        return $this;
    }






}
