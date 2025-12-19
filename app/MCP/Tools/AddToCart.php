<?php

namespace App\MCP\Tools;

use App\Models\Cart;
use App\Models\Product;

class AddToCart{
    public static function schema(): array{
        return [
            'type' => 'function',
            'function' => [
                'name' => 'add_to_cart',
                'description' => 'Add a product to the user cart',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'product_id' => [
                            'type' => 'integer',
                            'description' => 'ID of the product'
                        ],
                        'quantity' => [
                            'type' => 'integer',
                            'description' => 'Quantity of product',
                            'default' => 1
                        ]
                    ],
                    'required' => ['product_id']
                ]
            ]
        ];
    }

    public static function handle(array $params = [])
    {
        $userId = auth()->id();

        if (!$userId) {
            return ['error' => 'User must be logged in to add items to cart'];
        }

        $productId = $params['product_id'] ?? null;
        $quantity  = max(1, (int)($params['quantity'] ?? 1));

        $product = Product::find($productId);
        if (!$product) {
            return ['error' => 'Product not found'];
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId,
            ],
            [
                'quantity' => \DB::raw("quantity + {$quantity}")
            ]
        );

        return [
            'message' => 'Product added to cart',
            'product' => $product->name,
            'quantity' => $cart->quantity
        ];
    }
}