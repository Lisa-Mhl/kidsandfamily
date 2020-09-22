<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @Vich\Uploadable
 */
class Category
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="category")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="category_poster", fileNameProperty="poster")
     *
     * @var File|null
     */
    private $posterFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     */
    private $updatedAt;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param File|UploadedFile|null $posterFile
     */
    public function setPosterFile(?File $posterFile = null): void
    {
        $this->posterFile = $posterFile;

        if (null !== $posterFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }
    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            $article->removeCategory($this);
        }

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }


    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * @return DateTimeImmutable|DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeImmutable|null $updatedAt
     */
    public function setUpdatedAt(?DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
