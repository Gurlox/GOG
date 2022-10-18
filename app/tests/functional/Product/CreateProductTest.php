<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

class CreateProductTest extends ProductTestCase
{
    public function testCreateProductWithValidDataShouldSucceed(): void
    {
        $client = static::createClient();
        $result = $this->createProductRequest($client, 'Title', 19900);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('productId', $result);
    }

    public function testCreateProductWithNonUniqueTitleShouldFail(): void
    {
        $client = static::createClient();
        $this->createProductRequest($client, 'Title', 19900);
        $result = $this->createProductRequest($client, 'Title', 19900);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Title should be unique', $result['message']);
    }
}
