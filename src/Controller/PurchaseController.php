<?php

namespace App\Controller;

use App\RequestDto\PurchaseRequestDto;
use App\UseCase\CalculatePriceUseCase;
use App\UseCase\PayUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PurchaseController extends AbstractController
{
    public function __construct(
        private CalculatePriceUseCase $calcPriceUseCase,
        private PayUseCase            $perchaseUseCase,
    )
    {
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'])]
    public function index(
        #[MapRequestPayload]
        PurchaseRequestDto $requestDto,
    ): JsonResponse
    {
        $price = $this->calcPriceUseCase->do($requestDto->product, $requestDto->taxNumber, $requestDto->couponCode);

        $this->perchaseUseCase->do($price, $requestDto->paymentProcessor);
    }
}
