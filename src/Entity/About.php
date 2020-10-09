<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AboutRepository::class)
 * @Vich\Uploadable
 */
class About
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
    private $presentationTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $presentationBody;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $presentationVideo;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_video", fileNameProperty="presentationVideo")
     *
     * @var File|null
     */
    private $presentationVideoFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $visionTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $visionBody;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $visionImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_vision", fileNameProperty="visionImg")
     *
     * @var File|null
     */
    private $visionImgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valuesTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $valuesBody;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $servicesTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_local", fileNameProperty="localImg")
     *
     * @var File|null
     */
    private $localImgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $messageTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $messageImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_message", fileNameProperty="messageImg")
     *
     * @var File|null
     */
    private $messageImgFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dealsImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_deals", fileNameProperty="dealsImg")
     *
     * @var File|null
     */
    private $dealsImgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dealsTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eventImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_event", fileNameProperty="eventImg")
     *
     * @var File|null
     */
    private $eventImgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $helpImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_help", fileNameProperty="helpImg")
     *
     * @var File|null
     */
    private $helpImgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $helpTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $giveTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $giveImg;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="about_give", fileNameProperty="giveImg")
     *
     * @var File|null
     */
    private $giveImgFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $communityTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $communityBody;

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

    public function getPresentationTitle(): ?string
    {
        return $this->presentationTitle;
    }

    public function setPresentationTitle(string $presentationTitle): self
    {
        $this->presentationTitle = $presentationTitle;

        return $this;
    }

    public function getPresentationBody(): ?string
    {
        return $this->presentationBody;
    }

    public function setPresentationBody(string $presentationBody): self
    {
        $this->presentationBody = $presentationBody;

        return $this;
    }

    public function getPresentationVideo(): ?string
    {
        return $this->presentationVideo;
    }

    public function setPresentationVideo(?string $presentationVideo): self
    {
        $this->presentationVideo = $presentationVideo;

        return $this;
    }

    public function getVisionTitle(): ?string
    {
        return $this->visionTitle;
    }

    public function setVisionTitle(string $visionTitle): self
    {
        $this->visionTitle = $visionTitle;

        return $this;
    }

    public function getVisionBody(): ?string
    {
        return $this->visionBody;
    }

    public function setVisionBody(string $visionBody): self
    {
        $this->visionBody = $visionBody;

        return $this;
    }

    public function getVisionImg(): ?string
    {
        return $this->visionImg;
    }

    public function setVisionImg(?string $visionImg): self
    {
        $this->visionImg = $visionImg;

        return $this;
    }

    public function getValuesTitle(): ?string
    {
        return $this->valuesTitle;
    }

    public function setValuesTitle(string $valuesTitle): self
    {
        $this->valuesTitle = $valuesTitle;

        return $this;
    }

    public function getValuesBody(): ?string
    {
        return $this->valuesBody;
    }

    public function setValuesBody(string $valuesBody): self
    {
        $this->valuesBody = $valuesBody;

        return $this;
    }

    public function getServicesTitle(): ?string
    {
        return $this->servicesTitle;
    }

    public function setServicesTitle(string $servicesTitle): self
    {
        $this->servicesTitle = $servicesTitle;

        return $this;
    }

    public function getLocalImg(): ?string
    {
        return $this->localImg;
    }

    public function setLocalImg(?string $localImg): self
    {
        $this->localImg = $localImg;

        return $this;
    }

    public function getLocalTitle(): ?string
    {
        return $this->localTitle;
    }

    public function setLocalTitle(string $localTitle): self
    {
        $this->localTitle = $localTitle;

        return $this;
    }

    public function getMessageTitle(): ?string
    {
        return $this->messageTitle;
    }

    public function setMessageTitle(string $messageTitle): self
    {
        $this->messageTitle = $messageTitle;

        return $this;
    }

    public function getMessageImg(): ?string
    {
        return $this->messageImg;
    }

    public function setMessageImg(?string $messageImg): self
    {
        $this->messageImg = $messageImg;

        return $this;
    }

    public function getDealsImg(): ?string
    {
        return $this->dealsImg;
    }

    public function setDealsImg(?string $dealsImg): self
    {
        $this->dealsImg = $dealsImg;

        return $this;
    }

    public function getDealsTitle(): ?string
    {
        return $this->dealsTitle;
    }

    public function setDealsTitle(string $dealsTitle): self
    {
        $this->dealsTitle = $dealsTitle;

        return $this;
    }

    public function getEventImg(): ?string
    {
        return $this->eventImg;
    }

    public function setEventImg(?string $eventImg): self
    {
        $this->eventImg = $eventImg;

        return $this;
    }

    public function getEventTitle(): ?string
    {
        return $this->eventTitle;
    }

    public function setEventTitle(string $eventTitle): self
    {
        $this->eventTitle = $eventTitle;

        return $this;
    }

    public function getHelpImg(): ?string
    {
        return $this->helpImg;
    }

    public function setHelpImg(?string $helpImg): self
    {
        $this->helpImg = $helpImg;

        return $this;
    }

    public function getHelpTitle(): ?string
    {
        return $this->helpTitle;
    }

    public function setHelpTitle(string $helpTitle): self
    {
        $this->helpTitle = $helpTitle;

        return $this;
    }

    public function getGiveTitle(): ?string
    {
        return $this->giveTitle;
    }

    public function setGiveTitle(string $giveTitle): self
    {
        $this->giveTitle = $giveTitle;

        return $this;
    }

    public function getGiveImg(): ?string
    {
        return $this->giveImg;
    }

    public function setGiveImg(?string $giveImg): self
    {
        $this->giveImg = $giveImg;

        return $this;
    }

    public function getCommunityTitle(): ?string
    {
        return $this->communityTitle;
    }

    public function setCommunityTitle(string $communityTitle): self
    {
        $this->communityTitle = $communityTitle;

        return $this;
    }

    public function getCommunityBody(): ?string
    {
        return $this->communityBody;
    }

    public function setCommunityBody(string $communityBody): self
    {
        $this->communityBody = $communityBody;

        return $this;
    }

    /**
     * @param File|UploadedFile|null $presentationVideoFile
     */
    public function setPresentationVideoFile(?File $presentationVideoFile = null): void
    {
        $this->presentationVideoFile = $presentationVideoFile;

        if (null !== $presentationVideoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $visionImgFile
     */
    public function setVisionImgFile(?File $visionImgFile = null): void
    {
        $this->visionImgFile = $visionImgFile;

        if (null !== $visionImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $localImgFile
     */
    public function setLocalImgFile(?File $localImgFile = null): void
    {
        $this->localImgFile = $localImgFile;

        if (null !== $localImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $dealsImgFile
     */
    public function setDealsImgFile(?File $dealsImgFile = null): void
    {
        $this->dealsImgFile = $dealsImgFile;

        if (null !== $dealsImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $messageImgFile
     */
    public function setMessageImgFile(?File $messageImgFile = null): void
    {
        $this->messageImgFile = $messageImgFile;

        if (null !== $messageImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $eventImgFile
     */
    public function setEventImgFile(?File $eventImgFile = null): void
    {
        $this->eventImgFile = $eventImgFile;

        if (null !== $eventImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $helpImgFile
     */
    public function setHelpImgFile(?File $helpImgFile = null): void
    {
        $this->helpImgFile = $helpImgFile;

        if (null !== $helpImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $giveImgFile
     */
    public function setGiveImgFile(?File $giveImgFile = null): void
    {
        $this->giveImgFile = $giveImgFile;

        if (null !== $giveImgFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }
    /**
     * @return File|null
     */
    public function getPresentationVideoFile(): ?File
    {
        return $this->presentationVideoFile;
    }

    /**
     * @return File|null
     */
    public function getVisionImgFile(): ?File
    {
        return $this->visionImgFile;
    }

    /**
     * @return File|null
     */
    public function getLocalImgFile(): ?File
    {
        return $this->localImgFile;
    }

    /**
     * @return File|null
     */
    public function getDealsImgFile(): ?File
    {
        return $this->dealsImgFile;
    }

    /**
     * @return File|null
     */
    public function getMessageImgFile(): ?File
    {
        return $this->messageImgFile;
    }

    /**
     * @return File|null
     */
    public function getEventImgFile(): ?File
    {
        return $this->eventImgFile;
    }

    /**
     * @return File|null
     */
    public function getHelpImgFile(): ?File
    {
        return $this->helpImgFile;
    }

    /**
     * @return File|null
     */
    public function getGiveImgFile(): ?File
    {
        return $this->giveImgFile;
    }
}
