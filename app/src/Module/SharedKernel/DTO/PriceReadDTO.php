<?php

declare(strict_types=1);

namespace App\Module\SharedKernel\DTO;

use App\Module\SharedKernel\ValueObject\Price;

class PriceReadDTO
{
    public function __construct(
        public readonly int $netPrice,
        public readonly int $grossPrice,
        public readonly string $currency,
        public readonly int $taxRate,
    ) {
    }

    public static function createFromPrice(Price $price): self
    {
        return new self(
            (int) $price->getNetPrice()->getAmount(),
            (int) $price->getGrossPrice()->getAmount(),
            $price->getGrossPrice()->getCurrency()->getCode(),
            $price->getTaxRate(),
        );
    }
}
