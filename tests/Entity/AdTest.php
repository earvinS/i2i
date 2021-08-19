<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Ad; 
use App\Entity\User; 

class AdTest extends TestCase
{
    public function testUsername()
    {
        $user = new User();
        $ad = new Ad();

        $title = "Iphone12 pro max";
        $slug = "iphone-12-pro-max";
        $price = 12.50;
        $introduction = "Je set une intrdoctuin test pour voir si l'intro fonctionne bien phase de test";
        $coverImage = "http://placehold.it/1000x600";
        $author = "earvin";

        $user->setFirstName($author);
        $this->assertEquals("earvin", $user->getFirstName());
        $ad->setTitle($title);
        $this->assertEquals("Iphone12 pro max", $ad->getTitle());
        $ad->setSlug($slug);
        $this->assertEquals("iphone-12-pro-max", $ad->getSlug());
        $ad->setPrice($price);
        $this->assertEquals(12.50, $ad->getPrice());
        $ad->setIntroduction($introduction);
        $this->assertEquals("Je set une intrdoctuin test pour voir si l'intro fonctionne bien phase de test", $ad->getIntroduction());
        $ad->setCoverImage($coverImage);
        $this->assertEquals("http://placehold.it/1000x600", $ad->getCoverImage());
    }
}
