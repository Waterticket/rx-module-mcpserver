<?php

namespace Rhymix\Modules\Mcpserver\Models;

require_once __DIR__ . '/../vendor/autoload.php';

use PhpMcp\Server\Registry as PhpMcpRegistry;
use PhpMcp\Schema\Prompt;
use PhpMcp\Schema\Resource;
use PhpMcp\Schema\ResourceTemplate;
use PhpMcp\Schema\Tool;

class DummyRegistry extends PhpMcpRegistry
{
    public array $tools = [];
    public array $resources = [];
    public array $resourceTemplates = [];
    public array $prompts = [];

    public function registerTool(Tool $tool, callable|array|string $handler, bool $isManual = false): void
    {
        $this->tools[$tool->name] = [
            'tool' => $tool,
            'handler' => $handler,
            'isManual' => $isManual,
        ];
    }

    public function registerResource(Resource $resource, callable|array|string $handler, bool $isManual = false): void
    {
        $this->resources[$resource->name] = [
            'resource' => $resource,
            'handler' => $handler,
            'isManual' => $isManual,
        ];
    }

    public function registerResourceTemplate(
        ResourceTemplate $template,
        callable|array|string $handler,
        array $completionProviders = [],
        bool $isManual = false,
    ): void
    {
        $this->resourceTemplates[$template->name] = [
            'template' => $template,
            'handler' => $handler,
            'completionProviders' => $completionProviders,
            'isManual' => $isManual,
        ];
    }

    public function registerPrompt(
        Prompt $prompt,
        callable|array|string $handler,
        array $completionProviders = [],
        bool $isManual = false,
    ): void
    {
        $this->prompts[$prompt->name] = [
            'prompt' => $prompt,
            'handler' => $handler,
            'completionProviders' => $completionProviders,
            'isManual' => $isManual,
        ];
    }
}