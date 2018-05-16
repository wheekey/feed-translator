<?php
/**
 * Created by PhpStorm.
 * User: ermakov
 * Date: 15.03.18
 * Time: 16:54
 */

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Psr\Log\LoggerInterface;

return [
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('my_logger');

        // Now add some handlers
        try {
            $logger->pushHandler(new StreamHandler(getenv("APP_DIR") . getenv("LOG_DIR") . '/my_app.log', Logger::DEBUG));
            $logger->pushHandler(new FirePHPHandler());
        } catch (Exception $e) {
            echo $e . PHP_EOL;
        }

        return $logger;
    }),
];