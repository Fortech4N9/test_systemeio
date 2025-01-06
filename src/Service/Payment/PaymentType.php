<?php

namespace App\Service\Payment;

enum PaymentType: string
{
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';
}