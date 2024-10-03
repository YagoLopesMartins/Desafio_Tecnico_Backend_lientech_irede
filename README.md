# API de Produtos

Esta é uma API desenvolvida em Laravel para gerenciar produtos e categorias.
- O desafio consiste na implementação de um sistema back-end e integração 
com o banco de dados que gerencia produtos, desta forma, deve ser entregue 
um CRUD de produtos, utilizando os cinco endpoints no padrão REST. No 
back-end deve ser utilizado PHP com Laravel, ou linguagem de sua 
preferência o, e banco de dados MySQL 8.0. 
- O sistema deve ser acessado com autenticação por token (JWT, Oauth2, Laravel Sanctum, etc).
- Deve-se implementar o modelo entidade-relacionamento a seguir: 
  - Entidade produto: 
    - i.Nome (Máximo de 50 caracteres) 
    - ii. Descrição (Máximo de 200 caracteres) 
    - iii. Preço (Valor positivo, double) 
    - iv. Data de validade (Não pode ser anterior à data atual) 
    - v. Imagem (upload de imagem, nome único do arquivo) 
    - vi. Categoria relacionada 
  - Entidade categoria: 
    - i. Nome: (máximo de 100 caracteres) 
- O projeto também deve fazer: 
   -  Listar todos os produtos cadastrados. 
   -  Deve ser possível editar e excluir um produto. 
   - Implementar paginação na listagem de produtos. 
   - Implementar busca por nome e descrição.
- Outros detalhes técnicos: 
   - a. O back-end apenas fornece endpoints com retorno em JSON.
- Documentação: 
   - a. Como configurar e executar o projeto. 
   - b. Qualquer biblioteca ou ferramenta de terceiros utilizada e por quê. 
- Diferenciais Adicionais: 
   - a. Uso de Docker para executar o projeto apenas com o comando “docker-composer up -d” 
   - b. Implementação de um sistema ACL ( Acess Control List ) no back- end. 

## Configuração do Projeto

### Requisitos

- Docker
- PHP 8.0 ou superior
- Composer 2.8.0
- MySQL 8.0
- Insomnia ou outro API Client for REST (Ex.: Postman, Thunder Client etc)

### Instalação

1. Clone o repositório:

    ```bash
    $ git clone https://github.com/YagoLopesMartins/desafioBackendlientechirede.git
    cd desafioBackendlientechirede
    ```

2. Instale as dependências:
   
   2.1 COM **DOCKER**
     ```bash
        $ docker-compose up -d --build //(iniciará serviço com php e phpmyadmin, mysql e laravel
     ```
     - **Obs**: Verificar no docker se o container desafiobackendlientechirede foi iniciado, se não fora, inicialize manualmente

     - **Obs1**: Se erro de mysql então procure por painel de controle de Serviços do Windows (pressionando Win + R
       e digite services.msc e depois ENTER), localize o serviço do MySQL, que esta em Execução e interrompa-o (pare)
   
     - **Obs2**: Entrar na url http://localhost:9001/ para acessar banco de dados do container o qual terá o banco laravel_docker já criado
       - Credenciais:
         - Servidor: mysql_db
         - Usuario: root
         - Senha: root
        - Acesse: http://localhost:9000/api/categorias

   2.2 SE **LOCAL**
   - 2.2.1 Entre no diretorio laravel-app e execute:
   
        ```bash
        $ composer install
        ```
   
     2.2.2 Configure o arquivo `.env`:
   
     - Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário.

        ```bash
         $ cp .env.example .env
        ```

      2.2.3 Gere a chave de aplicativo:

        ```bash
         $ php artisan key:generate
        ```

      2.2.4 Execute as migrações e seeders (se necessário):

        ```bash
          $ php artisan migrate --seed
        ```

      2.2.5 Inicie o servidor local:

        ```bash
           $ php artisan serve
        ```

     - Acesse: `http://localhost:8000`.

## Rotas da API

 - Aqui estão as principais rotas da API:
 - Rota base (BaseURL): http://localhost:9000/
 - No insomnia importe os arquivos do diretorio **insomnia** (na raiz do projeto) e insira a rota base

### Auth

- **Register**
    - **Endpoint**: `POST /api/register`
    - **Descrição**:
      - Cria um novo usuário. Requer um JSON com os seguintes campos:
          - `name`: Nome do usuário (tipo String)
          - `email`: E-mail deve ser válido
          - `password`: Senha (min. 6 caracteres)
    - **Headers**: Content-Type: application/json
    - **Body**:
       ```
        {
          "name": "John Doe",
          "email": "johndoe@example.com",
          "password": "yourpassword",
        }
       ```
    - **Respostas**:
      - 200 OK
       ```
        {
           "message": "User registered successfully",
           "user": {
              "id": 1,
              "name": "John Doe",
              "email": "johndoe@example.com"
           },
           "token": "your_jwt_token"
        }
       ```
    -  Será gerado um token como o exemplo abaixo (Se tudo ocorrer bem)
        ```bash
        {
            "token": "1|rZCc2cpH94fT5mDm1yoG8gcD6cvqqYLpDur5qZhS0995578b"
        }
       ```
       
- **Login**
  - **Endpoint**: `POST /api/login`
  - Valida um usuário. Requer um JSON com os seguintes campos:
    - `email`: E-mail deve ser válido
    - `password`: Senha (min. 6 caracteres)
  - **Headers**: 
    - Content-Type: application/json
    - Authorization: Bearer {token}
  - Depois Efetuar o login passando o token anterior gerado ao registrar será gerado outro token exemplo abaixo
    ```bash
    {
      "token": "3|bqQyd54ULpg3eFvH7xAf2jVqdvqT4BgU6ORmHalTcd6ab703"
    }
      ```
  - **Respostas**:
    - 200 OK
    - 401 **Unauthorized** Token ausente ou inválido.
  - Pronto, agora pode testar os endpoints principais repassando o token gerado

### Produtos

- **Listar produtos**
  - **Endpoint**: 
    - `GET /api/produtos`
    - `GET /api/produtos?search=yourSearch`
    - `GET /api/produtos?page=2`
    - `GET /api/produtos?search=yourSearch&page=2`
  - Retorna uma lista de produtos com paginação. Obs: 10 por página
  - Query parameters:
    - `search` (opcional): filtro por nome ou descrição.
    - `page` (opcional): Número da página

- **Exibir produto**
  - **Endpoint**: `GET /api/produtos/{id}`
  - Retorna detalhes de um produto específico.

- **Criar produto**
  - **Endpoint**: `POST /api/produtos`
  - Cria um novo produto. Requer um JSON com os seguintes campos:
    - `nome`: Nome do produto (máx. 50 caracteres)
    - `descricao`: Descrição do produto (máx. 200 caracteres)
    - `preco`: Preço do produto (valor positivo)
    - `data_validade`: Data de validade (não anterior à data atual)
    - `imagem`: Imagem do produto (opcional)
    - `categoria_id`: ID da categoria associada

- **Atualizar produto**
  - **Endpoint**: `PUT /api/produtos/{id}`
  - Atualiza um produto existente. Aceita os mesmos campos que a criação.

- **Deletar produto**
  - **Endpoint**: `DELETE /api/produtos/{id}`
  - Remove um produto.

## Contribuição

 - Sinta-se à vontade para contribuir para este projeto enviando pull requests ou relatando problemas para o e-mail: **ylm@icomp.ufam.edu.br**.

