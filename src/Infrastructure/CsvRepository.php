<?php

namespace App\Infrastructure;

use League\Csv\Writer;

use App\Domain\CsvRepositoryInterface;
use App\Domain\ConversionResult;

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

  public function findAll(): array
  {
    # TODO: Implement this method
    return [];
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