<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

class UpdateProductTest extends ProductTestCase
{
    public function testUpdateProductWithAllDataShouldOverwriteIt(): void
    {
        // given
        $client = static::createClient();
        $productId = $this->createProductRequest($client, 'Minecraft', 19900)['productId'];
        $newTitle = 'Roblox';
        $newNetPrice = 200;

        // when then
        $result = $this->patchProductRequest($client, $productId, $newTitle, $newNetPrice)['product'];
        $this->assertEquals($newTitle, $result['title']);
        $this->assertEquals($newNetPrice, $result['price']['netPrice']);
    }

    public function testUpdateProductWithOnlyTitleShouldNotOverwritePrice(): void
    {
        // given
        $client = static::createClient();
        $netPrice = 19900;
        $productId = $this->createProductRequest($client, 'Minecraft', $netPrice)['productId'];
        $newTitle = 'Roblox';

        // when then
        $result = $this->patchProductRequest($client, $productId, $newTitle, null)['product'];
        $this->assertEquals($newTitle, $result['title']);
        $this->assertEquals($netPrice, $result['price']['netPrice']);
    }
}
