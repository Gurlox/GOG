<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateProductTest extends WebTestCase implements FunctionalTestInterface
{
    public function testUpdateProductWithAllDataShouldOverwriteIt(): void
    {
        // given
        $client = static::createClient();
        $productId = ProductTestCase::createProductRequest($client, 'Minecraft', 19900)['productId'];
        $newTitle = 'Roblox';
        $newNetPrice = 200;

        // when then
        $result = ProductTestCase::patchProductRequest($client, $productId, $newTitle, $newNetPrice)['product'];
        $this->assertEquals($newTitle, $result['title']);
        $this->assertEquals($newNetPrice, $result['price']['netPrice']);
    }

    public function testUpdateProductWithOnlyTitleShouldNotOverwritePrice(): void
    {
        // given
        $client = static::createClient();
        $netPrice = 19900;
        $productId = ProductTestCase::createProductRequest($client, 'Minecraft', $netPrice)['productId'];
        $newTitle = 'Roblox';

        // when then
        $result = ProductTestCase::patchProductRequest($client, $productId, $newTitle, null)['product'];
        $this->assertEquals($newTitle, $result['title']);
        $this->assertEquals($netPrice, $result['price']['netPrice']);
    }
}
