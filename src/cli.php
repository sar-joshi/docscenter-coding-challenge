<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Domain\Currency;
use App\Domain\CurrencyAmount;
use App\Domain\CurrencyConverter;

try {
  $args = array_slice($argv, 1);
  $actionType = array_shift($args);

  [$amount, $sourceCurrency, $targetCurrency] = $args;

  if (count($args) !== 3) {
    echo "\nExample Args: 100 USD AUD\n";
    return 1;
  }

  switch ($actionType) {
    case "convert":
      $originalAmount = new CurrencyAmount(
        (float) $amount,
        new Currency($sourceCurrency)
      );

      $converter = new CurrencyConverter(
        $originalAmount,
        new Currency($targetCurrency)
      );

      $conversionResult = $converter->convert();
      $formattedOriginalAmount = sprintf('%.2f %s', $originalAmount->getAmount(), $originalAmount->getCurrency()->getCode());
      $formattedConvertedAmount = sprintf('%.2f %s', $conversionResult->getConverted()->getAmount(), $conversionResult->getConverted()->getCurrency()->getCode());

      echo "\n";
      echo "Original: {$formattedOriginalAmount}\n";
      echo "Converted: {$formattedConvertedAmount}\n";

      # TODO: save to csv
      break;
    case "calculate-profit":
      # TODO
      break;
    default:
      echo "Invalid Command";
      exit(1);
  }
} catch (Exception $e) {
  echo $e->getMessage() . "";
  exit(1);
}