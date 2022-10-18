<?php

declare(strict_types=1);

namespace App\Module\Cart\Infrastructure\API\Controller;

use App\Core\Command\CommandBus;
use App\Core\Query\QueryBus;
use App\Module\Cart\Application\Command\CreateCartCommand\CreateCartCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

#[Route('/api/carts', name: 'carts_')]
/**
 * @OA\Tag(name="Cart")
 */
class CartController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {
    }

    #[Route('', name: 'create_cart', methods: ['POST'])]
    /**
     * @OA\Response(
     *     response=201,
     *     description="CREATED"
     * )
     */
    public function createCart(Request $request): JsonResponse
    {
        return new JsonResponse(['cartId' => $this->commandBus->handle(new CreateCartCommand())], Response::HTTP_CREATED);
    }
}
