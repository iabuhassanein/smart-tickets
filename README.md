## Smart Tickets Triage & Dashboard

### Setup (using your prepared environment)
```bash
# clone the github project repo
$ git clone git@github.com:iabuhassanein/smart-tickets.git

# create `.env` file
$ cp .env.example .env

# install vendors
$ composer install

# run migration
$ php artisan migrate

# Optional: run seeders if you want to add 30 dummy tickets.
$ php artisan db:seed

# build the frontend and launch server or run dev server
$ npm run build
$ npm run start
# or
$ npm run dev

# run the Queue work command to make the app execute the queued jobs 
$ php artisan queue:work
# note you can change the QUEUE_CONNECTION=sync in .env file,
# so it's will run without added to queue "this just for testing"
```

### Setup (using docker environment)
```bash
# clone the github project repo
$ git clone git@github.com:iabuhassanein/smart-tickets.git

# create `.env` file
$ cp .env.example .env

# run docker-compose
$ docker compose up -d --build

# run `exec` script on `smart-tickets-app` container to let you run command 
# from inside docker container, to do this run next command,
# but please note that container name must be in schema "{folder name}-app-1"
# then all commands after this will be run on app container behaviour
$ docker exec -it smart-tickets-app-1 /bin/bash 

# then install vendors on app container behaviour
$ composer install

# then run migration
$ php artisan migrate

# Optional: run seeders if you want to add 30 dummy tickets.
$ php artisan db:seed

# run the Queue work command to make the app execute the queued jobs 
$ php artisan queue:work

# note you can change the QUEUE_CONNECTION=sync in .env file,
# so it's will run without added to queue "this just for testing"
```
### Assumptions & Trade-offs
- I assume the status has three options [new, in progress, done] 
- I assume the categories are status and add them statically info an Enum PHP Class
- Tha app builds without an auth system, because I assumed it's not required based on a requirement file.
- I assume UI and style is not the main part of the test, so I kept it simple.
- I trade off the state management tools "like pinia or vuex" with js file.
  - the "ServerActions" folder contains only actions that are called the api endpoints. 
  - you will not find usage of states or storing data local to be shared between components. 
- In the classification process you asked to make it a Queued job, and you need to show loader until it’s finished, so because it’s queued the response will asynchronized, so we need a realtime event that'd inform the frontend page that’s queued job was finished, because there is no time to implement a realtime events/web socket, I trade it with polling technique.
- What I’d do with more time:
  - enhanced the style and the UI of the app.
  - make the frontend responsive.
  - implement the web socket events or server events for the asynchronized job.
