<?php

declare(strict_types=1);

namespace App\Module\Cart\Infrastructure\API\Controller;

use App\Core\Command\CommandBus;
use App\Core\Query\QueryBus;
use App\Module\Cart\Application\Command\AddProductToCart\AddProductToCartCommand;
use App\Module\Cart\Application\Command\CreateCartCommand\CreateCartCommand;
use App\Module\Cart\Application\Query\GetCartById\GetCartByIdQuery;
use Assert\Assert;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Module\Cart\Application\DTO\CartReadDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
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

    #[Route('/{cartId}/products/{productId}', name: 'post_cart_product', methods: ['POST'])]
    /**
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         example={
     *             "quantity": 1
     *         },
     *         @OA\Schema (
     *              type="object",
     *              @OA\Property(property="quantity", required=true, description="Product quantity", type="integer"),
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @Model(type=CartReadDTO::class)
     * )
     */
    public function postCartProduct(Request $request, int $cartId, int $productId): JsonResponse
    {
        $requestData = $request->toArray();

        try {
            Assert::that($requestData)->keyIsset('quantity', 'quantity key must be provided');
            $quantity = $requestData['quantity'];
            Assert::that($quantity)->numeric();
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $this->commandBus->handle(
            new AddProductToCartCommand(
                $cartId,
                $productId,
                $quantity,
            )
        );

        return new JsonResponse(
            [
                'cart' => $this->queryBus->handle(new GetCartByIdQuery($cartId)),
            ],
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'get_cart', methods: ['GET'])]
    /**
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @Model(type=CartReadDTO::class)
     * )
     */
    public function getCart(int $id): JsonResponse
    {
        return new JsonResponse(
            [
                'cart' => $this->queryBus->handle(new GetCartByIdQuery($id)),
            ],
            Response::HTTP_OK
        );
    }
}
