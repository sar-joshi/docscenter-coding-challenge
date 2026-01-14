<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use App\Domain\Currency;
use App\Domain\CurrencyAmount;
use App\Domain\CurrencyConverter;
use App\Domain\ProfitCalculator;
use App\Infrastructure\CsvRepository;

# CSV file path
$csvFilePath = __DIR__ . "/../data/conversions.csv";

try {
  $args = array_slice($argv, 1);
  $actionType = array_shift($args);

  [$amount, $sourceCurrency, $targetCurrency] = $args;

  switch ($actionType) {
    case "convert":
      if (count($args) !== 3) {
        echo "\nError: Not enough arguments. Example Args: 100 USD AUD\n";
        return 1;
      }

      $originalAmount = new CurrencyAmount((float) $amount, new Currency($sourceCurrency));
      $converter = new CurrencyConverter($originalAmount, new Currency($targetCurrency));
      $conversionResult = $converter->convert();

      echo "\n";
      echo "Original Amount: " . str_replace(",", "", $conversionResult->getOriginal()->csvFormatted()) . "\n";
      echo "Converted Amount: " . str_replace(",", "", $conversionResult->getConverted()->csvFormatted()) . "\n";

      # Save result to CSV
      $csvRepository = new CsvRepository($csvFilePath);
      $csvRepository->save($conversionResult);

      break;
    case "calculate-profit":
      $csvRepository = new CsvRepository($csvFilePath);
      $conversionResults = $csvRepository->findAll();

      $profitCalculator = new ProfitCalculator();
      $totalProfit = $profitCalculator->getTotalProfit($conversionResults);

      echo "\n";
      echo "Total Profit: {$totalProfit} AUD";

      break;
    default:
      echo "Invalid Command";
      exit(1);
  }
} catch (InvalidArgumentException $e) {
  echo $e->getMessage() . "";
  exit(1);
} catch (Exception $e) {
  echo $e->getMessage() . "";
  exit(1);
}
