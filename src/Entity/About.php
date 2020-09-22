<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AboutRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $localImg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $messageTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $messageImg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dealsImg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dealsTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventImg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eventTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $helpImg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $helpTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $giveTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $giveImg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $communityTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $communityBody;

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

    public function setLocalImg(string $localImg): self
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

    public function setMessageImg(string $messageImg): self
    {
        $this->messageImg = $messageImg;

        return $this;
    }

    public function getDealsImg(): ?string
    {
        return $this->dealsImg;
    }

    public function setDealsImg(string $dealsImg): self
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

    public function setEventImg(string $eventImg): self
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

    public function setHelpImg(string $helpImg): self
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

    public function setGiveImg(string $giveImg): self
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
}
