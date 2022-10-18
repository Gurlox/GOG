<?php

declare(strict_types=1);

namespace App\Tests\functional;

use PHPUnit\Runner\BeforeTestHook;
use ReflectionClass;

class FunctionalTestExtension implements BeforeTestHook
{
    public function executeBeforeTest(string $class): void
    {
        $class = new ReflectionClass(explode('::', $class)[0]);

        if (false === $class->implementsInterface(FunctionalTestInterface::class)) {
            return;
        }

        passthru('php bin/console d:s:d --force --env=test');
        passthru('php bin/console d:s:u --force --env=test');

        echo ' Done' . PHP_EOL . PHP_EOL;
    }
}
