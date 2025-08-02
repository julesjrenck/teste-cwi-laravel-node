<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ExternalServiceController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://node:3001/api/info');

            return response()->json([
                'success' => true,
                'data' => $response->json(),
            ]);
        } catch (RequestException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao acessar serviço externo.',
            ], 500);
        }
    }
}
