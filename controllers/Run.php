<?php

namespace Rhymix\Modules\Mcpserver\Controllers;

use PhpMcp\Server\Server;
use PhpMcp\Schema\ServerCapabilities;
use PhpMcp\Server\Transports\StreamableHttpServerTransport;
use Rhymix\Modules\Mcpserver\Models\Config as ConfigModel;
use Rhymix\Modules\Mcpserver\Models\MCPCache;
use Rhymix\Modules\Mcpserver\Models\MCPLogger;
use Rhymix\Modules\Mcpserver\Models\DirectoryScanner;

if (PHP_SAPI === 'cli')
{
    require_once __DIR__ . '/../../../common/scripts/common.php';
}

class Run extends Base
{
	public static function start()
	{
		$config = ConfigModel::getConfig();
        $cache = MCPCache::getInstance($config);
        $logger = MCPLogger::getInstance($config);

        $server = Server::make()
            ->withServerInfo(
                name: $config->serverName,
                version: $config->serverVersion,
            )
            ->withLogger($logger)
            ->withCache($cache)
            ->build();

        $baseDir = realpath(__DIR__ . '/../../');
        $logger->info("Scanning for MCP directories in: $baseDir");
        $paths = DirectoryScanner::scan($baseDir, '*/mcp');
        $logger->info("Found MCP directories: " . implode(', ', $paths));
        $server->discover($baseDir, $paths);

        $transport = new StreamableHttpServerTransport(
            host: $config->serverHost,
            port: $config->serverPort,
            mcpPath: $config->mcpPath,
            enableJsonResponse: $config->mcpEnableJsonResponse,
            stateless: $config->mcpStateless
        );

        $server->listen($transport);
	}
}

if (PHP_SAPI === 'cli')
{
    Run::start();
}