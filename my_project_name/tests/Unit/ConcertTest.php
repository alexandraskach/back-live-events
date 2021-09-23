<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Concert;
use App\Entity\Image;
use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class ConcertTest extends TestCase 
{
     /**
     * @var \App\Entity\Concert
     */
    private $concert;

      /**
     * @var \App\Entity\Image
     */
    private $image;

protected function setUp():void {
    parent::setUp();
    $this->concert = new Concert();
    $this->image = new Image();
}

public function testGetArtist():void{

    $value = 'Artiste';
    $response = $this->concert->setArtiste($value);
    $getArtiste = $this->concert->getArtiste();

    self::assertInstanceOf(Concert::class, $response);
    self::assertEquals($value, $getArtiste);
}

public function testGetStyle():void{

    $value = "Lorem ipsum";
    $response = $this->concert->setStyle($value);
    $getStyle = $this->concert->getStyle();

    self::assertInstanceOf(Concert::class, $response);
    self::assertEquals($value,$getStyle);
}

public function testGetScene():void{

    $value = 1;
    $response = $this->concert->setScene($value);
    $getScene = $this->concert->getScene();

    self::assertInstanceOf(Concert::class, $response);
    self::assertEquals($value, $getScene);
}


}