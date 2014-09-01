<?php

namespace Nakupujem\ShopBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/show');
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/profile');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/edit');
    }

}
