<?php

namespace App\Infrastructure;

use League\Csv\Writer;
use League\Csv\Reader;

use App\Domain\Currency;
use App\Domain\CurrencyAmount;
use App\Domain\ConversionResult;
use App\Domain\CsvRepositoryInterface;

class CsvRepository implements CsvRepositoryInterface
{
  private string $csvFile;

  /**
   * @param string $csvFile Path to the CSV file
   */
  public function __construct(string $csvFile)
  {
    $this->csvFile = $csvFile;
  }

  public function save(ConversionResult $conversionResult): void
  {
    $this->setupFileAndFolder();

    $csv = Writer::createFromPath($this->csvFile, 'a+');

    $csv->insertOne([
      $conversionResult->getOriginal()->csvFormatted(),
      $conversionResult->getConverted()->csvFormatted(),
    ]);
  }

  /**
   * Return data from CSV file
   * 
   * @return ConversionResult[]
   */
  public function findAll(): array
  {
    if (!file_exists($this->csvFile)) {
      return [];
    }

    $results = [];
    $csv = Reader::createFromPath($this->csvFile, 'r');

    foreach ($csv->getRecords() as $record) {
      $original = explode(",", $record[0]);
      $converted = explode(",", $record[1]);

      $results[] = new ConversionResult(
        new CurrencyAmount((float) $original[0], new Currency($original[1])),
        new CurrencyAmount((float) $converted[0], new Currency($converted[1])),
      );
    }

    return $results;
  }

  /**
   * Ensure the directory and file exist before writing.
   */
  private function setupFileAndFolder(): void
  {
    $directory = dirname($this->csvFile);
    if (!is_dir($directory)) {
      mkdir($directory, 0755, true);
    }

    if (!file_exists($this->csvFile)) {
      touch($this->csvFile);
    }
  }
}