<?php

namespace Rhymix\Modules\Mcpserver\Controllers;

use PhpMcp\Server\Server;
use PhpMcp\Schema\ServerCapabilities;
use PhpMcp\Server\Transports\StreamableHttpServerTransport;
use Rhymix\Modules\Mcpserver\Models\Config as ConfigModel;
use Rhymix\Modules\Mcpserver\Models\MCPCache;

if (PHP_SAPI === 'cli')
{
    require_once __DIR__ . '/../../../common/scripts/common.php';
}

class Run extends Base
{
	public static function start()
	{
		$config = ConfigModel::getConfig();
        $cache = MCPCache::getInstance();

        $server = Server::make()
            ->withServerInfo('Streamable Server', '1.0.0')
            // ->withLogger($logger)
            ->withCache($cache)
            ->build();

        $server->discover(__DIR__ . '/../../', ['mcp']);

        $transport = new StreamableHttpServerTransport(
            host: '0.0.0.0',
            port: 9030,
            mcpPath: '/mcp',
            enableJsonResponse: false,
            stateless: false
        );

        $server->listen($transport);
	}
}

if (PHP_SAPI === 'cli')
{
    Run::start();
}