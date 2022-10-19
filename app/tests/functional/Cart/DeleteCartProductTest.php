<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use App\Tests\functional\FunctionalTestInterface;
use App\Tests\functional\Product\ProductTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteCartProductTest extends WebTestCase implements FunctionalTestInterface
{
    public function testDeleteCartShouldSucceed(): void
    {
        // given
        $client = static::createClient();
        $productId = ProductTestCase::createProductRequest($client, 'Title', 2000)['productId'];
        $cartId = CartTestCase::createCartRequest($client)['cartId'];
        CartTestCase::postCartProductRequest($client, $cartId, $productId, 1);

        // when
        CartTestCase::deleteCartProductRequest($client, $cartId, $productId);

        //then
        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
        $result = CartTestCase::getCartRequest($client, $cartId);
        $this->assertCount(0, $result['cart']['products']);
    }
}
