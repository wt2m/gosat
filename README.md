# Gosat Development Test

## Getting Started

### Para executar o teste, é necessário clonar o repositorio, e, com o composer e php instalados, executar os comandos:

```
composer install

php artisan key:generate
```

### Em seguida, é necessario criar o .env embasado no .env-example e preencher os dados para conexão com o MySQL.
Dentro do mysql:
> create database gosat

### Com a database e schema criados, migre o banco e inicie o servidor
```
php artisan migrate

php artisan serve
```


### Importar as rotas no postman com a url:
> https://www.getpostman.com/collections/29c4ee7dec57876abba8

As requisições da API estão dentro da pasta "MyAPI" do postman. Caso a consulta seja feita sem filtros, os dados serão baseados no máximo de parcelas e valor máximo.