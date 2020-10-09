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

Queries

```gql
query {
    category_list(limit: 5) {
        categories {
            uid
            name
        }
    }
}

query {
    category(uid: "9531b37d-86a9-452e-8760-4957007b770b") {
        uid
        name
        products (first: 10){
            edges {
                cursor
                node {
                    uid
                    name
                    price
                }
            }
        }
    }
}

query {
    product_list(limit: 5) {
        products {
            uid
            name
            price
            category {
                uid
                name
            }
        }
    }
}

query {
    product(uid: "605b9f08-7345-4ebc-96d1-b37b228f83ab") {
        uid
        name
        price
        category {
            uid
            name
        }
    }
}
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
