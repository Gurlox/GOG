<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateProductTest extends WebTestCase implements FunctionalTestInterface
{
    public function testCreateProductWithValidDataShouldSucceed(): void
    {
        $client = static::createClient();
        $result =ProductTestCase::createProductRequest($client, 'Title', 19900);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('productId', $result);
    }

    public function testCreateProductWithNonUniqueTitleShouldFail(): void
    {
        $client = static::createClient();
        ProductTestCase::createProductRequest($client, 'Title', 19900);
        $result = ProductTestCase::createProductRequest($client, 'Title', 19900);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Title should be unique', $result['message']);
    }
}
