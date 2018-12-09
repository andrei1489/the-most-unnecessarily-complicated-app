# the-most-unnecessarily-complicated-app
An absurd app, that is unnecessarily complicated, in order to show off docker compose

![alt text](the-most-complicated-app.png "Logo Title Text 1")

## Objective
Have an interface where you can see messages and post them

## Components

### PHP service
- serves js files and has getMessages and addMessage endpoint
- stores the new message in the db
- serves messages from the db
- pushes to a rabbitmq server the new message
- Symfony 4 + Angular 7

### Java service
- reads from a queue, gets new message
- publishes to a redis topic
- Spring Boot

### Nodejs service
- subscribes to a topic
- on receiving a message, pushes it to the websocket clients
- nodejs 11

### Other services
- RabbitMQ server (latest)
- Redis server (latest)
- MySQL server (latest)
- PHPMyAdmin (latest)

### Commands to run
On web, you need to:
 - run migrations 
 - run composer 
 - run npm install in fronted/
 - ng build the code in frontend/

On node, you need to run a container to do `npm install` for you before starting the actual container, so the app can get the dependencies.
