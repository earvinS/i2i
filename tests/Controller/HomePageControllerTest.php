<?php 

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{

    public function testHomePage(){
        $client = static::createClient();
        $client->request('GET','/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testTitleHomePage(){
        $client = static::createClient();
        $client->request('GET','/');
        $this->assertSelectorTextContains('h1', 'Bienvenue sur i2i');
    }

}