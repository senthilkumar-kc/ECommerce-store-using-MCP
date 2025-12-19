<?php
namespace App\MCP\Tools;
class BrowseProducts
{
    public static function schema(): array
    {
        return[
            'type' => 'function',
            'function' => [
                'name' => 'browse_products',
                'description' => 'List available products',
                'parameters' => [
                    'type' => 'object',
                    'properties' => (object) []
                ]
            ]
        ];
    }

    public static function handle()
    {
        return \App\Models\Product::select('id','prd_title','desc')->get();
    }
}
