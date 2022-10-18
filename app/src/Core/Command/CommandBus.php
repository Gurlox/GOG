<?php

declare(strict_types=1);

namespace App\Core\Command;

use App\Core\AbstractBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class CommandBus extends AbstractBus
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function handle(Command $command)
    {
        try {
            return $this->messageBus->dispatch($command)->last(HandledStamp::class)->getResult();
        } catch (Throwable $exception) {
            $this->throwException($exception);
        }
    }
}
