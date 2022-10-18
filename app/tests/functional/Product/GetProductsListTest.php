<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

use Symfony\Component\HttpFoundation\Response;

class GetProductsListTest extends ProductTestCase
{
    public function testGetPaginatedListWith7ProductsShouldReturnList(): void
    {
        // given
        $client = static::createClient();
        $this->createProductRequest($client, 'Minecraft', 19900);
        $this->createProductRequest($client, 'Roblox', 19900);
        $this->createProductRequest($client, 'DOTA', 19900);
        $this->createProductRequest($client, 'LoL', 19900);
        $this->createProductRequest($client, 'Witcher', 19900);
        $this->createProductRequest($client, 'Mafia', 19900);
        $this->createProductRequest($client, 'Stardew Valley', 19900);

        // when then
        $result = $this->getProductsListRequest($client, 1, 3);
        $this->assertEquals(7, $result['totalCount']);
        $this->assertCount(3, $result['products']);

        $result = $this->getProductsListRequest($client, 2, 3);
        $this->assertCount(3, $result['products']);

        $result = $this->getProductsListRequest($client, 3, 3);
        $this->assertCount(1, $result['products']);
    }

    public function testGetPaginatedListWithPerPageArgumentTooBigShouldGet400HttpCode(): void
    {
        $client = static::createClient();
        $this->getProductsListRequest($client, 1, 4);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
