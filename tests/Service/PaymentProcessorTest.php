<?php

namespace App\Tests\Service;

use App\Service\PaymentProcessor;
use App\Service\Payment\PaymentType;
use PHPUnit\Framework\TestCase;

class PaymentProcessorTest extends TestCase
{
    public function testProcessPaypal(): void
    {
        $paymentProcessor = new PaymentProcessor();
        $result = $paymentProcessor->process(PaymentType::PAYPAL, 100.00);

        $this->assertTrue($result);
    }

    public function testProcessStripe(): void
    {
        $paymentProcessor = new PaymentProcessor();
        $result = $paymentProcessor->process(PaymentType::STRIPE, 100.00);

        $this->assertTrue($result);
    }
}