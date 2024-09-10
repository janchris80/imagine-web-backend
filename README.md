## Features
- JWT authentication (login, register)

## Installation

> Note: the application does not have a `package.json` since this project purely a REST API that will not use any
> JavaScript or asset builders such as Vite.

1. `cp .env.example .env`
2. `composer install`
3. `php artisan jwt:secret` (generate a secret key that will be used to sign your tokens)
4. `php artisan migrate:fresh --seed`

## User authentication

In order to authenticate, you have to log in using valid credentials. User data and an access token will be returned.
You can use this access token to do subsequent requests to the API.

The access token has a TTL of 1 hour until it expires. The access token should be refreshed within this time window to
avoid becoming unauthenticated.

The access token can be refreshed for two weeks. After that, the user has to log in again.
