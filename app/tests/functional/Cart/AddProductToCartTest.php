<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use App\Tests\functional\FunctionalTestInterface;
use App\Tests\functional\Product\ProductTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddProductToCartTest extends WebTestCase implements FunctionalTestInterface
{
    public function testAddProductToCartShouldSucceed(): void
    {
        // given
        $client = static::createClient();
        $productId = ProductTestCase::createProductRequest($client, 'Title', 19900)['productId'];
        $cartId = CartTestCase::createCartRequest($client)['cartId'];

        // when then
        $result = CartTestCase::postCartProductRequest($client, $cartId, $productId, 2);
        dump($result);
    }
}
