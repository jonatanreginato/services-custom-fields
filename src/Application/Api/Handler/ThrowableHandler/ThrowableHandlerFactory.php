<?php

declare(strict_types=1);

namespace Nuvemshop\CustomFields\Application\Api\Handler\ThrowableHandler;

use Nuvemshop\CustomFields\Application\Api\Settings\ApiSettingsInterface;
use Nuvemshop\CustomFields\Infrastructure\Log\Logger\LoggerType;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class ThrowableHandlerFactory
{
    public function __invoke(ContainerInterface $container): ThrowableHandlerInterface
    {
        $apiSettings = $container->get('config')['api'];

        $isLogEnabled = $apiSettings[ApiSettingsInterface::IS_LOG_ENABLED];
        $isDebug      = $apiSettings[ApiSettingsInterface::IS_DEBUG];

        $ignoredErrorClasses = $apiSettings[ApiSettingsInterface::DO_NOT_LOG_EXCEPTIONS_LIST];
        $codeForUnexpected   = $apiSettings[ApiSettingsInterface::HTTP_CODE_FOR_UNEXPECTED_THROWABLE];
        $throwableConverter  = $apiSettings[ApiSettingsInterface::JSON_API_EXCEPTION_CONVERTER] ?? null;

        $handler = new ThrowableHandler(
            $ignoredErrorClasses,
            $codeForUnexpected,
            $isDebug,
            $throwableConverter
        );

        if ($isLogEnabled && $container->has(LoggerType::FILE)) {
            /** @var LoggerInterface $logger */
            $logger = $container->build(
                LoggerType::FILE,
                $container->get('config')['log']['file_throwable_handler']['options']
            )->logger;
            $handler->setLogger($logger);
        }

        return $handler;
    }
}
