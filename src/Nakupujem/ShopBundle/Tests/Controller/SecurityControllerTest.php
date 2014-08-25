<?php

namespace Nakupujem\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testUsersecuritycheck()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '_user_security_check');
    }

    public function testUserlogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '_user_login');
    }

    public function testUserlogout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '_user_logout');
    }

}
