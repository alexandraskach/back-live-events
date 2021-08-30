<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;


/**
 * @ApiResource(
 *     collectionOperations={
 *         "post"={
 *             "path"="/users/confirm"
 *         }
 *     },
 *     itemOperations={},
 * 
 * )
 */
class UserConfirmation
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=30, max=30)
     * @ApiProperty(identifier=true)
     */
    public $confirmationToken;
}