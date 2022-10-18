<?php

declare(strict_types=1);

namespace App\Tests\functional\Cart;

use App\Tests\functional\FunctionalTestInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class CartTestCase extends WebTestCase implements FunctionalTestInterface
{
    public function createCartRequest(KernelBrowser $client): array
    {
        $client->request(
            Request::METHOD_POST,
            '/api/carts',
        );

        return json_decode($client->getResponse()->getContent(), true);
    }
}
