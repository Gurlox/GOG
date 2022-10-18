<?php

declare(strict_types=1);

namespace App\Module\Product\Infrastructure\API\Controller;

use App\Core\Command\CommandBus;
use App\Core\Query\QueryBus;
use App\Module\Product\Application\Command\CreateProduct\CreateProductCommand;
use App\Module\Product\Application\Command\DeleteProduct\DeleteProductCommand;
use App\Module\SharedKernel\ValueObject\Price;
use Assert\Assert;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

#[Route('/api/products', name: 'products_')]
/**
 * @OA\Tag(name="Product")
 */
class ProductController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {
    }

    #[Route('', name: 'create_product', methods: ['POST'])]
    /**
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         example={
     *             "title": "string",
     *             "netPrice": 10000
     *         },
     *         @OA\Schema (
     *              type="object",
     *              @OA\Property(property="title", required=true, description="Product title", type="string"),
     *              @OA\Property(property="netPrice", required=true, description="Product net price multiplied by 1000", type="int")
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="CREATED"
     * )
     */
    public function createProduct(Request $request): JsonResponse
    {
        $requestData = $request->toArray();

        try {
            Assert::lazy()
                ->that($requestData)->keyIsset('title', 'title key must be provided')
                ->that($requestData)->keyIsset('netPrice', 'netPrice key must be provided')
                ->verifyNow();

            $title = $requestData['title'];
            $netPrice = $requestData['netPrice'];

            Assert::lazy()
                ->that($title)->string('title should be string')
                ->that($netPrice)->integer('netPrice should be integer')
                ->verifyNow();
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $productId = $this->commandBus->handle(new CreateProductCommand(
            $title,
            $netPrice,
            Price::DEFAULT_CURRENCY,
            Price::DEFAULT_TAX_RATE,
        ));

        return new JsonResponse(['productId' => $productId], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'delete_product', methods: ['DELETE'])]
    /**
     * @OA\Response(
     *     response=204,
     *     description="NO_CONTENT"
     * )
     */
    public function deleteProduct(int $id): JsonResponse
    {
        $this->commandBus->handle(new DeleteProductCommand($id));

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
