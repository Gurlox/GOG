<?php

declare(strict_types=1);

namespace App\Module\SharedKernel\ValueObject;

use Assert\Assert;
use JsonSerializable;
use Money\Money;

class Price implements JsonSerializable
{
    public const DEFAULT_TAX_RATE = 23;
    public const DEFAULT_CURRENCY = 'USD';

    private Money $netPrice;

    private int $taxRate;

    public function __construct(
        Money $netPrice,
        int $taxRate,
    ) {
        $this->setNetPrice($netPrice);
        $this->setTaxRate($taxRate);
    }

    public function getNetPrice(): Money
    {
        return $this->netPrice;
    }

    public function setNetPrice(Money $netPrice): void
    {
        Assert::that($netPrice->getAmount())->min(0);
        $this->netPrice = $netPrice;
    }

    public function getGrossPrice(): Money
    {
        return $this->netPrice->multiply(1 + $this->taxRate / 100);
    }

    public function getTaxRate(): int
    {
        return $this->taxRate;
    }

    public function setTaxRate(int $taxRate): void
    {
        Assert::that($taxRate)->min(0);
        $this->taxRate = $taxRate;
    }
    
    public function toArray(): array
    {
        return [
            'amount' => $this->netPrice->getAmount(),  
            'currency' => $this->netPrice->getCurrency()->getCode(),
            'taxRate' => $this->taxRate,
        ];
    }

    public function jsonSerialize(): string
    {
        return json_encode($this->toArray());
    }
}
