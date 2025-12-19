<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MCP\MCPExecutor;
use Auth;

class ChatController extends Controller
{

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return 'success';
        }
        return 'failed';
    }

    public function chat(Request $request)
    {
        return response()->json([
            'response' => MCPExecutor::run($request->message)
        ]);
    }
}
