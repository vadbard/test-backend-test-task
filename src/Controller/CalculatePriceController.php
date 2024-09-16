<?php

namespace App\Controller;

use App\RequestDto\CalculatePriceRequestDto;
use App\ResponseDto\CalculatePriceResponseDto;
use App\UseCase\CalculatePriceUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CalculatePriceController extends AbstractController
{
    public function __construct(
        private CalculatePriceUseCase $useCase,
    )
    {
    }

    #[Route('/calculate-price', name: 'app_calculate_price', methods: ['POST'])]
    public function index(
        #[MapRequestPayload]
        CalculatePriceRequestDto $requestDto,
    ): JsonResponse
    {
        $price = $this->useCase->do($requestDto->product, $requestDto->taxNumber, $requestDto->couponCode);

        return $this->json(new CalculatePriceResponseDto(
            price: $price->getMoney(),
        ));
    }
}
