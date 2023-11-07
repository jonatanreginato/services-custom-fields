<?php

declare(strict_types=1);

namespace Nuvemshop\ApiTemplate\Infrastructure\Log\Handler;

use Monolog\Handler\BufferHandler;
use Monolog\LogRecord;

class TimeOutBufferHandler extends BufferHandler
{
    private int $timeout = 60;

    private ?int $firstRecordTime = null;

    private ?int $lastRecordTime = null;

    public function handle(LogRecord $record): bool
    {
        if (!$this->firstRecordTime) {
            $this->firstRecordTime = time();
        }

        $this->lastRecordTime = time();

        parent::handle($record);

        $this->flushOnTimeout();

        return $this->bubble === false;
    }

    private function flushOnTimeout(): void
    {
        if (($this->lastRecordTime - $this->firstRecordTime) >= $this->timeout) {
            $this->firstRecordTime = null;
            $this->lastRecordTime  = null;

            $this->flush();
        }
    }
}
