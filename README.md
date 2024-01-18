## Painel de Agendamento

Painel de agendamento criado com Laravel e FilamentPHP.

O projeto está sendo criado para estudo, é um projeto em andamento e não está completo.

Tambem possui uma imagem docker customizada.


## Recursos Atuais

- Criação e gerenciamento de Clientes

## Urls

Aplicação: [http//localhost:8000]()

Adminer: [http//localhost:8080]()

## Uso

Rodar containers dockers.

```bash
$ docker compose up -d
```

### Primeira execução

Na primeira execução o container irá checar se existe um arquivo .env, caso não exista, irá criar o arquivo .env e 
instalar as dependencias do composer caso não seja localizado a pasta vendor, por isso o servidor web 
pode demorar para responder na porta 8000.

### Migrations

Dentro do container, execute as migrations com os seeders para gerar o banco de dados

```bash
$ php artisan migrate --seed
```
