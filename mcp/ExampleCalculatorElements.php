<?php

namespace Rhymix\Modules\Mcpserver\Mcp;

use Rhymix\Modules\Mcpserver\Models\MCPServerInterface;
use PhpMcp\Server\Attributes\McpTool;
use PhpMcp\Server\Attributes\Schema;

/**
 * ExampleCalculatorElements
 * 
 * This class provides example MCP tools for basic calculations.
 * 
 * @package Rhymix\Modules\Mcpserver\Mcp
 */
class ExampleCalculatorElements extends MCPServerInterface
{
    /**
     * Adds two numbers together.
     * 
     * @param int $a The first number
     * @param int $b The second number  
     * @return int The sum of the two numbers
     */
    #[McpTool(name: 'add_numbers')]
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * Calculates power with validation.
     */
    #[McpTool(name: 'calculate_power')]
    public function power(
        #[Schema(type: 'number', minimum: 0, maximum: 1000)]
        float $base,
        
        #[Schema(type: 'integer', minimum: 0, maximum: 10)]
        int $exponent
    ): float {
        return pow($base, $exponent);
    }
}