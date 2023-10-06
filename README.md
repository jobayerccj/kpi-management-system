Docker
===========

### Docker

How to build, start and stop, connect to container etc:

```
make help
```

./docker/db/mounted_db is a mounted in dc.db:/var/www/db, so if you want upload sql.sql in your DB:

```
make exec dc=db
cd /var/www/db
mysql -u root -p Database < sql.sql

docker network inspect kpinetwork
```

### Queued Message Handling

We should stop already running messenger handler before deploying new code.
```
ps aux | grep 'messenger:consume' | grep -v 'grep'
sudo kill -9 processIdOfMessengerInstance #(or change with id)
php bin/console messenger:consume async
```
Then system will initiate a new instance using the updated code.

### Unit Test

```
php bin/console doctrine:fixtures:load --env=test
php bin/phpunit
```