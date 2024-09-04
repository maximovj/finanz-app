<?php
namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class FinanzLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('custom');

        $format = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        $dateFormat = "Y-m-d H:i:s";
        $formatter = new LineFormatter($format, $dateFormat);

        $streamHandler = new StreamHandler(storage_path('logs/finanz.log'), Logger::DEBUG);
        $streamHandler->setFormatter($formatter);

        $logger->pushHandler($streamHandler);
        return $logger;
    }
}
