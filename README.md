# CurrencyConverter
Chrencyconverter application with Symfony and CurrencyLayer API
This application has been developed to test CurrencyLayer API
to change EURO to USD and FRANC currency values.

### Following framework/tools have been used to achieve purpose of application
- Symfony 3.4
- php 7.1
- mysql 5.7
- CurrencyLayer API (http://https://currencylayer.com/)
- oceanapplications/currencylayer-php-client SDK

### To start the application:
- Install php 7.1
- mysql 5.7
- composer package manager
- Signup a user account at (http://https://currencylayer.com/)
- Get the API key

### Use following scripts to execute the application
- Add API key under parameters with key(currency.api_key):API_KEY
- `composer install`
- `bin/console s:r` or `bin/console server:run`
- Access the application at localhost:8000

### Custom commands:
- `app:resetdb:fetch:currency`: It will reset db and fetch currency values from API and save in db
