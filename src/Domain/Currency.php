<?php

namespace App\Domain;

final class Currency
{
  public const AUD = "AUD";
  public const USD = "USD";
  public const NZD = "NZD";
  public const GBP = "GBP";
  public const EUR = "EUR";

  private const VALID_CURRENCIES = [
    self::USD,
    self::EUR,
    self::NZD,
    self::GBP,
    self::AUD,
  ];

  private string $code;

  /**
   * Construct a new Currency
   * 
   * @param string $code Currency Code (eg: 'AUD', 'usd')
   */
  public function __construct(string $code)
  {
    $trimmedCode = strtoupper(trim($code));

    if (!in_array($trimmedCode, self::VALID_CURRENCIES)) {
      throw new \InvalidArgumentException("Invalid Currency Code");
    }

    $this->code = $trimmedCode;
  }

  /**
   * Return Currency Code
   */
  public function getCode(): string
  {
    return $this->code;
  }
}
