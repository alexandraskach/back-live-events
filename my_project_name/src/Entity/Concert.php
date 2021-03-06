<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ConcertRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ConcertRepository::class)
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "artiste": "exact",
 *         "style": "exact",
 *         "date": "exact",
 *         "scene": "exact"
 *     }
 * )
 * @ApiResource(
 *     attributes={"order"={"date": "DESC"}},
 *     itemOperations={
 *         "get"={
 *           "normalization_context"={
 *             "groups"={"get_concert_with_image"}
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
class Concert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_concert_with_image"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=20)
     * @Groups({"post","get_concert_with_image"})
     */
    private $artiste;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=20)
     * @Groups({"post", "get_concert_with_image"})
     */
    private $style;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Length(max=2)
     * @Groups({"post", "get_concert_with_image"})
     */
    private $scene;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"post", "get_concert_with_image"})
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="Image")
     * @ORM\JoinTable()
     * @ApiSubresource()
     * @Groups({"post","get_concert_with_image"})
    */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->date = new \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(string $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getScene(): ?int
    {
        return $this->scene;
    }

    public function setScene(int $scene): self
    {
        $this->scene = $scene;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self {
        $this->date = $date;
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

  
}
