# Fictional Journey

- [Docker Compose](#docker-compose)
- [Admin](#admin)
- [API](#api)
- [MongoDB](#mongodb)
- [Build Images](#build-images)
- [Kubernetes](#kubernetes)

## Docker Compose

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

## Build Images

```bash
docker login
```

Base PHP Image

```bash
docker build . \
    -t bramalho/fictional-journey-php-base \
    -f docker/php-base/Dockerfile

docker push bramalho/fictional-journey-php-base
```

Admin Images

```bash
docker build . \
    -t bramalho/fictional-journey-php-admin \
    -f docker/php-admin/Dockerfile \
    --build-arg BASE_IMAGE=bramalho/fictional-journey-php-base

docker push bramalho/fictional-journey-php-admin

docker build . \
    -t bramalho/fictional-journey-nginx-admin \
    -f docker/nginx-admin/Dockerfile \
    --build-arg PUBLIC_IMAGE=bramalho/fictional-journey-php-admin

docker push bramalho/fictional-journey-nginx-admin
```

API Images

```bash
docker build . \
    -t bramalho/fictional-journey-php-api \
    -f docker/php-api/Dockerfile \
    --build-arg BASE_IMAGE=bramalho/fictional-journey-php-base

docker push bramalho/fictional-journey-php-api

docker build . \
    -t bramalho/fictional-journey-nginx-api \
    -f docker/nginx-api/Dockerfile \
    --build-arg PUBLIC_IMAGE=bramalho/fictional-journey-php-api

docker push bramalho/fictional-journey-nginx-api
```

## Kubernetes

```bash
minikube start --vm=true --driver=hyperkit

minikube addons enable ingress

minikube ip

sudo vim /etc/hosts
# YOUR_MINIKUBE_IP admin.fictional-journey.com api.fictional-journey.com
```

```bash
helmsman -apply -f helm/helm.yaml -debug -verbose

minikube dashboard
```
