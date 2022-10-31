<?php namespace tanglePHP\Core\Helper\Amount;

use tanglePHP\Core\Models\AbstractAmount;

/**
 * Class IOTA
 *
 * @package      tanglePHP\Core\Helper\Amount
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1653
 */
final class IOTA extends AbstractAmount {
  /**
   * @var string
   */
  protected string $unit = "IOTA";
  /**
   * @var array|int[]
   */
  protected array $units = [
    'i'  => 1,
    'ki' => 1000,
    'mi' => 1000000,
    'gi' => 1000000000,
    'ti' => 1000000000000,
    'pi' => 1000000000000000,
  ];
  /**
   * max token supply
   *
   * @var int
   */
  protected int $max = 2779530283277761;

  /**
   * Convert Amount to Pi
   *
   * @return string
   */
  public function toPi(): string {
    return $this->calcTo('pi');
  }

  /**
   * Convert Amount to Ti
   *
   * @return string
   */
  public function toTi(): string {
    return $this->calcTo('ti');
  }

  /**
   * Convert Amount to Gi
   *
   * @return string
   */
  public function toGi(): string {
    return $this->calcTo('gi');
  }

  /**
   * Convert Amount to Mi
   *
   * @return string
   */
  public function toMi(): string {
    return $this->calcTo('mi');
  }

  /**
   * Convert Amount to Ki
   *
   * @return string
   */
  public function toKi(): string {
    return $this->calcTo('ki');
  }

  /**
   * Convert Amount to i
   *
   * @return string
   */
  public function toi(): string {
    return $this->calcTo('i');
  }
}