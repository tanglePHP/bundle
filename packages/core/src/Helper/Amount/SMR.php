<?php namespace tanglePHP\Core\Helper\Amount;

use tanglePHP\Core\Models\AbstractAmount;

/**
 * Class SMR
 *
 * @package      tanglePHP\Core\Helper\Amount
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1654
 */
final class SMR extends AbstractAmount {
  /**
   * @var string
   */
  protected string $unit = "SMR";
  /**
   * @var array|int[]
   */
  protected array $units = [
    'glow' => 1,
    'smr'  => 1000000,
  ];
  /**
   * max token supply
   *
   * @var int
   */
  protected int $max = 1450896407249092;

  /**
   * Convert Amount to smr
   *
   * @return string
   */
  public function toSMR(): string {
    return $this->calcTo('smr');
  }

  /**
   * Convert Amount to glow
   *
   * @return string
   */
  public function toGlow(): string {
    return $this->calcTo('glow');
  }
}