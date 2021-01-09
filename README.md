# DOCKERIZED PHP [FAT-FREE](https://fatfreeframework.com) APP

## Summary
1. [What is it?](#wii)
2. [Getting started](#gs)
3. [How is it working](#hiiw)

---

## <a name="wii">What is it ?</a>
because I tried for some days a docker config for php [fatfree](https://fatfreeframework.com) micro-framework
I'm sharing a basic working fatfree app.
I hope it could help you.
---
## <a name="gs">Getting started</a>
- step One, clone the project
```bash
git clone https://github.com/bolex222/dockerized-fatfree.git
```
- step two,  go in infra directory
```bash
cd dockerized-fatfree/infra
```
- step three,  run docker compose
```bash
docker-compose up
```
- step four,  try these routes on your browsers
  - [localhost:8080/](http://localhost:8080/)
  - [localhost:8080/hello/@name](http://localhost:8080/hello/yourName)
  - [localhost:8080/reroute](http://localhost:8080/reroute)
- step five, you can remote repos to your own repos :)

## <a name="hiiw">How is it working</a>
### <a name="ps">The project structure</a>
```
your-project/
├──infra/
│   ├──web/
│   │   └── Dockerfile
│   └── docker-compose.yml
└──app/
    ├── .htaccess
    ├── composer.json
    ├── index.php
    └── src/
```

There is two principal folder, ```infra/``` which contain project's infrastructure and ```app/``` is your fatfree app.

### ``infra/`` folder 

---

- **The ```web/``` folder**

```web/``` folder contain the ``Dockerfile`` for ``php - apache`` : 
```Dockerfile
# define origine image form dockerHub
FROM php:7.4-apache
# enabled rewrite apache module which is required by fatfree
RUN a2enmod rewrite
```
apache rewrite module is required by fatfree, (see [fatfree User Guide](https://fatfreeframework.com/3.7/routing-engine#SampleApacheConfiguration))

this Dockerfile is in a specific folder because it permit to call it from the ```docker-compose.yml``` as build command

---
- **The ``docker-compose.yml``**

```yml
# docker-compose version 
version: '3'

# services
services:
  #the web service php-apache
  web:
    # the build using the the web/Dockerfile
    build: ./web/
    # linking container port 80 on host on 8080
    ports:
      - "8080:80"
    #linking your app with docker container
    volumes:
      - ../app:/var/www/html
    # composer which is gonna run composer install
  composer:
    image: composer
    volumes:
      - ../app:/app
    command: ['composer', 'install']

```
config is particularly easy, there are 2 services :
- web service is php apache from ```Dockerfile```
- composer service is just here to install dependencies.


### ``app/`` Folder

---

- **The ``.htaccess`` file** is an apache configuration file for project (see [apache2 htaccess documentation](https://httpd.apache.org/docs/current/howto/htaccess.html))

```apacheconf
RewriteEngine On

RewriteRule ^(app|dict|ns|tmp)\/|\.ini$ - [R=404]

RewriteCond %{REQUEST_FILENAME} !-l
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .* index.php [L,QSA]
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]
```
This file is needed by fatfree routing at your app root folder, here ``dockerized-fatfree/app/.htaccess`` (see [fatfree User Guide](https://fatfreeframework.com/3.7/routing-engine#SampleApacheConfiguration))

---
- **The ``composer.json`` file** is the composer project config file

```json
{
    "name": "bolex222/dockerize-fat-free",
    "require": {
        "bcosca/fatfree": "^3.7"
    }
}
```
This file is the minimum required composer configuration.

You can change project name as you want 

OR 

delete ``composer.json`` and running the following command if you have composer installed :
```bash
composer init
```
if you won't install composer you can run the docker equivalent command : 
```
docker run -v ${PWD}:/app -it --rm composer init
```
and follow composer instructions

---
- **The ``index.php`` file** is the fatfree project entry point.

---

# Have fun :)