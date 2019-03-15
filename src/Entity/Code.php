<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CodeRepository")
 */
class Code
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $A;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $B;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $C;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $D;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $answer;

    /**
     * @ORM\Column(type="text")
     */
    private $justification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getA(): ?string
    {
        return $this->A;
    }

    public function setA(string $A): self
    {
        $this->A = $A;

        return $this;
    }

    public function getB(): ?string
    {
        return $this->B;
    }

    public function setB(string $B): self
    {
        $this->B = $B;

        return $this;
    }

    public function getC(): ?string
    {
        return $this->C;
    }

    public function setC(?string $C): self
    {
        $this->C = $C;

        return $this;
    }

    public function getD(): ?string
    {
        return $this->D;
    }

    public function setD(?string $D): self
    {
        $this->D = $D;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getJustification(): ?string
    {
        return $this->justification;
    }

    public function setJustification(string $justification): self
    {
        $this->justification = $justification;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
