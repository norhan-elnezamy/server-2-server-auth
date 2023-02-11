# Private connection signature.

This package allows you to easily secure your private connection between servers by creating a signature and validating user signature by using a shared private hashing key and algorithm type.

## Installation

You can install the package via composer:
Update `composer.json` with the following

```json
"require": {
     ...
    "auth/signed-request": "dev-develop"
},
"repositories": [
    ...
    {
        "type": "git",
        "url": "https://github.com/norhan-elnezamy/server-2-server-auth"
    }
]
```

Then update your composer dependencies

``` bash
composer update
```

## Configs

- Publish config files:

    ``` bash
    php artisan vendor:publish --provider="Auth\SignedRequest\SignedRequestServiceProvider"
    ```

- Add integration key and sha type into your .env file.


## Usage

- Create a data signature example:
  ```php
  $data = [
      'name' => 'Michel',
      'age' => 30
      'birthdate' => '1880-01-01'
  ];
  
  $signature = new Auth\SignedRequest\Classes\Signature();
  $authSignature = $dataSignature->create($data);
  
  ```

- Validate data signature example:
  - By adding Signature middleware ``` \Auth\SignedRequest\Http\Middleware\ValidateSignature::class ``` into $routeMiddleware which in HTTP kernel file, then use the middleware name over your connection routes to validate request header signature.
  
  - ####OR Handle it manually
  ```php
  try {
  
      $signature = new Auth\SignedRequest\Classes\Signature();
      $signature->validate($data, $userSignature);
  
      // User signature is passed
  
  } catch (Exception $e) {
      // throwing exception with message "Mismatch signature"
  }
  ```