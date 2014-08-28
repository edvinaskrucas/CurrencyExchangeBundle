# Test Task - CurrencyExchangeBundle

## Installation

Just place require new package for your symfony installation via composer.json

    "krucas/currencyexhangebundle": "dev-master"

Then hit ```composer update```

### Register bundle in symfony2 installation

Add bundle to your bundles list

```php
new Krucas\CurrencyExchangeBundle\KrucasCurrencyExchangeBundle()
```

### Available config params

* krucas_currency_exchange.class.service.rate - Rate service class name
* krucas_currency_exchange.class.service.manager - Rate manager class name
* krucas_currency_exchange.class.storage.rate - Rate storage class name
* krucas_currency_exchange.storage.doctrine.table - Table name for doctrine storage
* krucas_currency_exchange.refreshRate - Refresh rate in seconds for cache
* krucas_currency_exchange.providers - Rate provider class names

## Usage

### Commands

* currency:rates - Return array of rates. Accepts two params: from-currency, to-currency
* currency:rate:best - Return best rate. Accepts two params: from-currency, to-currency