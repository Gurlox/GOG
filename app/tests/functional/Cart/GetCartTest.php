<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use App\Tests\functional\FunctionalTestInterface;
use App\Tests\functional\Product\ProductTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetCartTest extends WebTestCase implements FunctionalTestInterface
{
    public function testGetCartByIdShouldReturnCartData(): void
    {
        // given
        $client = static::createClient();
        $productId = ProductTestCase::createProductRequest($client, 'Title', 2000)['productId'];
        $cartId = CartTestCase::createCartRequest($client)['cartId'];
        CartTestCase::postCartProductRequest($client, $cartId, $productId, 1);

        // when then
        $result = CartTestCase::getCartRequest($client, $cartId);
        $this->assertEquals($cartId, $result['cart']['id']);
        $this->assertCount(1, $result['cart']['products']);
    }
}
