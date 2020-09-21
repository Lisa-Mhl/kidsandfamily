<?php

namespace App\Entity;

use App\Repository\HomepageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomepageRepository::class)
 */
class Homepage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $goalTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $goalBody;

    /**
     * @ORM\Column(type="text")
     */
    private $targetTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $targetBody;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $targetImgFam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $targetImgPlace;

    /**
     * @ORM\Column(type="text")
     */
    private $approachTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $approachSubTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $approachBody;

    /**
     * @ORM\Column(type="text")
     */
    private $sectionTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sectionImg;

    /**
     * @ORM\Column(type="text")
     */
    private $sectionBody;

    /**
     * @ORM\Column(type="text")
     */
    private $targetTitle1;

    /**
     * @ORM\Column(type="text")
     */
    private $targetTitle2;

    /**
     * @ORM\Column(type="text")
     */
    private $targetBody2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $banner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGoalTitle(): ?string
    {
        return $this->goalTitle;
    }

    public function setGoalTitle(string $goalTitle): self
    {
        $this->goalTitle = $goalTitle;

        return $this;
    }

    public function getGoalBody(): ?string
    {
        return $this->goalBody;
    }

    public function setGoalBody(string $goalBody): self
    {
        $this->goalBody = $goalBody;

        return $this;
    }

    public function getTargetTitle(): ?string
    {
        return $this->targetTitle;
    }

    public function setTargetTitle(string $targetTitle): self
    {
        $this->targetTitle = $targetTitle;

        return $this;
    }

    public function getTargetBody(): ?string
    {
        return $this->targetBody;
    }

    public function setTargetBody(string $targetBody): self
    {
        $this->targetBody = $targetBody;

        return $this;
    }

    public function getTargetImgFam(): ?string
    {
        return $this->targetImgFam;
    }

    public function setTargetImgFam(string $targetImgFam): self
    {
        $this->targetImgFam = $targetImgFam;

        return $this;
    }

    public function getTargetImgPlace(): ?string
    {
        return $this->targetImgPlace;
    }

    public function setTargetImgPlace(string $targetImgPlace): self
    {
        $this->targetImgPlace = $targetImgPlace;

        return $this;
    }

    public function getApproachTitle(): ?string
    {
        return $this->approachTitle;
    }

    public function setApproachTitle(string $approachTitle): self
    {
        $this->approachTitle = $approachTitle;

        return $this;
    }

    public function getApproachSubTitle(): ?string
    {
        return $this->approachSubTitle;
    }

    public function setApproachSubTitle(string $approachSubTitle): self
    {
        $this->approachSubTitle = $approachSubTitle;

        return $this;
    }

    public function getApproachBody(): ?string
    {
        return $this->approachBody;
    }

    public function setApproachBody(string $approachBody): self
    {
        $this->approachBody = $approachBody;

        return $this;
    }

    public function getSectionTitle(): ?string
    {
        return $this->sectionTitle;
    }

    public function setSectionTitle(string $sectionTitle): self
    {
        $this->sectionTitle = $sectionTitle;

        return $this;
    }

    public function getSectionImg(): ?string
    {
        return $this->sectionImg;
    }

    public function setSectionImg(string $sectionImg): self
    {
        $this->sectionImg = $sectionImg;

        return $this;
    }

    public function getSectionBody(): ?string
    {
        return $this->sectionBody;
    }

    public function setSectionBody(string $sectionBody): self
    {
        $this->sectionBody = $sectionBody;

        return $this;
    }

    public function getTargetTitle1(): ?string
    {
        return $this->targetTitle1;
    }

    public function setTargetTitle1(string $targetTitle1): self
    {
        $this->targetTitle1 = $targetTitle1;

        return $this;
    }

    public function getTargetTitle2(): ?string
    {
        return $this->targetTitle2;
    }

    public function setTargetTitle2(string $targetTitle2): self
    {
        $this->targetTitle2 = $targetTitle2;

        return $this;
    }

    public function getTargetBody2(): ?string
    {
        return $this->targetBody2;
    }

    public function setTargetBody2(string $targetBody2): self
    {
        $this->targetBody2 = $targetBody2;

        return $this;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;

        return $this;
    }
}
