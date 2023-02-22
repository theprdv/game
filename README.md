## How to run locally

1. Install composer dependencies, open a terminal and run:
   ```
   docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php82-composer:latest \
   composer install --ignore-platform-reqs
   ```
2. Build and run your app with Docker Compose `docker compose up`
3. Connect to your container shell with `./vendor/bin/sail shell`
4. Copy the env file `composer run-script post-root-package-install`
5. Run all the DB migrations `php artisan migrate`
6. Open Postman or another API client and make the requests at `http://localhost`
7. Open the API Doc from https://binary-gateway.stoplight.io/docs/game/9p1r2sm6tm65k-game, you can also use the `api-doc.yaml` file
8. Enjoy
