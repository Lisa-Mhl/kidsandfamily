<?php

namespace App\Entity;

use App\Repository\ContributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContributeRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $step1Img;

    /**
     * @ORM\Column(type="text")
     */
    private $step1Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step2Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step2Img;

    /**
     * @ORM\Column(type="text")
     */
    private $step2Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step3Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step3Img;

    /**
     * @ORM\Column(type="text")
     */
    private $step3Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step4Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $step4Img;

    /**
     * @ORM\Column(type="text")
     */
    private $step4Body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contributeTitle;

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

    public function setStep1Img(string $step1Img): self
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

    public function setStep2Img(string $step2Img): self
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

    public function setStep3Img(string $step3Img): self
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

    public function setStep4Img(string $step4Img): self
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
}
