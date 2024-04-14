<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data = UserApiKey::where('user_id', $request->user()->id)->with('user')->get();

        $response = [
            'success' => true,
            'data' => $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'api_key' => $item->api_key,
                    'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                    'user' => [
                        'name' => $item->user->name,
                        'email' => $item->user->email,
                    ]
                ];
            }),
            'message' => 'API keys retrieved successfully'
        ];

        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $apiKey = Str::uuid(50);

        $data = UserApiKey::create([
            'user_id' => $request->user()->id,
            'api_key' => $apiKey
        ]);

        $response = [
            'success' => true,
            'message' => 'API key created successfully'
        ];

        return response()->json($response, 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data = UserApiKey::where('user_id', $request->user()->id)->where('id', $id)->delete();

        if($data) {
            $response = [
                'success' => true,
                'message' => 'API key deleted successfully'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'API key not found'
            ];
        }

        return response()->json($response, 200);
    }
}
