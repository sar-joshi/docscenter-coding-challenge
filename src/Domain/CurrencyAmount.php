<?php

namespace App\Domain;

final class CurrencyAmount
{
  private float $amount;
  private Currency $currency;

  /**
   * Construct a new CurrencyAmount
   * 
   * @param float $amount
   * @param Currency $currency
   * @throws \InvalidArgumentException
   */
  public function __construct(float $amount, Currency $currency)
  {
    if ($amount < 0) {
      throw new \InvalidArgumentException("Error: Negative Amount");
    }

    $this->amount = round($amount, 2); # rounding to 2 decimal point
    $this->currency = $currency;
  }

  /**
   * Return Amount
   */
  public function getAmount(): float
  {
    return $this->amount;
  }

  /**
   * Return Currency
   */
  public function getCurrency(): Currency
  {
    return $this->currency;
  }

  /**
   * Format for amounts. e.g, "100.00 AUD"
   */
  public function csvFormatted(): string
  {
    return "{$this->amount}, {$this->currency->getCode()}";
  }
}
