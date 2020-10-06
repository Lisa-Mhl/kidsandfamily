<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="Cet email est déjà enregistré")
 */
class Newsletter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(max="50", maxMessage="Ce champ est trop long")
     * @Assert\Email(message="Veuillez entrer un email valide")
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
