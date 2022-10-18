<?php

declare(strict_types=1);

namespace App\Tests\functional\Product;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ProductTestCase extends WebTestCase implements FunctionalTestInterface
{
    protected function createProductRequest(KernelBrowser $client, string $title, int $netPrice): array
    {
        $client->request(
            Request::METHOD_POST,
            '/api/products',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'title' => $title,
                'netPrice' => $netPrice,
            ]),
        );

        return json_decode($client->getResponse()->getContent(), true);
    }

    protected function deleteProductRequest(KernelBrowser $client, int $id): void
    {
        $client->request(
            Request::METHOD_DELETE,
            '/api/products/' . $id,
        );
    }
}
