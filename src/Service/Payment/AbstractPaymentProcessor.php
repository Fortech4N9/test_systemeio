<?php

namespace App\Service\Payment;

use App\Service\Payment\PaymentProcessorInterface;

class AbstractPaymentProcessor implements PaymentProcessorInterface
{
    public function process(float $amount): bool
    {
        // Common payment processing logic...
        return true;
    }
}