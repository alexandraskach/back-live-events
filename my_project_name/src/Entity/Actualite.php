<?php

namespace App\Entity;

use App\Repository\ActualiteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\AuthoredEntityInterface;


/**
 * @ORM\Entity(repositoryClass=ActualiteRepository::class)
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "title": "partial",
 *         "content": "partial",
 *         "author": "exact",
 *         "author.name": "partial"
 *     }
 * )
 * @ApiFilter(
 *     DateFilter::class,
 *     properties={
 *         "date"
 *     }
 * )
 * @ApiFilter(RangeFilter::class, properties={"id"})
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *         "id",
 *         "date",
 *         "title"
 *     },
 *     arguments={"orderParameterName"="_order"}
 * )
 * @ApiFilter(PropertyFilter::class, arguments={
 *     "parameterName": "properties",
 *     "overrideDefaultProperties": false,
 *     "whitelist": {"id", "slug", "title", "content", "author"}
 * })
 * @ApiResource(
 *     attributes={"order"={"date": "DESC"}, "maximum_items_per_page"=30},
 *     itemOperations={
 *         "get"={
 *           "normalization_context"={
 *             "groups"={"get_actualite_with_author"}
 *            }
 *         },
 *         "put"={
 *             "access_control"="is_granted('ROLE_EDITOR') or (is_granted('ROLE_WRITER') and object.getAuthor() == user)"
 *         }
 *      },
 *      collectionOperations={
 *         "get",
 *         "post"={
 *             "access_control"="is_granted('ROLE_WRITER')"
 *         },
 *      },
 *      denormalizationContext={
 *         "groups"={"post"}
 *     }
 * )
 */
class Actualite implements PublishedDateEntityInterface, AuthoredEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_actualite_with_author"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     * @Groups({"post", "get_actualite_with_author"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_actualite_with_author"})
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=20)
     * @Groups({"post", "get_actualite_with_author"})
     */
    private $content;

     /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="actualites")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_actualite_with_author"})
    */
    private $author;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"post", "get_actualite_with_author"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="actualite")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource()
     * @Groups({"get_actualite_with_author"})
    */
    private $comments;


    /**
     * @ORM\ManyToMany(targetEntity="Image")
     * @ORM\JoinTable()
     * @ApiSubresource()
     * @Groups({"post", "get_actualite_with_author"})
    */
    private $images;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();

    }
    
    public function getComments(): Collection
    {
        return $this->comments;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): PublishedDateEntityInterface
    {
        $this->date = $date;

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
    
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

  /**
     * @return Users
     */
    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    /**
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author): AuthoredEntityInterface
    {
        $this->author = $author;

        return $this;
    }

  public function getImages(): Collection
  {
      return $this->images;
  }

  public function addImage(Image $image)
  {
      $this->images->add($image);
  }

  public function removeImage(Image $image)
  {
      $this->images->removeElement($image);
  }

  public function __toString(): string
  {
      return $this->title;
  }

    	

}
