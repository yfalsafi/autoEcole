<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"mail"},
 *     message="Mail already exist"
 * )
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=200, nullable=true)
     */
    private $mail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=250, nullable=true)
     * @Assert\Length(min="8")
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="roles", type="string", length=50, nullable=true)
     */
    private $roles;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Not same password")
     */
    public $confirm_password;
    /**
     * @Assert\EqualTo(propertyPath="mail",message="Not same mail")
     */
    public $username;

    public function __construct()
    {

    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $mail): self
    {
        $this->username = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function setUserRole(?string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

//    public function getRoles()
//    {
//        // TODO: Implement getRoles() method.
//        return ['ROLE_USER'];
//    }
     public function serialize()
    {
        return serialize([
            $this->idUser,
            $this->mail,
            $this->password
        ]);
    }
     public function unserialize($serialized)
        {
            list(
                $this->idUser,
                $this->mail,
                $this->password
                ) = unserialize($serialized, ['allowed_classes'=>false]);
        }




}
