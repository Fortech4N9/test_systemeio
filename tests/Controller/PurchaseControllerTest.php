<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PurchaseControllerTest extends WebTestCase
{
    public function testPurchase(): void
    {
        $client = static::createClient();
        $client->request('POST', '/purchase', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'product' => 1,
            'taxNumber' => 'IT12345678900',
            'couponCode' => 'D15',
            'paymentProcessor' => 'paypal'
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}