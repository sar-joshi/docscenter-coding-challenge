# docscenter-coding-challenge

A PHP currency converter and profit calculator.

## Assumptions
- At least one currency must be AUD for conversion
- Profit is calculated based on AUD currency regardless of Source or Targert Currency

## Design Decisions
- Using PSR-4 for autoloading classess
- Using external PHP package for CSV operations (https://github.com/thephpleague/csv)
- Curreny and CurrencyAmount are Value Objects for immutability
- CsvRepositoryInterface for abstraction
- Repository separated from business logic
- Dependencies are passed through constructor

## Getting Started

Instructions to get the application up and running on you local setup.

### Pre-requisite
- PHP >7.4.x with Composer
- Docker & Docker compose

### Setup

Using Docker
```bash
  docker compose build
```

### Currency Conversion
```bash
  docker compose run --rm app convert 100 USD AUD
```

### Profit Calculation
```bash
  docker compose run --rm app calculate-profit
```




