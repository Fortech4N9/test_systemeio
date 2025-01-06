<?php

namespace App\Tests\Entity;

use App\Entity\Coupon;
use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
    public function testCoupon(): void
    {
        $coupon = new Coupon();
        $coupon->setCode('D15');
        $coupon->setDiscountAmount(15.00);

        $this->assertEquals('D15', $coupon->getCode());
        $this->assertEquals(15.00, $coupon->getDiscountAmount());
    }
}