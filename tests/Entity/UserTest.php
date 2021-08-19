<?php
namespace App\Tests\Entity;

use App\Entity\User; 
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUsername()
    {
        $user = new User();
        $nameLast = "saintus";
        $nameFirst = "earvin";
        $emailTest = "earvin.saintus3@gmail.com";
        $pictureTest = "http://placehold.it/64x64";
        $introTest = "Je set un test pour voir si l'intro fonctionne bien phase de test";
        $descriptionTest = "Je set une description pour voir si la description fonctionne bien phase de test et pour rendre le test de la classe valide en utilisant tout les variables de la classe Utilisateur de mon application i2i.";
        $passwordTest = "password";


        $user->setLastName($nameLast);
        $this->assertEquals("saintus", $user->getLastName());
        $user->setFirstName($nameFirst);
        $this->assertEquals("earvin", $user->getFirstName());
        $user->setEmail($emailTest);
        $this->assertEquals("earvin.saintus3@gmail.com", $user->getEmail());
        $user->setPicture($pictureTest);
        $this->assertEquals("http://placehold.it/64x64", $user->getPicture());
        $user->setHash($passwordTest);
        $this->assertEquals("password", $user->getHash());
        $user->setIntroduction($introTest);
        $this->assertEquals("Je set un test pour voir si l'intro fonctionne bien phase de test", $user->getIntroduction());
        $user->setDescription($descriptionTest);
        $this->assertEquals("Je set une description pour voir si la description fonctionne bien phase de test et pour rendre le test de la classe valide en utilisant tout les variables de la classe Utilisateur de mon application i2i.", $user->getDescription());
    }
}
?>