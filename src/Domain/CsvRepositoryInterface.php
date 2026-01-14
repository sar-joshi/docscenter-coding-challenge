<?php

namespace App\Domain;

interface CsvRepositoryInterface
{
  /**
   * Save a new conversion
   */
  public function save(ConversionResult $conversionResult): void;

  /**
   * Return all converted values
   * 
   * @return ConversionResult[]
   */
  public function findAll(): array;
}
