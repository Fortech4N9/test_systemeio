<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\PaymentProcessor;
use App\Service\Payment\PaymentType;

class PurchaseController extends AbstractController
{
    private $entityManager;
    private $paymentProcessor;

    public function __construct(EntityManagerInterface $entityManager, PaymentProcessor $paymentProcessor)
    {
        $this->entityManager = $entityManager;
        $this->paymentProcessor = $paymentProcessor;
    }

    /**
     * @Route("/purchase", name="purchase", methods={"POST"})
     */
    public function purchase(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validate request data...

        // Fetch product and coupon from database...
        $product = $this->entityManager->getRepository(Product::class)->find($data['product']);
        $coupon = $this->entityManager->getRepository(Coupon::class)->findOneBy(['code' => $data['couponCode']]);

        // Calculate price...
        $price = $product->getPrice();
        if ($coupon) {
            if ($coupon->getDiscountAmount()) {
                $price -= $coupon->getDiscountAmount();
            } elseif ($coupon->getDiscountPercentage()) {
                $price -= $price * ($coupon->getDiscountPercentage() / 100);
            }
        }

        // Calculate tax...
        $taxRate = $this->getTaxRate($data['taxNumber']);
        $price += $price * ($taxRate / 100);

        // Process payment...
        $paymentType = PaymentType::from($data['paymentProcessor']);
        $paymentResult = $this->paymentProcessor->process($paymentType, $price);

        if ($paymentResult) {
            return new JsonResponse(['status' => 'success'], 200);
        } else {
            return new JsonResponse(['error' => 'Payment failed'], 400);
        }
    }

    private function getTaxRate(string $taxNumber): float
    {
        // Determine tax rate based on tax number...
        if (preg_match('/^DE\d{9}$/', $taxNumber)) {
            return 19.0;
        } elseif (preg_match('/^IT\d{11}$/', $taxNumber)) {
            return 22.0;
        } elseif (preg_match('/^GR\d{9}$/', $taxNumber)) {
            return 24.0;
        } elseif (preg_match('/^FR[A-Z]{2}\d{9}$/', $taxNumber)) {
            return 20.0;
        }

        throw new \InvalidArgumentException('Invalid tax number');
    }
}