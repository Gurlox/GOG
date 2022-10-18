<?php

declare(strict_types=1);

namespace App\Fixtures;

use App\Module\Product\Domain\Entity\Product;
use App\Module\SharedKernel\ValueObject\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $item) {
            $product = new Product(
                $item['title'],
                $item['price'],
            );

            $manager->persist($product);
            $manager->flush();
        }
    }

    private function getData(): array
    {
        return [
            [
                'title' => 'Fallout',
                'price' => Price::createFromGrossPrice(
                    new Money(19900, new Currency(Price::DEFAULT_CURRENCY)),
                    Price::DEFAULT_TAX_RATE,
                )
            ],
            [
                'title' => "Don't Starve",
                'price' => Price::createFromGrossPrice(
                    new Money(29900, new Currency(Price::DEFAULT_CURRENCY)),
                    Price::DEFAULT_TAX_RATE,
                )
            ],
            [
                'title' => "Baldur's Gate",
                'price' => Price::createFromGrossPrice(
                    new Money(39900, new Currency(Price::DEFAULT_CURRENCY)),
                    Price::DEFAULT_TAX_RATE,
                )
            ],
            [
                'title' => 'Icewind Dale',
                'price' => Price::createFromGrossPrice(
                    new Money(49900, new Currency(Price::DEFAULT_CURRENCY)),
                    Price::DEFAULT_TAX_RATE,
                )
            ],
            [
                'title' => 'Bloodborne',
                'price' => Price::createFromGrossPrice(
                    new Money(59900, new Currency(Price::DEFAULT_CURRENCY)),
                    Price::DEFAULT_TAX_RATE,
                )
            ],
        ];
    }
}
