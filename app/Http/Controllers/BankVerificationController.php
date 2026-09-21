<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BankVerificationController extends Controller
{
    public function verify(Request $request, Client $client)
    {
        $validated = $request->validate([
            'account_number' => 'required|digits:10',
            'bank_code' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
        ]);

        try {

            $response = Http::timeout(20)
                ->withHeaders([
                    'Authorization' => config('services.dojah.secret_key'),
                    'AppId' => config('services.dojah.app_id'),
                    'Accept' => 'application/json',
                ])
                ->get(
                    config('services.dojah.base_url') . '/api/v1/general/account',
                    [
                        'account_number' => $validated['account_number'],
                        'bank_code' => $validated['bank_code'],
                    ]
                );

            if (!$response->successful()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Bank verification failed.',
                ], 422);
            }

            $data = $response->json();

            /*
             * We'll confirm this path against the exact response
             * returned by your Dojah account.
             */
            $accountName =
                data_get($data, 'entity.account_name')
                ?? data_get($data, 'data.account_name')
                ?? data_get($data, 'account_name');

            if (!$accountName) {

                return response()->json([
                    'success' => false,
                    'message' => 'Account name was not returned by Dojah.',
                ], 422);
            }

            $client->update([
                'bank_name' => $validated['bank_name'],
                'bank_code' => $validated['bank_code'],
                'account_number' => $validated['account_number'],
                'account_name' => $accountName,
                'bank_verified' => true,
            ]);

            ActivityLogger::log(
                'Verify',
                'Bank Account',
                'Verified settlement account for ' .
                $client->first_name . ' ' .
                $client->last_name
            );

            return response()->json([
                'success' => true,
                'account_name' => $accountName,
                'message' => 'Bank account verified successfully.',
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to contact the verification service.',
            ], 500);
        }
    }
}