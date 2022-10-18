<?php

declare(strict_types=1);

namespace App\Tests\unit\Core\Query;

use App\Core\Query\Query;
use App\Core\Query\QueryBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBus;
use PHPUnit\Framework\MockObject\MockObject;
use InvalidArgumentException;

class QueryBusTest extends TestCase
{
    private MockObject|MessageBus $messageBus;
    private QueryBus $queryBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageBus = $this->createMock(MessageBus::class);
        $this->queryBus = new QueryBus(
            $this->messageBus,
        );
    }

    public function testHandleWithDispatcherExceptionThrowShouldPassPreviousException(): void
    {
        // given
        $query = $this->createMock(Query::class);
        $previousException = new InvalidArgumentException();
        $exception = new HandlerFailedException(new Envelope(new \stdClass(), []), [$previousException]);

        // when
        $this->messageBus
            ->method('dispatch')
            ->with($query)
            ->willThrowException($exception);

        // then
        $this->expectException(InvalidArgumentException::class);
        $this->queryBus->handle($query);
    }
}
