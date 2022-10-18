<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

class CreateCartTest extends CartTestCase
{
    public function testCreateCartShouldSucceed(): void
    {
        $client = static::createClient();
        $result = $this->createCartRequest($client);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('cartId', $result);
    }
}
