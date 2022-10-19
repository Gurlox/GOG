<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;

class CartTestCase
{
    public static function createCartRequest(KernelBrowser $client): array
    {
        $client->request(
            Request::METHOD_POST,
            '/api/carts',
        );

        return json_decode($client->getResponse()->getContent(), true);
    }

    public static function postCartProductRequest(KernelBrowser $client, int $cartId, int $productId, int $quantity): array
    {
        $client->request(
            Request::METHOD_POST,
            '/api/carts/' . $cartId . '/products/' . $productId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'quantity' => $quantity,
            ]),
        );

        return json_decode($client->getResponse()->getContent(), true);
    }

    public static function getCartRequest(KernelBrowser $client, int $cartId): array
    {
        $client->request(
            Request::METHOD_GET,
            '/api/carts/' . $cartId,
        );

        return json_decode($client->getResponse()->getContent(), true);
    }

    public static function deleteCartProductRequest(KernelBrowser $client, int $cartId, int $productId): void
    {
        $client->request(
            Request::METHOD_DELETE,
            '/api/carts/' . $cartId . '/products/' . $productId,
        );
    }
}
