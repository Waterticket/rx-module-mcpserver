<?php

namespace Rhymix\Modules\Mcpserver\Models;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class MCPLogger implements LoggerInterface
{
    private static ?MCPLogger $instance = null;
    private static bool $printLog = true;
    private static array $printLogLevels = [
        LogLevel::EMERGENCY => true,
        LogLevel::ALERT => true,
        LogLevel::CRITICAL => true,
        LogLevel::ERROR => true,
        LogLevel::WARNING => true,
        LogLevel::NOTICE => true,
        LogLevel::INFO => true,
        LogLevel::DEBUG => true,
    ];

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if (!self::$printLog) {
            return; // 로그 출력이 비활성화된 경우 무시
        }
        if (!isset(self::$printLogLevels[$level]) || !self::$printLogLevels[$level]) {
            return; // 로그 레벨이 출력 대상이 아니면 무시
        }

        $timestamp = date('Y-m-d H:i:s');
        $interpolated = $this->interpolate((string)$message, $context);

        // CLI 환경이면 STDOUT으로 출력
        if (php_sapi_name() === 'cli') {
            fwrite(STDOUT, "[$timestamp] [$level] $interpolated" . PHP_EOL);
        } else {
            // 웹 환경일 경우 error_log() 사용
            error_log("[$timestamp] [$level] $interpolated");
        }
    }

    /**
     * 메시지 안의 {placeholder}를 context 값으로 치환
     */
    private function interpolate(string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
    }

    public static function getInstance(object $config): MCPLogger
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$printLog = $config->printLog ?? true;
            self::$instance->setPrintLogLevels($config->printLogLevels);
        }
        return self::$instance;
    }

    private static function setPrintLogLevels(array $levels): void
    {
        foreach ($levels as $level => $print) {
            if (isset(self::$printLogLevels[$level])) {
                self::$printLogLevels[$level] = (bool)$print;
            }
        }
    }
}
