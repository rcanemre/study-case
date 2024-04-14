<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserApiKey;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data = UserData::where('user_id', $request->user()->id)->with('user')->get();

        $response = [
            'success' => true,
            'data' => $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'api_key' => $item->api_key,
                    'value' => $item->value,
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
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|string|max:50',
            'value' => 'required',
        ]);

        if($validator->fails())
        {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }

        $userApiKey = UserApiKey::where('api_key', $request->api_key)->first();

        if (!$userApiKey) {
            return response()->json(['message' => 'API key not found']);
        }

        $userData = UserData::where('api_key', $request->api_key)
            ->where('user_id', $userApiKey->user_id)
            ->first();

        if ($userData) {
            $userData->update(['value' => $request->value]);

            $response = [
                'success' => true,
                'message' => 'Value updated successfully'
            ];
        } else {
            UserData::create([
                'user_id' => $userApiKey->user_id,
                'api_key' => $request->api_key,
                'value' => $request->value
            ]);

            $response = [
                'success' => true,
                'message' => 'New record created successfully'
            ];
        }

        return response()->json($response, 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized']);
        }

        $data = UserData::where('user_id', $request->user()->id)->where('id', $id)->delete();

        if($data) {
            $response = [
                'success' => true,
                'message' => 'Your data deleted successfully'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Data not found'
            ];
        }

        return response()->json($response, 200);
    }
}
