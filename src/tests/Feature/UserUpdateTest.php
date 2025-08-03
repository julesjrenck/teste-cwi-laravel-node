<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_nao_permite_atualizar_usuario_com_nome_vazio(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => '',
            'email' => 'novoemail@example.com',
            'password' => 'senha1234',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_permite_atualizar_somente_nome(): void
    {
        $user = User::factory()->create();
        $novoNome = 'Nome Atualizado';

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => $novoNome
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $novoNome
        ]);
    }

    public function test_nao_permite_atualizar_usuario_com_email_vazio(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Nome Atualizado',
            'email' => '',
            'password' => 'senha1234',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_permite_atualizar_somente_email(): void
    {
        $user = User::factory()->create();
        $novoEmail = 'novoemail@example.com';

        $response = $this->putJson("/api/users/{$user->id}", [
            'email' => $novoEmail
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $novoEmail
        ]);
    }

    public function test_nao_permite_atualizar_usuario_com_email_invalido(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Nome Atualizado',
            'email' => 'email-invalido',
            'password' => 'senha1234',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_nao_permite_atualizar_usuario_com_email_ja_existente_em_outro_usuario(): void
    {
        $emailExistente = 'existente@example.com';
        $user1 = User::factory()->create([
            'email' => $emailExistente,
        ]);

        $user2 = User::factory()->create();

        $response = $this->putJson("/api/users/{$user2->id}", [
            'name' => 'Nome Atualizado',
            'email' => $emailExistente,
            'password' => 'senha1234',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_nao_permite_atualizar_usuario_com_senha_curta(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Nome Atualizado',
            'email' => 'novoemail@example.com',
            'password' => '123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }

    public function test_permite_atualizar_usuario_sem_alterar_senha(): void
    {
        $user = User::factory()->create();
        $novoNome = 'Nome Atualizado';
        $novoEmail = 'novoemail@example.com';

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => $novoNome,
            'email' => $novoEmail,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $novoNome,
            'email' => $novoEmail,
        ]);
    }

    public function test_permite_atualizar_somente_a_senha(): void
    {
        $senhaNova = 'senhaNova123';

        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'password' => $senhaNova,
        ]);

        $response->assertStatus(200);

        $user->refresh();

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check($senhaNova, $user->password));
    }
}
