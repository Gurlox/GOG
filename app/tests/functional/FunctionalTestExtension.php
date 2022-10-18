<?php

declare(strict_types=1);

namespace App\Tests\functional;

use PHPUnit\Runner\BeforeTestHook;
use ReflectionClass;

class FunctionalTestExtension implements BeforeTestHook
{
    private static $dbResetPerformed = false;

    public function executeBeforeTest(string $class): void
    {
        $class = new ReflectionClass(explode('::', $class)[0]);

        if (false === $class->implementsInterface(FunctionalTestInterface::class) || true === self::$dbResetPerformed) {
            return;
        }

        passthru('php bin/console d:s:d --force --env=test');
        passthru('php bin/console d:s:u --force --env=test');

        echo ' Done' . PHP_EOL . PHP_EOL;

        self::$dbResetPerformed = true;
    }
}
