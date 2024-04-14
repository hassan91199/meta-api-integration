<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MetatraderAccountController extends Controller
{
    public function store(Request $request)
    {
        $deployAccountApiUrl = 'https://mt-provisioning-api-v1.agiliumtrade.agiliumtrade.ai/users/current/accounts';

        $request->validate([
            'account_name' => 'required|string',
            'mt_version' => 'required|string',
            'mt_login' => 'required|string',
            'mt_password' => 'required|string',
            'mt_server_name' => 'required|string',
            'meta_api_access_key' => 'required|string',
        ]);

        $data = [
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

        $response = Http::withHeaders([
            'auth-token' => $request->input('meta_api_access_key'),
            'transaction-id' => '7Fb2tR9wGnE4sL5pY3ZaX6cD8vQ0uV2x'
        ])->post($deployAccountApiUrl, $data);

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
