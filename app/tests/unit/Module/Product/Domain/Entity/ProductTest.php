<?php

declare(strict_types=1);

namespace App\Tests\unit\Module\Product\Domain\Entity;

use App\Module\Product\Domain\Entity\Product;
use App\Module\SharedKernel\ValueObject\Price;
use Assert\InvalidArgumentException;
use Money\Currency;
use Money\Money;
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

    public function testUpdateNetAmountShouldOverwriteIt(): void
    {
        // given
        $product = new Product(
            'title',
            new Price(
                new Money(200, new Currency(Price::DEFAULT_CURRENCY)),
                Price::DEFAULT_TAX_RATE,
            )
        );
        $newAmount = 100;

        // when then
        $this->assertEquals($newAmount, $product->updateNetAmount($newAmount)->getPrice()->getNetPrice()->getAmount());
    }
}
