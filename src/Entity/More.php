<?php

namespace App\Entity;

use App\Repository\MoreRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MoreRepository::class)
 * @Vich\Uploadable
 */
class More
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="more_logo", fileNameProperty="logo")
     *
     * @var File|null
     */
    private $logoFile;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkcgu;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cgu;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titlecgu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $politicstitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $politics;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }


    public function getLinkcgu(): ?string
    {
        return $this->linkcgu;
    }

    public function setLinkcgu(?string $linkcgu): self
    {
        $this->linkcgu = $linkcgu;

        return $this;
    }

    public function getCgu(): ?string
    {
        return $this->cgu;
    }

    public function setCgu(?string $cgu): self
    {
        $this->cgu = $cgu;

        return $this;
    }


    /**
     * @param File|UploadedFile|null $logoFile
     */
    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return File|null
     */
    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function getTitlecgu(): ?string
    {
        return $this->titlecgu;
    }

    public function setTitlecgu(?string $titlecgu): self
    {
        $this->titlecgu = $titlecgu;

        return $this;
    }

    public function getPoliticstitle(): ?string
    {
        return $this->politicstitle;
    }

    public function setPoliticstitle(?string $politicstitle): self
    {
        $this->politicstitle = $politicstitle;

        return $this;
    }

    public function getPolitics(): ?string
    {
        return $this->politics;
    }

    public function setPolitics(?string $politics): self
    {
        $this->politics = $politics;

        return $this;
    }
}
