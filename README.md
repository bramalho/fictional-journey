# Fictional Journey

## Admin

```bash
docker-compose up -d

docker-compose exec -u www-data admin_php sh

composer install

./bin/console doctrine:schema:update --force

./bin/console doctrine:fixtures:load

./bin/console app:sync:entities-documents
```

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
