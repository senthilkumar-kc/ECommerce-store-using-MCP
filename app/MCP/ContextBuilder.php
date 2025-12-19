<?php
namespace App\MCP;

use Illuminate\Support\Facades\Auth;

class ContextBuilder
{
    public static function build(): array
    {
        $user = Auth::user();

        return [
            'user' => [
                'id' => $user?->id,
                'name' => $user?->name,
                'role' => $user?->role ?? 'guest',
            ],
            'capabilities' => [
                'can_order' => $user !== null,
            ]
        ];
    }
}
