<?php

namespace App\MCP;
use App\MCP\Tools\BrowseProducts;
use App\MCP\Tools\SearchProducts;
use App\MCP\Tools\AddToCart;

class ToolRegistry
{
    public static function tools(): array
    {
        return [
            BrowseProducts::schema(),
            SearchProducts::schema(),
            AddToCart::schema(),
        ];
    }

    public static function execute($name, $params)
    {
        return match ($name) {
            'browse_products' => BrowseProducts::handle(),
            'search_products' => SearchProducts::handle($params),
            'add_to_cart' => AddToCart::handle($params),
            default => throw new \Exception('Invalid MCP Tool')
        };
    }
}
