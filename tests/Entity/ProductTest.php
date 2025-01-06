<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProduct(): void
    {
        $product = new Product();
        $product->setName('Iphone');
        $product->setPrice(100.00);

        $this->assertEquals('Iphone', $product->getName());
        $this->assertEquals(100.00, $product->getPrice());
    }
}