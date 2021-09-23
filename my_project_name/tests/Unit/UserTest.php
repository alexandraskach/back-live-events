<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase 
{
     /**
     * @var \App\Entity\Users
     */
    private $user;

protected function setUp():void {
    parent::setUp();
    $this->user = new Users();
}

public function testGetEmail():void{

    $value = 'test@test.fr';
    $response = $this->user->setMail($value);
    $getEmail = $this->user->getMail();

    self::assertInstanceOf(Users::class, $response);
    self::assertEquals($value, $getEmail);
}

// public function testGetRoles():void{

//     $value = ["ROLE_ADMIN"];
//     $response = $this->user->setRoles($value);

//     self::assertInstanceOf(Users::class, $response);
//     self::assertContains("ROLE_ADMIN",$this->user->getRoles());
// }

public function testGetPassword():void{

    $value = "thisISaPASSWORD10";
    $response = $this->user->setPassword($value);

    self::assertInstanceOf(Users::class, $response);
    self::assertEquals($value,$this->user->getPassword());
}


public function testGetUsername():void{

    $value = "marie";
    $response = $this->user->setUsername($value);

    self::assertInstanceOf(Users::class, $response);
    self::assertEquals($value,$this->user->getUsername());
}
}