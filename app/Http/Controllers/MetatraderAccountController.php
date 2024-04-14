<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMetatraderAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
