## TODO

Clone the repo


```
git clone https://github.com/berna39/symfony-app.git
```
Build the Docker image
```
docker-compose up -d
```
Connected to the app's docker container bash
```
docker exec -it <container_id> bash
```
Go to the app directory
```
cd app
```

Create database
```
php bin/console doctrine:database:create
```
Execute migrations
```
php bin/console doctrine:migration:migrate
```

App the app is available on localhost:8741 now, credentials are : admin -> [username : admin, password : root], 
moderator -> [username : moderator, password : moderator]

Start partsing(downloading) articles
```
php bin/console news:parse
```
Start consuming messages with rabbitMQ
```
php bin/console messenger:consume
```
