<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Actualite;
use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class BlogPostTest extends TestCase 
{
     /**
     * @var \App\Entity\Actualite
     */
    private $blogpost;

protected function setUp():void {
    parent::setUp();
    $this->blogpost = new Actualite();
}

public function testGetTitle():void{

    $value = 'Titre de post';
    $response = $this->blogpost->setTitle($value);
    $getTitle = $this->blogpost->getTitle();

    self::assertInstanceOf(Actualite::class, $response);
    self::assertEquals($value, $getTitle);
}

public function testGetContent():void{

    $value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
    $response = $this->blogpost->setContent($value);
    $getContent = $this->blogpost->getContent();

    self::assertInstanceOf(Actualite::class, $response);
    self::assertEquals($value,$getContent);
}

public function testGetAuthor():void{

    $value = new Users();
    $response = $this->blogpost->setAuthor($value);
    $getAuthor = $this->blogpost->getAuthor();

    self::assertInstanceOf(Actualite::class, $response);
    self::assertEquals($value, $getAuthor);
}


}