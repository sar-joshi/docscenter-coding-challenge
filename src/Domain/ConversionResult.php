<?php

namespace App\Domain;

final class ConversionResult
{
  private CurrencyAmount $original;
  private CurrencyAmount $converted;

  /**
   * Construct a new ConversionResult
   * 
   * @param CurrencyAmount $original Original/Source amount
   * @param CurrencyAmount $converted Converted amount based on target currency rate
   */
  public function __construct(CurrencyAmount $original, CurrencyAmount $converted)
  {
    $this->original = $original;
    $this->converted = $converted;
  }

  /**
   * Return Original Amount
   * 
   * @return CurrencyAmount
   */
  public function getOriginal(): CurrencyAmount
  {
    return $this->original;
  }

  /**
   * Retrun Converted Amount
   * 
   * @return CurrencyAmount
   */
  public function getConverted(): CurrencyAmount
  {
    return $this->converted;
  }
}