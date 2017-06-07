The Code is deployed in AWS instance. The base URL is `http://54.169.110.200/`

## Requirement

> PHP 7

> Mysql >= 5.6

> Composer

## Steps

> Clone the code base

> run `npm install`

> run `composer install` in terminal

> copy `env.example` as `.env` and change the database configuration

> run `npm run dev`

## Folder Structure
- `app/Contracts` Contains all the interfaces used in various classes
- `app/Exceptions` Contains the custom exception classes
- `app/Http/Controllers` Contains the Controllers
- `app/Http/Middeware` Contains the middleware for the HTTP request
- `app/Http/Requests` Contains the Request validation classes
- `app/Models` Contains all the Models
- `app/Providers/AppServiceProvider.php` has the code for bootstraping various classes and objects, 
binding between interface and models.
- `app/Transformers` contains all the transformers used to transform data before sending response.
- `app/Utils` contains additional classes used to support the app.
- `helpers/` contains the required helper function for the app.
- `resources/lang/en/api.php` has the code for translation..
- `resources/assets` has the necessary javascripts and css files
- `resources/views` has the necessary views.
- `routes/api.php` has the code for api routing

## Postman Collection Link
    https://www.getpostman.com/collections/1da94dbbb5eb87b9ca37

## API

All apis are prefixed with `/api/v1`

All Api should have the following request headers

    Content-Type : application/json
    Accept: application/json
    Cookie-Id: <a unique cookie to identify the user>

- GET `/notes`:
    
    List the notes.

- GET `/notes/{note uuid}`:
    
    Get a specific notes details

- POST `/notes`:
    
    Create notes. Params:
        
        - title
        - notes

- PUT `/notes/<notes uuid>`:
    
    Update a note. Params:
        
        - title
        - notes

- DELETE `/notes/<notes uuid>`:

    Delete a note.
