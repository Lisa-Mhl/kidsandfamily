<?php

namespace App\Entity;

use App\Repository\ContributeRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ContributeRepository::class)
 * @Vich\Uploadable
 */
class Contribute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step1Title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $step1Img;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="contribute_step1", fileNameProperty="step1Img")
     *
     * @var File|null
     */
    private $step1ImgFile;

    /**
     * @ORM\Column(type="text")
     */
    private $step1Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step2Title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $step2Img;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="contribute_step2", fileNameProperty="step2Img")
     *
     * @var File|null
     */
    private $step2ImgFile;

    /**
     * @ORM\Column(type="text")
     */
    private $step2Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step3Title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $step3Img;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="contribute_step3", fileNameProperty="step3Img")
     *
     * @var File|null
     */
    private $step3ImgFile;

    /**
     * @ORM\Column(type="text")
     */
    private $step3Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step4Title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $step4Img;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="contribute_step4", fileNameProperty="step4Img")
     *
     * @var File|null
     */
    private $step4ImgFile;

    /**
     * @ORM\Column(type="text")
     */
    private $step4Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contributeTitle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStep1Title(): ?string
    {
        return $this->step1Title;
    }

    public function setStep1Title(string $step1Title): self
    {
        $this->step1Title = $step1Title;

        return $this;
    }

    public function getStep1Img(): ?string
    {
        return $this->step1Img;
    }

    public function setStep1Img(?string $step1Img): self
    {
        $this->step1Img = $step1Img;

        return $this;
    }

    public function getStep1Body(): ?string
    {
        return $this->step1Body;
    }

    public function setStep1Body(string $step1Body): self
    {
        $this->step1Body = $step1Body;

        return $this;
    }

    public function getStep2Title(): ?string
    {
        return $this->step2Title;
    }

    public function setStep2Title(string $step2Title): self
    {
        $this->step2Title = $step2Title;

        return $this;
    }

    public function getStep2Img(): ?string
    {
        return $this->step2Img;
    }

    public function setStep2Img(?string $step2Img): self
    {
        $this->step2Img = $step2Img;

        return $this;
    }

    public function getStep2Body(): ?string
    {
        return $this->step2Body;
    }

    public function setStep2Body(string $step2Body): self
    {
        $this->step2Body = $step2Body;

        return $this;
    }

    public function getStep3Title(): ?string
    {
        return $this->step3Title;
    }

    public function setStep3Title(string $step3Title): self
    {
        $this->step3Title = $step3Title;

        return $this;
    }

    public function getStep3Img(): ?string
    {
        return $this->step3Img;
    }

    public function setStep3Img(?string $step3Img): self
    {
        $this->step3Img = $step3Img;

        return $this;
    }

    public function getStep3Body(): ?string
    {
        return $this->step3Body;
    }

    public function setStep3Body(string $step3Body): self
    {
        $this->step3Body = $step3Body;

        return $this;
    }

    public function getStep4Title(): ?string
    {
        return $this->step4Title;
    }

    public function setStep4Title(string $step4Title): self
    {
        $this->step4Title = $step4Title;

        return $this;
    }

    public function getStep4Img(): ?string
    {
        return $this->step4Img;
    }

    public function setStep4Img(?string $step4Img): self
    {
        $this->step4Img = $step4Img;

        return $this;
    }

    public function getStep4Body(): ?string
    {
        return $this->step4Body;
    }

    public function setStep4Body(string $step4Body): self
    {
        $this->step4Body = $step4Body;

        return $this;
    }

    public function getContributeTitle(): ?string
    {
        return $this->contributeTitle;
    }

    public function setContributeTitle(string $contributeTitle): self
    {
        $this->contributeTitle = $contributeTitle;

        return $this;
    }

    /**
     * @param File|UploadedFile|null $step1ImgFile
     */
    public function setStep1ImgFile(?File $step1ImgFile = null): void
    {
        $this->step1ImgFile = $step1ImgFile;

        if (null !== $step1ImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $step2ImgFile
     */
    public function setStep2ImgFile(?File $step2ImgFile = null): void
    {
        $this->step2ImgFile = $step2ImgFile;

        if (null !== $step2ImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $step3ImgFile
     */
    public function setStep3ImgFile(?File $step3ImgFile = null): void
    {
        $this->step3ImgFile = $step3ImgFile;

        if (null !== $step3ImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $step4ImgFile
     */
    public function setStep4ImgFile(?File $step4ImgFile = null): void
    {
        $this->step4ImgFile = $step4ImgFile;

        if (null !== $step4ImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @return File|null
     */
    public function getStep1ImgFile(): ?File
    {
        return $this->step1ImgFile;
    }

    /**
     * @return File|null
     */
    public function getStep2ImgFile(): ?File
    {
        return $this->step2ImgFile;
    }

    /**
     * @return File|null
     */
    public function getStep3ImgFile(): ?File
    {
        return $this->step3ImgFile;
    }

    /**
     * @return File|null
     */
    public function getStep4ImgFile(): ?File
    {
        return $this->step4ImgFile;
    }
}
