<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

use App\Domain\Currency;
use App\Domain\CurrencyAmount;
use App\Domain\CurrencyConverter;
use App\Domain\ConversionResult;
use App\Domain\ProfitCalculator;

class CoreLogicTest extends TestCase
{
  public function testAudToForeignCurrencyCoversion(): void
  {
    $originalAmount = new CurrencyAmount(100, new Currency(Currency::USD));
    $converter = new CurrencyConverter($originalAmount, new Currency(Currency::AUD));
    $result = $converter->convert()->getConverted();

    $this->assertEquals(150.00, $result->getAmount());
    $this->assertEquals(Currency::AUD, $result->getCurrency()->getCode());
  }

  public function testProfitCalculator(): void
  {
    $conversionResults = [
      new ConversionResult(
        new CurrencyAmount(100, new Currency(Currency::USD)),
        new CurrencyAmount(150, new Currency(Currency::AUD)),
      ),
      new ConversionResult(
        new CurrencyAmount(100, new Currency(Currency::EUR)),
        new CurrencyAmount(150, new Currency(Currency::AUD)),
      ),
      new ConversionResult(
        new CurrencyAmount(100, new Currency(Currency::GBP)),
        new CurrencyAmount(170, new Currency(Currency::AUD)),
      ),
      new ConversionResult(
        new CurrencyAmount(170, new Currency(Currency::AUD)),
        new CurrencyAmount(100, new Currency(Currency::GBP)),
      ),
    ];

    $profitCalculator = new ProfitCalculator(); # default profit = 15%
    $totalProfit = $profitCalculator->getTotalProfit($conversionResults);

    $this->assertEquals($totalProfit, 96);
  }

  public function testNegativeAmountThrowsException(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    new CurrencyAmount(-560, new Currency(Currency::USD));
  }

  public function testInvalidCurrencyCodeThrowsExecption(): void
  {
    $this->expectException(\InvalidArgumentException::class);
    new Currency("TEST");
  }
}