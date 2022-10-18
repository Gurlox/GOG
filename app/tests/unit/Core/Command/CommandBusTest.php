<?php

declare(strict_types=1);

namespace App\Tests\unit\Core\Command;

use App\Core\Command\Command;
use App\Core\Command\CommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBus;
use PHPUnit\Framework\MockObject\MockObject;
use InvalidArgumentException;

class CommandBusTest extends TestCase
{
    private MockObject|MessageBus $messageBus;
    private CommandBus $commandBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageBus = $this->createMock(MessageBus::class);
        $this->commandBus = new CommandBus(
            $this->messageBus,
        );
    }

    public function testHandleWithDispatcherExceptionThrowShouldPassPreviousException(): void
    {
        // given
        $command = $this->createMock(Command::class);
        $previousException = new InvalidArgumentException();
        $exception = new HandlerFailedException(new Envelope(new \stdClass(), []), [$previousException]);

        // when
        $this->messageBus
            ->method('dispatch')
            ->with($command)
            ->willThrowException($exception);

        // then
        $this->expectException(InvalidArgumentException::class);
        $this->commandBus->handle($command);
    }
}
