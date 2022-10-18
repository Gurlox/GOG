<?php

declare(strict_types=1);

namespace App\Tests\Unit\Module\SharedKernel\ValueObject;

use Assert\InvalidArgumentException;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use App\Module\SharedKernel\ValueObject\Price;

class PriceTest extends TestCase
{
    public function testGetGrossPriceShouldMultiplyNetPrice(): void
    {
        // given
        $netPrice = new Money(10000, new Currency(Price::DEFAULT_CURRENCY));

        // when then
        $price = new Price($netPrice, Price::DEFAULT_TAX_RATE);

        $this->assertEquals(12300, $price->getGrossPrice()->getAmount());
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testCreateWithInvalidDataShouldThrowException(int $amount, int $taxRate): void
    {
        // given
        $netPrice = new Money($amount, new Currency(Price::DEFAULT_CURRENCY));

        // when then
        $this->expectException(InvalidArgumentException::class);
        new Price($netPrice, $taxRate);
    }

    public function invalidDataProvider(): array
    {
        return [
            [-100000, 12],
            [100000, -12],
        ];
    }

    public function testCreateFromGrossPrice(): void
    {
        $result = Price::createFromGrossPrice(
            new Money(24477, new Currency(Price::DEFAULT_CURRENCY)),
            23
        );
        $this->assertEquals(19900, $result->getNetPrice()->getAmount());

        $result = Price::createFromGrossPrice(
            new Money(19900, new Currency(Price::DEFAULT_CURRENCY)),
            23
        );
        $this->assertEquals(16179, $result->getNetPrice()->getAmount());
    }
}
