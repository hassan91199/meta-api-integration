<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMetatraderAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MetatraderAccountController extends Controller
{
    public function store(StoreMetatraderAccount $request)
    {
        // Meta API URL for adding/deploying the Metatrader Account
        $url = 'https://mt-provisioning-api-v1.agiliumtrade.agiliumtrade.ai/users/current/accounts';

        // Headers for the request to add/deploy the Metatrader Account
        $headers = [
            'auth-token' => env('META_API_ACCESS_KEY'),
            'transaction-id' => '7Fb2tR9wGnE4sL5pY3ZaX6cD8vQ0uV2x'
        ];

        // Body for the request to add/deploy the Metatrader Account
        $body = [
            "symbol" => "EURUSD",
            "magic" => 0,
            "quoteStreamingIntervalInSeconds" => 2.5,
            "tags" => [],
            "reliability" => "high",
            "resourceSlots" => 1,
            "copyFactoryResourceSlots" => 1,
            "region" => "london",
            "name" => $request->input('account_name'),
            "manualTrades" => false,
            "slippage" => 0,
            "platform" => $request->input('mt_version'),
            "login" => $request->input('mt_login'),
            "password" => $request->input('mt_password'),
            "server" => $request->input('mt_server_name'),
            "type" => "cloud-g2",
            "copyFactoryRoles" => [],
            "metastatsApiEnabled" => true
        ];

        // Sending the request to MetaAPI with above headers and body
        $response = Http::withHeaders($headers)
            ->post($url, $body);

        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json($responseData);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();

            return response()->json(['error' => $errorMessage], $errorCode);
        }
    }

    public function getHistoricalTrades(Request $request)
    {
        $oldestTimestamp = substr(Carbon::createFromTimestamp(0)->format('Y-m-d H:i:s.u'), 0, -3);
        $currentTimestamp = substr(Carbon::now()->format('Y-m-d H:i:s.u'), 0, -3);

        $validatedData = $request->validate([
            'account_id' => 'required|string',
        ]);

        $accountId = $validatedData['account_id'];

        // Meta API URL for adding/deploying the Metatrader Account
        $url = 'https://metastats-api-v1.london.agiliumtrade.ai/users/current/accounts/218cac6c-c014-4051-b4d0-b3d8d2db5d46/historical-trades/2023-01-01%2000%3A00%3A00.000/2024-01-01%2000%3A00%3A00.000?updateHistory=true';

        // Headers for the request to add/deploy the Metatrader Account
        $headers = [
            'auth-token' => env('META_API_ACCESS_KEY'),
        ];
        
        return response()->json([
            'old' => $oldestTimestamp,
            'current' => $currentTimestamp,
        ]);
        
        // Sending the request to MetaAPI with above headers and body
        $response = Http::withHeaders($headers)
            ->post($url, $body);

        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json($responseData);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();
            
            return response()->json(['error' => $errorMessage], $errorCode);
        }
    }
}
