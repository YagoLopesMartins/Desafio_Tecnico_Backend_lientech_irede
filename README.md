# API de Produtos

Esta é uma API desenvolvida em Laravel para gerenciar produtos e categorias.

## Configuração do Projeto

### Requisitos

- PHP 8.0 ou superior
- Composer
- MySQL (ou outro banco de dados suportado)

### Instalação

1. Clone o repositório:

    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    cd seu-repositorio
    ```

2. Instale as dependências:

    ```bash
    composer install
    ```

3. Configure o arquivo `.env`:

    Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário.

    ```bash
    cp .env.example .env
    ```

4. Gere a chave de aplicativo:

    ```bash
    php artisan key:generate
    ```

5. Execute as migrações e seeders (se necessário):

    ```bash
    php artisan migrate --seed
    ```

6. Inicie o servidor local:

    ```bash
    php artisan serve
    ```

A API estará disponível em `http://localhost:8000`.

## Rotas da API

Aqui estão as principais rotas da API:

### Produtos

- **Listar produtos**
  - `GET /api/products`
  - Retorna uma lista de produtos com paginação.
  - Query parameters:
    - `search` (opcional): filtro por nome ou descrição.

- **Exibir produto**
  - `GET /api/products/{id}`
  - Retorna detalhes de um produto específico.

- **Criar produto**
  - `POST /api/products`
  - Cria um novo produto. Requer um JSON com os seguintes campos:
    - `name`: Nome do produto (máx. 50 caracteres)
    - `description`: Descrição do produto (máx. 200 caracteres)
    - `price`: Preço do produto (valor positivo)
    - `expiration_date`: Data de validade (não anterior à data atual)
    - `image`: Imagem do produto (opcional)
    - `category_id`: ID da categoria associada

- **Atualizar produto**
  - `PUT /api/products/{id}`
  - Atualiza um produto existente. Aceita os mesmos campos que a criação.

- **Deletar produto**
  - `DELETE /api/products/{id}`
  - Remove um produto.

## Documentação da API

A documentação da API é gerada automaticamente usando [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) ou [Laravel OpenAPI](https://github.com/DarkaOnLine/L5-Swagger).

### Configuração do Swagger

1. Instale o pacote L5-Swagger:

    ```bash
    composer require "darkaonline/l5-swagger"
    ```

2. Publique o arquivo de configuração:

    ```bash
    php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
    ```

3. Configure o Swagger:

    Edite o arquivo de configuração em `config/l5-swagger.php` para definir as configurações de documentação da API.

4. Gere a documentação:

    ```bash
    php artisan l5-swagger:generate
    ```

5. Acesse a documentação:

    A documentação gerada estará disponível em `http://localhost:8000/api/documentation`.

## Contribuição

Sinta-se à vontade para contribuir para este projeto enviando pull requests ou relatando problemas.

