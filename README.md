# desafioBackendlientechirede

# 
O desafio consiste na implementação de um sistema back-end e integração
com o banco de dados que gerencia produtos, desta forma, deve ser entregue
um CRUD de produtos, utilizando os cinco endpoints no padrão REST. No
back-end deve ser utilizado PHP com Laravel, ou linguagem de sua
preferência o, e banco de dados MySQL 8.0.
O sistema deve ser acessado com autenticação por token (JWT, Oauth2,
Laravel Sanctum, etc).

# 1 Deve-se implementar o modelo entidade-relacionamento a seguir:
 Entidade produto:
i. Nome (Máximo de 50 caracteres)
ii. Descrição (Máximo de 200 caracteres)
iii. Preço (Valor positivo, double)
iv. Data de validade (Não pode ser anterior à data atual)
v. Imagem (upload de imagem, nome único do arquivo)
vi. Categoria relacionada
 Entidade categoria:
i. Nome: (máximo de 100 caracteres)
O projeto também deve fazer:
 Listar todos os produtos cadastrados.
 Deve ser possível editar e excluir um produto.
 Implementar paginação na listagem de produtos.
 Implementar busca por nome e descrição. 

# 2 Outros detalhes técnicos:
a. O back-end apenas fornece endpoints com retorno em JSON.

# 3 Documentação: 
a. Como configurar e executar o projeto.
b. Qualquer biblioteca ou ferramenta de terceiros utilizada e por quê. 

# 4 Diferenciais Adicionais:
a. Uso de Docker para executar o projeto apenas com o comando “dockercomposer up -d”
b. Implementação de um sistema ACL ( Acess Control List ) no back- end. 

