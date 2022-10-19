<?php

declare(strict_types=1);

namespace App\Module\Cart\Domain\Factory;

use App\Module\Cart\Domain\ReadModel\CartPrices;
use App\Module\Cart\Domain\ReadModel\ProductCartPrice;

class CartPricesFactory
{
    /**
     * @param ProductCartPrice[] $productsPrices
     */
    public function createFromProductPrices(array $productsPrices): CartPrices
    {
        $totalPriceNet = 0;
        $totalPriceGross = 0;

        foreach ($productsPrices as $productsPrice) {
            $totalPriceNet += (int) $productsPrice->price->getNetPrice()->multiply($productsPrice->quantity)->getAmount();
            $totalPriceGross += (int) $productsPrice->price->getGrossPrice()->multiply($productsPrice->quantity)->getAmount();
        }

        return new CartPrices($totalPriceNet, $totalPriceGross);
    }
}
