<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Actualite;
use App\Entity\Users;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ApiResource(
 *  *     attributes={
 *         "order"={"published": "DESC"},
 *         "pagination_client_enabled"=true,
 *         "pagination_client_items_per_page"=true
 *     }, 
 *      collectionOperations={
 *      "get",
 *      "post"={
 *        "access_control"="is_granted('ROLE_COMMENTATOR')",
 *         "normalization_context"= 
 *             {
 *                 "groups"={"get_comment_with_author"}
 *             }
 *       }
 *      },
 *     itemOperations={
 *       "get",
 *       "put"={
 *         "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getAuthor() == user"
 *        }
 *     },
 *     denormalizationContext={
 *      "groups"={"post"} 
 *     },
 *      subresourceOperations={
 *       "api_actualites_comments_get_subresource"={
 *           "normalization_context"={
 *             "groups"={"get_comment_with_author"}
 *            }
 *         }
 *       }
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment implements PublishedDateEntityInterface, AuthoredEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get_comment_with_author"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"post", "get_comment_with_author"})
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get_comment_with_author"})
     */
    private $published;

     /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get_comment_with_author"})
     */
    private $author;

      /**
     * @ORM\ManyToOne(targetEntity="Actualite", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post"})
     */
    private $actualite;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setDate(\DateTimeInterface $published): PublishedDateEntityInterface
    {
        $this->published = $published;

        return $this;
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

    public function getActualite(): ?Actualite
    {
        return $this->actualite;
    }

    public function setActualite(Actualite $actualite): self
    {
        $this->actualite = $actualite;

        return $this;
    }

    public function __toString()
    {
        return substr($this->content, 0, 20) . '...';
    }

}


