# movie-night-stats
 Website Code for Movie Night Stats.com

Repo contains HTML & PHP pages.
And SQL to create most of the databases.

Also unsure about including dependencies, currently contains bootstrap5 and DataTables are also included since they are integral to the site. Along with fireworks javascript.

## TODO
- Find/Create a wheel to include for /spin/

## Installation Instructions
### Dockerfile
```dockerfile
FROM php:8.3.2-apache-bullseye
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN a2enmod rewrite
RUN apt-get update && apt-get upgrade -y
```

### Docker Compose
```yaml
services:
  web:
    container_name: movie-night-stats-web
    build: 
      context: .
      dockerfile: Dockerfile
    depends_on:
      - db
    restart: always
    volumes: 
      - 'ENTER_A_LOCAL_FOLDER_HERE:/var/www/html/'
    ports:
      - 'ENTER_A_PORT_HERE:80'
    networks:
      - movie-night-stats-net
  db:
    container_name: movie-night-stats-db
    image: 'mariadb:11.2.2-jammy'
    restart: always
    environment: 
      - MARIADB_ROOT_PASSWORD=ENTER_A_PASSWORD_HERE
    volumes:
      - 'ENTER_A_LOCAL_FOLDER_HERE:/var/lib/mysql'
    ports:
      - 'ENTER_A_PORT_HERE:3306'
    networks:
      - movie-night-stats-net
  phpmyadmin:
    container_name: movie-night-stats-db-web
    image: phpmyadmin:5.2.1-apache
    ports:
      - 'ENTER_A_PORT_HERE:80'
    restart: always
    environment:
      PMA_HOST: movie-night-stats-db
    depends_on:
      - db
    networks:
      - movie-night-stats-net
networks:
  movie-night-stats-net: {}

```
