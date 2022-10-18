<?php

declare(strict_types=1);

namespace App\Tests\unit\Module\Cart\Infrastructure\ACL;

use App\Core\Query\QueryBus;
use App\Module\Cart\Application\Repository\ProductReadRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductReadRepositoryTest extends TestCase
{
    private MockObject|QueryBus $queryBus;
    private MockObject|ProductReadRepositoryInterface $productReadRepository;

    public function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBus::class);
        $this->productReadRepository = $this->createMock(ProductReadRepositoryInterface::class);
    }

    public function testDoesProductExistShouldReturnFalseWhenExceptionIsThrown(): void
    {
        // given
        $id = 1;

        // when
        $this->queryBus
            ->method('handle')
            ->willThrowException(new NotFoundHttpException());

        // then
        $this->assertFalse($this->productReadRepository->doesProductExist($id));
    }
}
