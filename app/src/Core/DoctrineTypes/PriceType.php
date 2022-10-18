<?php

declare(strict_types=1);

namespace App\Core\DoctrineTypes;

use App\Module\SharedKernel\ValueObject\Price;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Money\Currency;
use Money\Money;

class PriceType extends JsonType
{
    public const NAME = 'price';

    public function getName(): string
    {
        return $this::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Price
    {
        $value = json_decode($value, true);

        return new Price(
            new Money($value['amount'], new Currency($value['currency'])),
            $value['taxRate'],
        );
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        /** @var Price $value */
        return $value->jsonSerialize();
    }
}
