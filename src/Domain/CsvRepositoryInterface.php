<?php

namespace App\Domain;

use Generator;

interface CsvRepositoryInterface
{
  /**
   * Save a new conversion
   */
  public function save(ConversionResult $conversionResult): void;

  /**
   * Return all converted values
   * 
   * @return Generator<ConversionResult>
   */
  public function findAll(): Generator;
}
