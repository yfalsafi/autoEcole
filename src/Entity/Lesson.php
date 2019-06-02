<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AssertB;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonRepository")
 */
class Lesson
{

    const DRIVEHOUR = 15;
    const MAXKMUSED = 50000;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     * @Assert\GreaterThan("now")
     * @AssertB\CheckDatetime
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"planning"})
     *
     */
    private $startAt;

    /**
     * @var \DateTime
     * @Assert\Expression(
     *     "this.getEndAt() > this.getStartAt()",
     *     message="The End start before or at the same time that the Start"
     * )
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"planning"})
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=1, nullable=false, options={"fixed"=true})
     * @Serializer\Groups({"planning"})
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

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
}
