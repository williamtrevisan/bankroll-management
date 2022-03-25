## Rodar o projeto

Clone Repositório
```sh
git clone git@github.com:williamtrevisan/bankroll-management.git bankroll_management
```

```sh
cd bankroll_management/
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME="Bankroll Management"
APP_URL=http://localhost:8000

DB_CONNECTION=postgres
DB_HOST=db
DB_PORT=5432
DB_DATABASE=bankroll_management
DB_USERNAME=root
DB_PASSWORD=root
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container app
```sh
docker-compose exec app bash
```

Instalar as dependências do projeto
```sh
composer install
```

Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)
