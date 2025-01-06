<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PriceControllerTest extends WebTestCase
{
    public function testCalculatePrice(): void
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'product' => 1,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15'
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}