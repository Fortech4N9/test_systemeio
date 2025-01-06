<?php

namespace App\Service;

use App\Service\Payment\PaymentType;
use App\Service\Payment\AbstractPaymentProcessor;
use App\Service\Payment\PaypalPaymentProcessor;
use App\Service\Payment\StripePaymentProcessor;

class PaymentProcessor
{
    public function process(PaymentType $paymentType, float $amount): bool
    {
        $processor = $this->createProcessor($paymentType);
        return $processor->process($amount);
    }

    private function createProcessor(PaymentType $paymentType): AbstractPaymentProcessor
    {
        return match ($paymentType) {
            PaymentType::PAYPAL => new PaypalPaymentProcessor(),
            PaymentType::STRIPE => new StripePaymentProcessor(),
        };
    }
}