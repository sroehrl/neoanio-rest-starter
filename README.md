# Basic neoan.io Lenkrad REST-API starter kit with authentication

This is a very light project setup designed to get your REST-api up and running in no time.

## Requirements

- php8.1
- composer ^2
- SQLite

## Installation

`composer create-project neoan.io/rest-api-starter-project my-app`

`cd my-app`

`composer update`

`php install`

To run:
`php dev`

The, visit `http://127.0.0.1:8080`

## Basic tutorial

This project ships with a basic tutorial to get you started. For deeper understanding, please visit the lenkrad docs:
[neoan.io lenkrad](https://github.com/sroehrl/neoan.io-lenkrad-core#neoanio-lenkrad-core)

## Authentication
After installation, you can register a user against POST /api/auth/register (src/Auth/Api/Register.php) with a payload containing email and password:

> curl -X POST -H "Content-Type: application/json"  -d '{"email": "my@mail.com", "password": "123456"}'  http://127.0.0.1:8080/api/auth/register

Authenticated calls will require the provided JWT-token

The login endpoint is `/api/auth/authenticate` (src/Auth/Api/Authenticate.php) and the endpoint `/api/auth/me` (src/Auth/Api/Me.php) returns the current user.

## Restricting routes

Middleware can be chained prior to routes in the respective Attributes (see src/Auth/Api/ME.php for clarification)

## Understanding the capabilities

The folder src/Example should give you a good starting point for intuitive understanding of how the LENKRAD core is used in this starter.
Be aware that you are completely free regarding structure. What you find in this starter is a mere example.

## Security / Before you deploy

Your checklist:

- .env file update
- folder src/Example necessary?
- is only the folder /public exposed to the web?

## Change from SQLite to MySQL or MariaDB

First, add the following information to your .env file

- DB_HOST 
- DB_NAME
- DB_USER
- DB_PASSWORD
- DB_CHARSET
- DB_PORT

Make sure that the selected database is created. Then, change the constructor of `config/Database.php` to use the method
`useMySql` instead of `useSQLite`.

When migrating, use the dialect keyword `mysql` instead of `sqlite`:

`php cli migrate:models mysql`
