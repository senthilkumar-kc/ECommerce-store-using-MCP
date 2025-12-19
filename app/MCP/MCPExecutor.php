<?php
namespace App\MCP;

use OpenAI;

class MCPExecutor
{
    protected $client;

    public static function run($message)
    {
        $context = ContextBuilder::build();

        $ai_client = OpenAI::factory()
            ->withApiKey(env('GROQ_API_KEY'))
            ->withBaseUri('https://api.groq.com/openai/v1') // Important!
            ->make();

        $response = $ai_client->chat()->create([
            'model' => 'llama-3.3-70b-versatile',  // model name
            'messages' => [
                ['role' => 'system', 'content' => 'You are an ecommerce assistant.
                    Roles:
                    - If the user asks to search, find, or look for a product by keyword,
                    - you MUST call the search_products tool.
                    - If no keyword is provided, use browse_products.
                    - If the user asks to add a product to cart, use add_to_cart.
                    - You MUST extract product_id from previous responses.
                    - Quantity defaults to 1 if not mentioned.
                    - Never add to cart without product_id.'
                ],
                ['role' => 'system', 'content' => json_encode($context)],
                ['role' => 'user', 'content' => $message],
            ],
            'tools' => ToolRegistry::tools(),
            'tool_choice' => 'auto',
        ]);

        $messageObj = $response->choices[0]->message;

        $toolCalls = $messageObj->toolCalls ?? [];

        if (empty($toolCalls)) {
            return $messageObj->content;
        }

        // Execute first tool call
        $toolCall = $toolCalls[0];

        $toolName = $toolCall->function->name;
        $arguments = json_decode($toolCall->function->arguments, true) ?? [];

        return ToolRegistry::execute($toolName, $arguments);

    }
}
