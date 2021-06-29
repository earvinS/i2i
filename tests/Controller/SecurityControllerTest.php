<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    public function testDisplayLogin(){
        $client = static::createClient();
        $client->request('GET','/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Connectez-vous !');
        $this->assertSelectorNotExists('alert alert-danger');
    }

    // public function testLoginWithBadCredentials(){
    //     $client = static::createClient();
   
    //     // $crawler = $client->request('GET','/login');
    //     // $form = $crawler->selectButton('Connexion')->form([
    //     //     'email' => 'admin@admin.fr',
    //     //     'password' => 'password'
    //     // ]);
    //     // $client->submit($form);
    //     // $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
    //     $client->request('POST','/login', [
    //         // 'csrf_token' => $csrfToken,
    //         'email' => 'admin@admin.fr',
    //         'password' => 'password'
    //     ]);
    //     $this->assertResponseRedirects('/');
    
    // }
    
}