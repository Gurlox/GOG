<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetProductsListTest extends WebTestCase implements FunctionalTestInterface
{
    public function testGetPaginatedListWith7ProductsShouldReturnList(): void
    {
        // given
        $client = static::createClient();
        ProductTestCase::createProductRequest($client, 'Minecraft', 19900);
        ProductTestCase::createProductRequest($client, 'Roblox', 19900);
        ProductTestCase::createProductRequest($client, 'DOTA', 19900);
        ProductTestCase::createProductRequest($client, 'LoL', 19900);
        ProductTestCase::createProductRequest($client, 'Witcher', 19900);
        ProductTestCase::createProductRequest($client, 'Mafia', 19900);
        ProductTestCase::createProductRequest($client, 'Stardew Valley', 19900);

        // when then
        $result = ProductTestCase::getProductsListRequest($client, 1, 3);
        $this->assertEquals(7, $result['totalCount']);
        $this->assertCount(3, $result['products']);

        $result = ProductTestCase::getProductsListRequest($client, 2, 3);
        $this->assertCount(3, $result['products']);

        $result = ProductTestCase::getProductsListRequest($client, 3, 3);
        $this->assertCount(1, $result['products']);
    }

    public function testGetPaginatedListWithPerPageArgumentTooBigShouldGet400HttpCode(): void
    {
        $client = static::createClient();
        ProductTestCase::getProductsListRequest($client, 1, 4);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
