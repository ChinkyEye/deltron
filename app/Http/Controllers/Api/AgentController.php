<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agent;
use Response;

class AgentController extends Controller
{
    public function index()
    {
        $posts = Agent::all();
        $response = [
            'agents' => $posts
        ];
        // return response()->json($response);
        return Response::json($response);
    }

    public function store(Request $request)
    {
        $posts = Agent::create($request->all());
        return response()->json(['message'=> 'message created'], 201);
    }
}
