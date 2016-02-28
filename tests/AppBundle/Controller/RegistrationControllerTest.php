<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    
    public function testIndex()
    {
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Register', $crawler->filter('section h1')->text());
        
    }
    
    public function testRegister()
    {
        
        $client = static::createClient();
        //Delete users before entering one to prevent error
        $container = self::$kernel->getContainer();
        $em = $container->get('doctrine')->getManager();
        
        $userRepo = $em->getRepository('AppBundle:User');
        $userRepo->createQueryBuilder('u')
            ->delete()
            ->getQuery()
            ->execute()
        ;
        

        $crawler = $client->request('GET', '/register');
        $response = $client->getResponse();
                
        $usernameVal = $crawler
            ->filter('#registration_form_username')
            ->attr('value')
        ;
        
        $this->assertEquals('', $usernameVal);
        
        $form = $crawler->selectButton('Create an Account')->form();
        $form['registration_form[username]'] = 'user5';
        $form['registration_form[email]'] = 'user5@user.com';
        $form['registration_form[plainPassword][first]'] = 'P3ssword';
        $form['registration_form[plainPassword][second]'] = 'P3ssword';
        
        $crawler = $client->submit($form);
        
        //var_dump($client);

        $this->assertTrue($client->getResponse()->isRedirect());
        
        $client->followRedirect();
        $this->assertContains(
            'Symfony 3.0.0',
            $client->getResponse()->getContent()
        );
        
    }
    
}
