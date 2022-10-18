<?php

declare(strict_types=1);

namespace App\Tests\unit\Module\Product\Domain\Entity;

use App\Module\Product\Domain\Entity\Product;
use App\Module\SharedKernel\ValueObject\Price;
use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @dataProvider invalidDataProvider
     */
    public function testCreateWithInvalidDataShouldThrowException(string $title): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Product($title, $this->createMock(Price::class));
    }

    public function invalidDataProvider(): array
    {
        return [
            [''],
            [str_repeat("t", 256)],
        ];
    }
}
