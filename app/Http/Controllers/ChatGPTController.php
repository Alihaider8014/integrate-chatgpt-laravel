<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatGPTController extends Controller
{
    public function chatGPT(Request $request)
    {
        // Create a new Guzzle client
        $client = new Client();

        // Make a request to the OpenAI API
        $response = $client->request('POST','https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'messages' => [['role' => 'user', 'content' => $request->input('prompt')]],
                'model'    => "gpt-3.5-turbo",
                'temperature' => 0.8
            ],
        ]);

        // Get the response body and return it as JSON
        $responseBody = json_decode($response->getBody(), true);
        $chatResponse = $responseBody['choices'][0]['message']['content'];

        return response()->json([
            'message' => $chatResponse,
        ]);
    }
}
