<?php

namespace Rhymix\Modules\Mcpserver\Models;

use Psr\Log\LoggerInterface;
use PhpMcp\Server\Utils\Discoverer;
use Rhymix\Modules\Mcpserver\Models\Config as ConfigModel;

/**
 * MCP Server
 * 
 * Copyright (c) Waterticket
 * 
 * Generated with https://www.poesis.dev/tools/rxmodulegen
 */
class MethodValidator
{
    private static ?string $uniqueKey = null;
    private static ?bool $disableExampleMethods = null;

    public static function getDiscoverDirs(LoggerInterface $logger): array
    {
        $baseDir = realpath(__DIR__ . '/../../');
        $logger->info("Scanning for MCP directories in: $baseDir");
        $paths = DirectoryScanner::scan($baseDir, '*/mcp');
        $logger->info("Found MCP directories: " . implode(', ', $paths));

        return [$baseDir, $paths];
    }

    public static function getMethods(): object
    {
        $logger = new DummyLogger();
		$registry = new DummyRegistry($logger);

		$discoverer = new Discoverer(
			$registry,
			$logger,
		);

		[$baseDir, $paths] = MethodValidator::getDiscoverDirs($logger);
        if (self::$disableExampleMethods === null) {
            self::$disableExampleMethods = ConfigModel::getConfig()->disableExampleMethods ?? false;
        }

        if (self::$disableExampleMethods) {
            $paths = array_filter($paths, function ($path) {
                return $path !== 'mcpserver/mcp';
            });
        }

		$discoverer->discover($baseDir, $paths);

        $output = new \stdClass();
        $output->tools = $registry->tools;
        $output->resources = $registry->resources;
        $output->resourceTemplates = $registry->resourceTemplates;
        $output->prompts = $registry->prompts;

        return $output;
    }

    public static function isMethodChangedAfterExecute(): bool
    {
        $currentMethodLock = self::getMethodLocks();
        $previousMethodLock = self::getLockFileValues();

        if (empty($previousMethodLock)) {
            return false;
        }

        // Compare current and previous method locks
        foreach ($currentMethodLock as $name => $hash) {
            if (!isset($previousMethodLock[$name]) || $previousMethodLock[$name] !== $hash) {
                return true;
            }
        }

        return false;
    }

    public static function updateLockFile(): void
    {
        $currentMethodLock = self::getMethodLocks();
        
        foreach ($currentMethodLock as $name => $hash) {
            self::setLockFileValue($name, $hash);
        }
    }

    protected static function getMethodLocks(): array
    {
        $locks = [];
        $methods = self::getMethods();

        foreach ($methods as $name => $value) {
            $serialized = serialize($value);
            $hash = hash('sha256', $serialized);
            $locks[$name] = $hash;
        }

        return $locks;
    }

    protected static function getLockFileName(): string
    {
        $dir = \RX_BASEDIR . 'files/mcpserver/';
        if (self::$uniqueKey === null) {
            self::$uniqueKey = ConfigModel::getConfig()->uniqueKey;
        }

        return $dir . 'methods.' . self::$uniqueKey . '.lock';
    }

    protected static function getLockFileValues(): array
    {
        $file = self::getLockFileName();
        if (!file_exists($file)) {
            return [];
        }

        $content = file_get_contents($file);
        if ($content === false) {
            return [];
        }

        return json_decode($content, true);
    }

    protected static function setLockFileValue(string $key, string $value): void
    {
        $file = self::getLockFileName();
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0755, true);
        }

        if (!is_writable(dirname($file))) {
            throw new \RuntimeException("Cannot write to lock file directory: " . dirname($file));
        }

        if (file_exists($file) && !is_writable($file)) {
            throw new \RuntimeException("Cannot write to lock file: " . $file);
        }

        $data = self::getLockFileValues();
        $data[$key] = $value;
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
