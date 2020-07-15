# Getting Started

1. Clone this repo && cd into it
1. Run `cp .env.example .env`
1. Run `docker-compose up -d`
1. Run `docker exec -it assignment-project npm run watch` to build/watch with webpack
1. Visit [http://localhost:8085](http://localhost:8085) to see the page.
1. Connect to the MySQL db with these creds: 

```
host:       127.0.0.1
port:       3308
db:         assignment
username:   assignment
password:   secret
```

# Interacting with the Docker Container

The application is now running _within_ the docker container. There's a mysql container and an application container. These are basically computers within your computer.

To "get in" to the application container in order to run commands, you'll need to run this:

```bash
# - execute in an interactive terminal (-it)
# - on the assignment-project container
# - the bash command (to open a prompt)
docker exec -it assignment-project bash

# Now you can run whatever you like from within the container:
php artisan tinker
```
