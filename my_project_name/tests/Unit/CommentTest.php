<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Comment;
use App\Entity\Users;
use DateTime;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase 
{
     /**
     * @var \App\Entity\Comment
     */
    private $comment;

protected function setUp():void {
    parent::setUp();
    $this->comment = new Comment();
}

public function testGetContent():void{

    $value = 'Contenu de commentaire';
    $response = $this->comment->setContent($value);
    $getContent = $this->comment->getContent();

    self::assertInstanceOf(Comment::class, $response);
    self::assertEquals($value, $getContent);
}

public function testGetDate():void{

    $value = new DateTime();
    $response = $this->comment->setDate($value);
    $getDate = $this->comment->getDate();

    self::assertInstanceOf(Comment::class, $response);
    self::assertEquals($value,$getDate);
}

public function testGetAuthor():void{

    $value = new Users();
    $response = $this->comment->setAuthor($value);
    $getAuthor = $this->comment->getAuthor();

    self::assertInstanceOf(Comment::class, $response);
    self::assertEquals($value, $getAuthor);
}


}