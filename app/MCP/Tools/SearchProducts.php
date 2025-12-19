<?php
namespace App\MCP\Tools;
class SearchProducts
{
    public static function schema(): array{
        return[
            'type' => 'function',
            'function' => [
                'name' => 'search_products',
                'description' => 'Search products by keyword',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'keyword' => [
                            'type' => 'string',
                            'description' => 'Search keyword like shoes, footwear, sports'
                        ]
                    ],
                    
                ]
            ]
        ];
    }

    public static function handle(array $params){
        
        $keyword = trim($params['keyword'] ?? '');

        if ($keyword === '') {
            return [
                'message' => 'Please provide a keyword to search products'
            ];
        }

        return \App\Models\Product::where('prd_title', 'LIKE', "%{$keyword}%")
            ->orWhere('desc', 'LIKE', "%{$keyword}%")
            ->select('id', 'prd_title', 'desc')
            ->get();
    }
}
