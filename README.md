# Sistema de Pagamento com Integração de API

###### Aviso Importante
Eu não tinha saldo no PayPal para testar essa parte da aplicação, portanto é possivel ececutar através do admin e da manipulação do Banco de Dados pelo Workbench. Fiz código para envio de e-mail automático, mas os dados do meu e-mail estavam como remetente então foi necessário tirar.

Ao criar o banco de dados no workbench, escolha a porta de execução do MySQL e altere no config.php se a porta for diferente.

Execute o APACHE e o MySQL (utilizei o MAMP ou o XAMPP). Configure a porta para o mesmo número.

Versão do PHP: 8.0.1 (aparece no MAMP)

É necessário ter o PayPal REST API SDK baixado

## Descrição
Um sistema de pagamento que permite aos usuários realizarem transações financeiras, como compra de produtos ou serviços, utilizando uma API de pagamento (PayPal)

## Recursos e Funcionalidades

### Autenticação de Usuários
Os usuários podem se cadastrar e fazer login em suas contas.

### Gestão de Carteira Virtual
Os usuários devem ter uma carteira virtual onde possam fazer transações ou visualizar seu saldo atual.

### Integração com API de Pagamento
Possui integração com Paypal para permitir transações financeiras.


### Histórico de Transações
Há salvo um registro de todas as transações realizadas, incluindo detalhes como valor, data, tipo de transação, etc.

### Painel de Administração
No painel de administração é possível gerenciar usuários e revisar transações.

### Segurança
Há autenticação segura, proteção contra injeções de SQL, criptografia e proteção outros ataques comuns.

## Tecnologias e SDKs Utilizados
Utilização de PHP no backend (utilizei o MAMP para APACHE e PHP, além do composer).

Utilização de HTML e CSS no frontend.

Utilização de PayPal SDK para a API de pagamento.

Utilização de MySQL para o banco de dados (utilizei o MySQL Workbench com a porta 3306)..

#### NOTA: no codigo, cada usuário cadastrado é registrado com 1000 reais na conta para teste, é possível integrar no código uma alteração para isso.

## Benefícios do Projeto:
Demonstração de habilidades de integração de API.

Demonstração de segurança em transações financeiras.

Demonstração de segurança com o usuário ao fazer criptografia para salvar no banco de dados.

Boa prática em gerenciamento de contas de usuário e registros de transações.

Experiência com tecnologias populares de pagamento online.