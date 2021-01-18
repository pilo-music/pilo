## Milo Server Backed

Develop by mobinyazdanparast9@gmail.com

## Usage

To get started, make sure you have [Docker installed](https://docs.docker.com/desktop/) on your system, and then clone this repository.

Next, navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose up -d`.

Bringing up the Docker Compose network with `laravel` instead of just using `up`, ensures that only our site's containers are brought up at the start, instead of all of the command containers as well. The following are built for our web server, with their exposed ports detailed:

- **nginx** - `:8080`
- **mysql** - `:3306`
- **php** - `:9000`

Three additional containers are included that handle Composer, NPM, and Artisan commands *without* having to have these platforms installed on your local computer. Use the following command examples from your project root, modifying them to fit your particular use case.

- `docker-compose run --rm composer update`
- `docker-compose run --rm npm run dev`
- `docker-compose run --rm artisan migrate --seed` 
