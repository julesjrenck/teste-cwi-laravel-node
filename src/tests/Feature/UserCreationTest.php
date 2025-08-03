<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_ser_criado_e_senha_e_hashada(): void
    {
        $nome = 'João da Silva';
        $email = 'joao@example.com';
        $senha = 'senha123';

        $response = $this->postJson('/api/users', [
            'name' => $nome,
            'email' => $email,
            'password' => $senha,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $nome,
            'email' => $email,
        ]);

        $user = User::where('email', $email)->first();

        $this->assertNotEquals($senha, $user->password);
        $this->assertTrue(Hash::check($senha, $user->password));
    }

    public function test_nao_permite_criar_usuario_sem_nome(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => '',
            'email' => 'teste@example.com',
            'password' => 'senha123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_nao_permite_criar_usuario_sem_email(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Nome Teste',
            'email' => '',
            'password' => 'senha123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_nao_permite_criar_usuario_com_email_invalido(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Nome Teste',
            'email' => 'email-invalido',
            'password' => 'senha123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_nao_permite_criar_usuario_com_email_ja_existente(): void
    {
        $emailExistente = 'existente@example.com';
        User::factory()->create([
            'email' => $emailExistente,
        ]);

        $response = $this->postJson('/api/users', [
            'name' => 'Outro Nome',
            'email' => $emailExistente,
            'password' => 'senha1234',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_nao_permite_criar_usuario_sem_senha(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Nome Teste',
            'email' => 'teste@example.com',
            'password' => '',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }

    public function test_nao_permite_criar_usuario_com_senha_curta(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Nome Teste',
            'email' => 'email@valido.com',
            'password' => '123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }
}
