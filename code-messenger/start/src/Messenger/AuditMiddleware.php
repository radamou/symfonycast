<?php

namespace App\Messenger;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class AuditMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(LoggerInterface $messengerAuditLogger)
    {
        $this->logger = $messengerAuditLogger;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(UniqueIdStamp::class)) {
            $envelope = $envelope->with(new UniqueIdStamp());
        }

        /** @var UniqueIdStamp $stamp */
        $stamp = $envelope->last(UniqueIdStamp::class);

        $context = [
            'id' => $stamp->getUniqId(),
            'class' => get_class($envelope->getMessage())
        ];

        if ($envelope->last(ReceivedStamp::class)) {
            $this->logger->info('[{id}] Received & handling {class}', $context);
        }else {
            $this->logger->info('[{id}] Handling or sending {class}', $context);
        }

       return $stack->next()->handle($envelope, $stack);
    }
}
