<?php

namespace App\Domain;

use App\Domain\ConversionResult;

class ProfitCalculator
{
  private const CONFIG_FLOAT_PRECISION = 2;

  private int $profitPercentage;

  /**
   * @param int $profitPercentage Default percentage in 15
   */
  public function __construct(int $profitPercentage = 15)
  {
    $this->profitPercentage = $profitPercentage;
  }

  /**
   * Return total profit in AUD currency from all conversions
   * 
   * @param ConversionResult[] $results
   */
  public function getTotalProfit(array $results)
  {
    if (empty($results)) {
      return 0.0;
    }

    $totalProfit = 0.0;

    foreach ($results as $result) {
      $audAmount = $this->getAudAmount($result);
      $profit = $this->calculateProfit($audAmount);
      $totalProfit += $profit;
    }

    return round($totalProfit, self::CONFIG_FLOAT_PRECISION);
  }

  /**
   * Return AUD amount from either side of the conversion
   * 
   * Assumption: we only convert foreign currency to AUD and vice-versa
   * 
   * Example:
   *  USD -> AUD, return AUD amount
   *  AUD -> USD, return  AUD amount
   */
  private function getAudAmount(ConversionResult $result): float
  {
    $original = $result->getOriginal();
    $converted = $result->getConverted();

    if ($original->getCurrency()->getCode() === CURRENCY::AUD) {
      return $original->getAmount();
    }

    if ($converted->getCurrency()->getCode() === CURRENCY::AUD) {
      return $converted->getAmount();
    }

    return 0.0;
  }

  /**
   * Return Profit Amount
   */
  private function calculateProfit(float $amount): float
  {
    return round($amount * $this->profitPercentage / 100, self::CONFIG_FLOAT_PRECISION);
  }
}