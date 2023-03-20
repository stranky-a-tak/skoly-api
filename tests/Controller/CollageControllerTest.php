<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CollageControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient([
            'enviroment' => 'test_env',
            'debug' => false,
        ]);
        $crawler = $client->jsonRequest('POST', '/api/collages', ['query' => 'STU']);

        $this->assertResponseIsSuccessful();
    }
}
