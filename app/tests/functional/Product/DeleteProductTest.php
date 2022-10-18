<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteProductTest extends WebTestCase implements FunctionalTestInterface
{
    public function testDeleteShouldSucceed(): void
    {
        $client = static::createClient();
        $productId = ProductTestCase::createProductRequest($client, 'Assasin', 199000)['productId'];
        ProductTestCase::deleteProductRequest($client, $productId);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
