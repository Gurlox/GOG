<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

class DeleteProductTest extends ProductTestCase
{
    public function testDeleteShouldSucceed(): void
    {
        $client = static::createClient();
        $productId = $this->createProductRequest($client, 'Assasin', 199000)['productId'];
        $this->deleteProductRequest($client, $productId);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
