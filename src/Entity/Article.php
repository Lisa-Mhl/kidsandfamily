<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository", repositoryClass=ArticleRepository::class)
 * @Vich\Uploadable
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Veuillez ajouter un titre à votre publication")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $classification;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de sélectionner une adresse afin de pouvoir géolocaliser votre publication")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de sélectionner un type de projet")
     */
    private $heading;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_photo", fileNameProperty="photo")
     *
     * @var File|null
     */
    private $photoFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_video", fileNameProperty="video")
     *
     * @var File|null
     */
    private $videoFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pdf;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_pdf", fileNameProperty="pdf")
     *
     * @var File|null
     */
    private $pdfFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $needs;

    /**
     * @ORM\ManyToOne(targetEntity=Target::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez sélectionner le public visé par votre publication")
     */
    private $target;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="articles")
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull(message="Votre publication doit comprendre une description")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoB;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_photoB", fileNameProperty="photoB")
     *
     * @var File|null
     */
    private $photoBFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoC;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="article_photoC", fileNameProperty="photoC")
     *
     * @var File|null
     */
    private $photoCFile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity=Report::class, mappedBy="article", cascade={"remove"})
     */
    private $reports;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="float", scale=4, precision=6)
     * @Groups({"article"})
     */
    private $lat;

    /**
     * @ORM\Column(type="float", scale=4, precision=7)
     * @Groups({"article"})
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Groups({"article"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\OneToMany(targetEntity=ArticleLike::class, mappedBy="article", cascade={"remove"})
     */
    private $likes;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getClassification(): ?bool
    {
        return $this->classification;
    }

    public function setClassification(bool $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function setHeading(string $heading): self
    {
        $this->heading = $heading;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(?string $pdf): self
    {
        $this->pdf = $pdf;

        return $this;
    }

    public function getNeeds(): ?string
    {
        return $this->needs;
    }

    public function setNeeds(?string $needs): self
    {
        $this->needs = $needs;

        return $this;
    }

    public function getTarget(): ?Target
    {
        return $this->target;
    }

    public function setTarget(?Target $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
        }

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPhotoB(): ?string
    {
        return $this->photoB;
    }

    public function setPhotoB(?string $photoB): self
    {
        $this->photoB = $photoB;

        return $this;
    }

    public function getPhotoC(): ?string
    {
        return $this->photoC;
    }

    public function setPhotoC(?string $photoC): self
    {
        $this->photoC = $photoC;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }


    /**
     * @param File|UploadedFile|null $photoFile
     */
    public function setPhotoFile(?File $photoFile = null): void
    {
        $this->photoFile = $photoFile;

        if (null !== $photoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $videoFile
     */
    public function setVideoFile(?File $videoFile = null): void
    {
        $this->videoFile = $videoFile;

        if (null !== $videoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $pdfFile
     */
    public function setPdfFile(?File $pdfFile = null): void
    {
        $this->pdfFile = $pdfFile;

        if (null !== $pdfFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $photoBFile
     */
    public function setPhotoBFile(?File $photoBFile = null): void
    {
        $this->photoBFile = $photoBFile;

        if (null !== $photoBFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @param File|UploadedFile|null $photoCFile
     */
    public function setPhotoCFile(?File $photoCFile= null): void
    {
        $this->photoCFile = $photoCFile;

        if (null !== $photoCFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection|Report[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setArticle($this);
        }

        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->contains($report)) {
            $this->reports->removeElement($report);
            // set the owning side to null (unless already changed)
            if ($report->getArticle() === $this) {
                $report->setArticle(null);
            }
        }
        return $this;
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
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @return File|null
     */
    public function getPdfFile(): ?File
    {
        return $this->pdfFile;
    }

    /**
     * @return File|null
     */
    public function getVideoFile(): ?File
    {
        return $this->videoFile;
    }

    /**
     * @return File|null
     */
    public function getPhotoBFile(): ?File
    {
        return $this->photoBFile;
    }

    /**
     * @return File|null
     */
    public function getPhotoCFile(): ?File
    {
        return $this->photoCFile;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection|ArticleLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(ArticleLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setArticle($this);
        }

        return $this;
    }

    public function removeLike(ArticleLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getArticle() === $this) {
                $like->setArticle(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
