<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateCartTest extends WebTestCase implements FunctionalTestInterface
{
    public function testCreateCartShouldSucceed(): void
    {
        $client = static::createClient();
        $result = CartTestCase::createCartRequest($client);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('cartId', $result);
    }
}
