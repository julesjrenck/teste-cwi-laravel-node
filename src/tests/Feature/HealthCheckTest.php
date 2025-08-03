<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_rota_health_retorna_status_ok(): void
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'ok',
                 ]);
    }
}
