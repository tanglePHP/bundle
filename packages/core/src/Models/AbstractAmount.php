<?php namespace tanglePHP\Core\Models;

use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class AbstractAmount
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1650
 */
abstract class AbstractAmount {
  /**
   * @var int
   */
  protected int $amount;
  /**
   * @var string
   */
  protected string $unit;
  /**
   * @var array
   */
  protected array $units;
  /**
   * @var int
   */
  protected int $max;

  /**
   * @param int|string|AbstractAmount $amount
   *
   * @throws HelperException
   */
  public function __construct(int|string|AbstractAmount $amount) {
    $this->parseInput($amount);
  }

  /**
   * @param int|string $amount
   *
   * @return void
   * @throws HelperException
   */
  protected function parseInput(int|string $amount): void {
    if(is_numeric($amount)) {
      $this->amount = $amount;
      //
      $this->checkMaxSupply();

      return;
    }
    // strtplower amount
    $amount = strtolower($amount);
    // check unit and amount can be found
    preg_match('/^([0-9]+\.{1}?[0-9]*|[0-9]+,{1}?[0-9]*|\d*)(\w*)/', $amount, $match);
    if(isset($match[1]) && !empty($match[1])) {
      $unit = strtolower($match[2]);
      //
      if(!array_key_exists($unit, $this->units)) {
        throw new HelperException("Unknown unit '$unit' input: '$amount'");
      }
      //
      $this->amount = $match[1] * $this->units[$unit];
      //
      $this->checkMaxSupply();

      return;
    }
    throw new HelperException("Unknown amount '$amount'");
  }

  /**
   * @return void
   * @throws HelperException
   */
  protected function checkMaxSupply(): void {
    if($this->amount > $this->max) {
      throw new HelperException("Amount '$this->amount' is higher than max possible '$this->max'");
    }
  }

  /**
   * @return int
   */
  public function getAmount(): int {
    return $this->amount;
  }

  /**
   * @return string
   */
  public function getUnit(): string {
    return $this->unit;
  }

  /**
   * @return array
   */
  public function getUnits(): array {
    return $this->units;
  }

  /**
   * @param $to
   *
   * @return string
   */
  protected function calcTo($to): string {
    $ret = rtrim(bcdiv($this->amount, $this->units[$to], 15), 0);

    return (str_ends_with($ret, '.') ? substr($ret, 0, -1) : $ret) . $to;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return (string)$this->getAmount();
  }
}