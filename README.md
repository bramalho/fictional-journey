# Fictional Journey

```bash
docker-compose up -d
```

## Admin

```bash
docker-compose exec -u www-data admin_php sh

composer install

./bin/console doctrine:schema:update --force

./bin/console doctrine:fixtures:load

./bin/console app:sync:entities-documents
```

Go to [localhost](http://localhost)

## API

```bash
docker-compose exec -u www-data api_php sh

composer install
```

Go to [localhost:88/graphiql](http://localhost:88/graphiql)

## MongoDB

```bash
docker-compose exec mongodb sh

mongo
show dbs
use app
show collections
db.Category.find()
db.Product.find()
```
