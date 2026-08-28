# 100Criptografia

## Visão geral

O **100Criptografia** é uma plataforma web para conversão de dados, cifragem clássica e exploração de enigmas.

O sistema funciona por meio de um pipeline visual interativo, no qual blocos de operações podem ser conectados em sequência para transformar e analisar dados.

A plataforma oferece dois modos de uso:

- **Visitante:** permite testar as funcionalidades sem criar uma conta, por meio da opção "Testar sem uma conta".
- **Usuário autenticado:** permite gerenciar o perfil, consultar o histórico e salvar configurações como presets.

## Tecnologias

- Docker
- Docker Compose
- PHP 8.2
- HTML
- CSS
- JavaScript
- MySQL

## Pré-requisitos

Antes de iniciar o projeto, instale:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Configuração

Crie um arquivo `.env` na raiz do projeto com as configurações do MySQL:

```env
MYSQL_HOST=db
MYSQL_ROOT_PASSWORD=senha_root
MYSQL_DATABASE=100criptografia
MYSQL_USER=usuario
MYSQL_PASSWORD=senha_usuario
```

Substitua os valores de exemplo pelas credenciais desejadas. O arquivo `.env` não deve ser versionado, pois contém informações de configuração e credenciais.

## Instalação e execução

Com o Docker instalado e o arquivo `.env` configurado, execute na raiz do projeto:

```bash
docker compose up -d --build
```

Esse comando constrói a imagem do servidor PHP, inicia o banco de dados MySQL e inicia o servidor web.

Depois, acesse a aplicação em:

```text
http://localhost:8080
```

### Avisos importantes

- As portas `8080` e `3306` precisam estar livres. Se alguma delas estiver sendo utilizada por outro programa, altere o mapeamento correspondente no `docker-compose.yml`.
- Na primeira execução, o MySQL pode levar alguns segundos para concluir a inicialização. Caso a aplicação apresente um erro de conexão nesse momento, aguarde e tente novamente.
- O banco de dados utiliza o volume Docker `db_data`, que mantém os dados mesmo depois de executar `docker compose down`. Os dados serão apagados somente se o volume também for removido.
- Os scripts da pasta `sql/` não são executados automaticamente pelo `docker-compose.yml`. Se a aplicação depender de tabelas ou dados iniciais, execute o script SQL conforme as instruções do próprio arquivo.
- O projeto usa PHP 8.2 dentro do container. Não é necessário instalar PHP diretamente na máquina host.

### Portabilidade

O projeto pode ser executado em Linux, Windows ou macOS, desde que o Docker esteja instalado e em execução.

- No Windows, recomenda-se utilizar o Docker Desktop com WSL 2.
- No macOS, utilize o Docker Desktop. Ele oferece suporte a Macs Intel e Apple Silicon para as imagens utilizadas pelo projeto.
- No Linux, o usuário pode precisar de permissão para executar comandos Docker sem `sudo`.

O arquivo `.env` está listado no `.gitignore` e não é enviado ao repositório. Portanto, ele deve ser criado manualmente em cada máquina antes de executar o projeto.

## Comandos úteis

Ver o estado dos serviços:

```bash
docker compose ps
```

Ver os logs dos serviços:

```bash
docker compose logs -f
```

Parar os serviços:

```bash
docker compose down
```

## Estrutura básica

```text
100Criptografia/
├── actions/                # Processamento dos formulários
├── assets/                 # Arquivos CSS, JavaScript e imagens
├── config/                 # Configurações, incluindo a conexão com o banco
├── includes/               # Componentes PHP reutilizáveis
├── sql/                    # Scripts de criação e configuração do banco
├── index.php               # Página inicial
├── register.php            # Página de cadastro
├── login.php               # Página de login
├── send-email.php          # Página de envio de e-mail
├── recover-password.php    # Página de recuperação de senha
├── project.php             # Área principal do projeto
├── config.php              # Configurações do usuário
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## Objetivo acadêmico

O projeto foi desenvolvido para uma apresentação de curso e para a realização de atividades relacionadas à qualidade de software, como testes, identificação de falhas, validação de requisitos e avaliação da organização do sistema.
****
