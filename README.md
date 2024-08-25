# API de Produtos

Esta é uma API desenvolvida em Laravel para gerenciar produtos e categorias.

## Configuração do Projeto

### Requisitos

- Docker
- PHP 8.0 ou superior
- Composer
- MySQL
- Insomnia ou outro API Client for REST (Ex.: Postman etc)

### Instalação

1. Clone o repositório:

    ```bash
    git clone https://github.com/YagoLopesMartins/desafioBackendlientechirede.git
    cd desafioBackendlientechirede
    ```

2. Instale as dependências:
   
   2.1 COM DOCKER
   ```bash
   - docker-compose up -d
     ```
   (iniciará serviço com php e phpmyadmin, mysql e laravel
     - Obs: Verificar no docker se o container desafiobackendlientechirede foi iniciado, se não fora, inicialize manualmente
     - Obs1: Se erro de mysql então procure por painel de controle de Serviços do Windows (pressionando Win + R
       e digite services.msc e depois ENTER), localize o serviço do MySQL, que esta em Execução e interrompa-o (pare)
     - Obs2: Entrar na url http://localhost:9001/ para acessar banco de dados do container o qual terá o banco laravel_docker já criado
       - Credenciais:
         - Servidor: mysql_db
         - Usuario: root
         - Senha: root
   - docker-compose build
   - docker exec laravel-docker bash -c "composer update"
   - docker exec laravel-docker bash -c "php artisan key:generate"
   - docker exec laravel-docker bash -c "php artisan migrate"
   - docker exec laravel-docker bash -c "php artisan db:seed"
   - Acesse: http://localhost:9000/
   - Acesse: http://localhost:9000/api/produtos
   - No insomnia importe os arquivos do diretorio insomnia na raiz do projeto e altere a uri para http://localhost:9000/

   2.2 SE LOCAL
   - Entre no diretorio laravel-app
   
   ```bash
    composer install
    ```
   
  2.2.1 Configure o arquivo `.env`:

    Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário.

    ```bash
    cp .env.example .env
    ```

   2.2.2 Gere a chave de aplicativo:

    ```bash
    php artisan key:generate
    ```

   2.2.3 Execute as migrações e seeders (se necessário):

    ```bash
    php artisan migrate --seed
    ```

   2.2.4 Inicie o servidor local:

    ```bash
    php artisan serve
    ```

A API estará disponível em `http://localhost:8000`.

## Rotas da API

Aqui estão as principais rotas da API:

### Produtos

- **Listar produtos**
  - `GET /api/produtos`
  - Retorna uma lista de produtos com paginação. Obs: 10 por página
  - Query parameters:
    - `search` (opcional): filtro por nome ou descrição.

- **Exibir produto**
  - `GET /api/produtos/{id}`
  - Retorna detalhes de um produto específico.

- **Criar produto**
  - `POST /api/produtos`
  - Cria um novo produto. Requer um JSON com os seguintes campos:
    - `nome`: Nome do produto (máx. 50 caracteres)
    - `descricao`: Descrição do produto (máx. 200 caracteres)
    - `preco`: Preço do produto (valor positivo)
    - `data_validade`: Data de validade (não anterior à data atual)
    - `imagem`: Imagem do produto (opcional)
    - `categoria_id`: ID da categoria associada

- **Atualizar produto**
  - `PUT /api/produtos/{id}`
  - Atualiza um produto existente. Aceita os mesmos campos que a criação.

- **Deletar produto**
  - `DELETE /api/produtos/{id}`
  - Remove um produto.

## Contribuição

Sinta-se à vontade para contribuir para este projeto enviando pull requests ou relatando problemas.

