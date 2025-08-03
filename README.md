# Teste Técnico - Laravel + Node.js + Microsserviços

Este projeto é uma solução para o desafio técnico com foco em desenvolvimento backend usando Laravel, integração com microsserviços (Node.js), Docker, testes automatizados e boas práticas de desenvolvimento.

## 🔧 Tecnologias Utilizadas

- **Laravel 12.21.0**
- **PHP 8.3.6**
- **MySQL**
- **Node.js (Express)**
- **Docker + Docker Compose**
- **PHPUnit**
- **Postman (para testes manuais)**
- **Git + GitHub**

## 📁 Estrutura do Projeto


├── src / # Projeto Laravel

│ ├── app/

│ ├── tests/Feature/

│ └── ...

├── node-mock-service/ # Microsserviço mock em Node.js

│ ├── index.js

│ └── ...

├── docker-compose.yml # Orquestra os containers

└── README.md


---

## 🚀 Como Executar o Projeto

### Pré-requisitos

- Docker e Docker Compose instalados.

### Subindo o ambiente:

```bash
docker-compose up --build
```

## Laravel

1. Na pasta do projeto Laravel, instale as dependências com Composer:

```bash
composer install
```

2. Copie o arquivo de exemplo .env.example para .env:

```bash
cp .env.example .env
```

3. Gere a chave da aplicação:

```bash
docker-compose exec app php artisan key:generate
```

4. Rode as migrations para criar as tabelas no banco:

```bash
docker-compose exec app php artisan migrate
```

## Microsserviço Node.js

1.Acesse a pasta do microsserviço Node.js (ex: node-mock-service):

```bash
cd node-mock-service
```

2. Instale as dependências com npm:

```bash
npm install
```

3. Inicie o microsserviço:

```bash
node index.js
```

A aplicação Laravel estará disponível em: [http://localhost:8000](http://localhost:8000)  
O microsserviço Node.js estará disponível em: [http://localhost:3001](http://localhost:3001)

## 🧪 Testes Automatizados

Os testes estão organizados na pasta `tests/Feature`. Para executá-los:

```bash
docker-compose exec app php artisan test
```

## ✅ Testes Implementados

- ✅ **Criação de usuários**
- ✅ **Validações**
  - Nome ausente
  - E-mail inválido
  - E-mail duplicado
  - E-mail ausente
  - Senha curta
  - Senha ausente
- ✅ **Atualização de usuários**
  - Atualização individual de nome, e-mail e senha
- ✅ **Exclusão de usuários**
- ✅ **Verificação de hash da senha**
- ✅ **Teste da rota `/api/health`**
- ✅ **Integração com serviço externo (`/api/external`)**

## 🔐 Funcionalidades

- API RESTful para gerenciamento de usuários
- Validações completas com **Form Request Validation**
- Criptografia de senha utilizando `Hash::make`
- Comunicação com microsserviço externo via HTTP (Guzzle)
- Testes automatizados com PHPUnit cobrindo regras de negócio e integração
- Dockerização completa utilizando Laravel + Node.js
  
## 📄 Endpoints

### 🧑‍💼 Usuários

- `GET /api/users` — Lista usuários  
- `POST /api/users` — Cria novo usuário  
- `GET /api/users/{id}` — Detalha um usuário  
- `PUT /api/users/{id}` — Atualiza usuário  
- `DELETE /api/users/{id}` — Remove usuário  

### 🔧 Serviços

- `GET /api/health` — Verifica status da API Laravel  
- `GET /api/external` — Integração com microsserviço externo

## 📌 Considerações Finais

Este projeto foi desenvolvido com foco em:

- Clareza e organização do código  
- Separação de responsabilidades  
- Boas práticas de versionamento e testes  
- Simulação de cenário real com serviços separados  

## 🧑‍💻 Autor

Desenvolvido por **Jules Jander Renck** para o desafio técnico.





