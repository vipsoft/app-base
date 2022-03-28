# Robocoder App

This is a starter project for new roles.

## Project Layout

```
README.md          - the file you're now reading
composer.json      - declaration of vendor package dependencies and auto-loader configuration
public/            - public files (visible at web document root)
    js/            - JavaScript files
    index.php      - dispatcher
src/               - application
    Controller/    - controllers
    Service/       - services
templates/         - views (e.g., .twig, .php)
vendor/            - installed vendor packages
---
docker/
    app/Dockerfile - define Docker container to run the application (for testing)
    assets/        - assets (if needed)
docker-compose.yml - to spin up multiple docker containers
phpunit.xml        - phpunit test configuration
tests/             - phpunit test cases
Vagrantfile        - to spin up a Virtualbox VM for testing
```

## Running Tests

By default, `vendor/bin/phpunit` will only run unit tests.

Use `vendor/bin/phpunit --group functional` to run the functional tests.
Please ensure Apache is running on localhost.
