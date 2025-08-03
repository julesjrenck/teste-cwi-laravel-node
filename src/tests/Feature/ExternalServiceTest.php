<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExternalServiceTest extends TestCase
{
    public function test_rota_external_retorna_dados_do_mock_node(): void
    {
        Http::fake([
            'http://node:3001/api/info' => Http::response([
                'service' => 'mock-service',
                'version' => '1.0',
                'status' => 'running',
            ], 200),
        ]);

        $response = $this->getJson('/api/external');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'service' => 'mock-service',
                         'version' => '1.0',
                         'status' => 'running',
                     ],
                 ]);
    }
    
}
