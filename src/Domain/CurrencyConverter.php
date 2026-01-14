<?php

namespace App\Domain;

class CurrencyConverter
{
  private const RATES_TO_AUD = [
    Currency::AUD => 1.0,
    Currency::USD => 1.5,
    Currency::NZD => 0.9,
    Currency::GBP => 1.7,
    Currency::EUR => 1.5,
  ];

  private CurrencyAmount $amount;
  private Currency $targetCurrency;

  /**
   * Convert currency amount using available exchange rates
   * 
   * @param CurrencyAmount $amount
   * @param Currency $targetCurrency
   */
  public function __construct(CurrencyAmount $amount, Currency $targetCurrency)
  {
    $this->amount = $amount;
    $this->targetCurrency = $targetCurrency;
  }

  /**
   * Convert currency amount to another currency
   * 
   * @return CurrencyAmount Converted amount
   */
  public function convert(): CurrencyAmount
  {
    $rate = $this->getRate();
    $finalAmount = $this->amount->getAmount() * $rate;

    return new CurrencyAmount($finalAmount, $this->targetCurrency);
  }

  /**
   * Return exchange rate
   * 
   * @return float
   */
  public function getRate(): float
  {
    $from = $this->amount->getCurrency();
    $fromCode = $from->getCode();
    $toCode = $this->targetCurrency->getCode();

    // Handle equal currency rate
    if ($fromCode === $toCode) {
      return 1.0;
    }

    $fromRate = self::RATES_TO_AUD[$fromCode];
    $toRate = self::RATES_TO_AUD[$toCode];

    return $fromRate / $toRate;
  }
}